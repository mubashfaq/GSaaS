<?php

namespace Workdo\Xero\Http\Controllers;

use App\Models\Setting;
use Workdo\Account\Entities\ChartOfAccount;
use  Workdo\Account\Entities\ChartOfAccountType;
use Workdo\Xero\Entities\XeroChartOfAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class XeroController extends Controller
{

    public $base_url;

    public function __construct()
    {
        $this->base_url = "https://api.xero.com/api.xro/2.0/";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('xero::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('xero::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('xero::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('xero::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function saveXeroSettings(Request $request)
    {
        if (Auth::user()->isAbleTo('xero manage')) {

            if ($request->has('xero_is_on')) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'xero_client_id' => 'required|string',
                        'xero_client_secretkey' => 'required|string',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
            }

            $post = $request->all();
            unset($post['_token']);
            unset($post['_method']);

            if ($request->has('xero_is_on')) {
                foreach ($post as $key => $value) {
                    // Define the data to be updated or inserted
                    $data = [
                        'key' => $key,
                        'workspace' => getActiveWorkSpace(),
                        'created_by' => creatorId(),
                    ];

                    // Check if the record exists, and update or insert accordingly
                    Setting::updateOrInsert($data, ['value' => $value]);
                }
            } else {
                // Define the data to be updated or inserted
                $data = [
                    'key' => 'xero_is_on',
                    'workspace' => getActiveWorkSpace(),
                    'created_by' => creatorId(),
                ];

                // Check if the record exists, and update or insert accordingly
                Setting::updateOrInsert($data, ['value' => 'off']);
            }
            // Settings Cache forget
            comapnySettingCacheForget();

            return redirect()->back()->with('success', 'Xero setting save sucessfully.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function xeroGettoken(Request $request)
    {

        $setting = getCompanyAllSetting();

        if (isset($setting['xero_is_on']) && ($setting['xero_is_on'] == 'on')) {
            $authUrl = 'https://login.xero.com/identity/connect/authorize?' . http_build_query([
                'response_type' => 'code',
                'client_id' => $setting['xero_client_id'],
                'redirect_uri' => route('xero.callback'),
                'scope' => 'openid profile email accounting.contacts accounting.transactions accounting.transactions.read accounting.settings',
                'state' => csrf_token(),
            ]);
            return redirect($authUrl);
        } else {
            return redirect()->route('settings.index')->with('error', __('Please Enable first Xero then after genrate token'));
        }
    }

    public function xeroCallback(Request $request)
    {

        if (isset($request->code)) {
            $setting = getCompanyAllSetting();

            if ($request->input('state') !== csrf_token()) {
                abort(401, 'Unauthorized');
            }

            // Obtain the authorization code
            $code = $request->input('code');

            // Exchange the authorization code for an access token
            $response = \Http::asForm()->post('https://identity.xero.com/connect/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'client_id' => $setting['xero_client_id'],
                'client_secret' => $setting['xero_client_secretkey'],
                'redirect_uri' => route('xero.callback'),
            ]);
            $json = json_decode($response);


            $response = \Http::withHeaders([
                'Authorization' => 'Bearer ' . $json->access_token, 'Content-Type' => 'application/json'
            ])->get('https://api.xero.com/connections');
            if ($response->successful()) {
                $organizations = $response->json();

                $post = [];
                $post['xero_tenant_id'] = $organizations[0]['tenantId'];
                $post['xero_access_token'] = $json->access_token;
                $post['xero_refresh_token'] = $json->refresh_token;

                $getActiveWorkSpace = getActiveWorkSpace();
                $creatorId          = creatorId();
                foreach ($post as $key => $value) {
                    // Define the data to be updated or inserted
                    $data = [
                        'key' => $key,
                        'workspace' => $getActiveWorkSpace,
                        'created_by' => $creatorId,
                    ];

                    // Check if the record exists, and update or insert accordingly
                    Setting::updateOrInsert($data, ['value' => $value]);
                }
                return redirect()->route('settings.index')->with('success', __('Xero Token Genrated successfully'));
            } else {

                return redirect()->route('settings.index')->with('error', 'Failed to fetch organization data. Error: ' . $response->status());
            }

            $data = $response->json();
        } else {
            return redirect()->back()->with('error', __('Permission Denied'));
        }
    }

    public static function refreshAccessToken($refreshToken)
    {
        $setting = getCompanyAllSetting();


        // Your client ID and client secret
        $client_id = $setting['xero_client_id'];
        $client_secret = $setting['xero_client_secretkey'];

        // Your refresh token
        $refresh_token = $setting['xero_refresh_token'];
        // Encode client_id and client_secret in base64
        $credentials = base64_encode($client_id . ':' . $client_secret);


        // API endpoint
        $url = 'https://identity.xero.com/connect/token';

        // Data to send in the request
        $data = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        );

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . $credentials,
            'Content-Type: application/x-www-form-urlencoded'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);
        $response = json_decode($response);
        // Display response
        if (isset($response->access_token)) {
            return $response->access_token;
        } else {
            return false;
        }
    }

    public static function sendQuickBooksRequest($method, $url, $refreshToken, $data = null)
    {
        $setting = getCompanyAllSetting();
        if (isset($setting['xero_is_on']) && ($setting['xero_is_on'] == 'on')) {
            $tenantid    = $setting['xero_tenant_id'];
            $accessToken = Self::refreshAccessToken($refreshToken);

            if ($accessToken != false) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => !empty($data) ? json_encode($data) : "",
                    CURLOPT_HTTPHEADER => array(
                        'xero-tenant-id: ' . $tenantid,
                        'Accept: application/json',
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $accessToken
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);
                return $response;

            } else {
                return false;
            }
        }
    }


    public function ChartofAccountSync()
    {
        $setting = getCompanyAllSetting();
      
        if (isset($setting['xero_is_on']) && ($setting['xero_is_on'] == 'on')) {
            if (isset($setting['xero_refresh_token'])) {
                $refreshToken = $setting['xero_refresh_token'];
                $paymenturl   = $this->base_url . "Accounts";

                $chartaccount = $this->base_url . "ChartOfAccounts";

                $account_data = ChartOfAccount::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->select('name', 'id')->get()->toArray();
                $searchNames  = array_column($account_data, 'name');
                $itemResponse = self::sendQuickBooksRequest('GET', $paymenturl, $refreshToken);
                $xeroitem     = [];
                if (isset($itemResponse->Accounts)) {
                    foreach ($itemResponse->Accounts as $item) {
                        if (in_array($item->Name, $searchNames)) {
                            $xeroitem[]   = $item->Name;
                            $account_data = ChartOfAccount::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->where('name', $item->Name)->first();
                            $xeroaccount  = XeroChartOfAccount::where('chartofaccount_id', $account_data->id)->first();

                            if (!isset($xeroaccount->xero_id) && !isset($xeroaccount->xero_code)) {
                                $xeroaccount                    = new XeroChartOfAccount();
                                $xeroaccount->chartofaccount_id = $account_data->id;
                                $xeroaccount->xero_id           = $item->AccountID;
                                $xeroaccount->xero_code         = $item->Code;
                                $xeroaccount->workspace         = getActiveWorkSpace();
                                $xeroaccount->created_by        = creatorId();
                                $xeroaccount->save();
                            }
                        } else {
                            $type    = XeroChartOfAccount::gettype($item->Class);
                            $subtype = XeroChartOfAccount::getsubtype($type, $item->Type);

                            $chartofaccount             = new ChartOfAccount();
                            $chartofaccount->name       = $item->Name;
                            $chartofaccount->type       = $type;
                            $chartofaccount->sub_type   = $subtype;
                            $chartofaccount->is_enabled = 1;
                            $chartofaccount->workspace  = getActiveWorkSpace();
                            $chartofaccount->created_by = creatorId();
                            $chartofaccount->save();

                            $xeroaccount                    = new XeroChartOfAccount();
                            $xeroaccount->chartofaccount_id = $account_data->id;
                            $xeroaccount->xero_id           = $item->AccountID;
                            $xeroaccount->xero_code         = $item->Code;
                            $xeroaccount->workspace         = getActiveWorkSpace();
                            $xeroaccount->created_by        = creatorId();
                            $xeroaccount->save();

                            $xeroitem[] = $item->Name;
                        }
                    }

                    $account_datas = ChartOfAccount::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->whereNotIn('name', $xeroitem)->get();
                    $datadetail    = [];
                    foreach ($account_datas as $account_data) {
                        $accounttype = ChartOfAccountType::where('id', $account_data->type)->first();

                        $type = '';
                        if (isset($accounttype) && $accounttype->name == 'Assets') {
                            $type = 'ASSET';
                        } elseif (isset($accounttype) && $accounttype->name == 'Equity') {
                            $type = 'EQUITY';
                        } elseif (isset($accounttype) && $accounttype->name == 'Expenses') {
                            $type = 'EXPENSE';
                        } elseif (isset($accounttype) && $accounttype->name == 'Liabilities') {
                            $type = 'LIABILITY';
                        } elseif (isset($accounttype) && $accounttype->name == 'Income') {
                            $type = 'REVENUE';
                        }
                        $data_id = [];
                        $data_id = [
                            "Code" => $account_data->code,
                            "Name" => $account_data->name,
                            "Type" => $type,
                            "EnablePaymentsToAccount" => true,
                            "ShowInExpenseClaims" => true
                        ];

                        $datadetail[] = $data_id;
                    }

                    foreach ($datadetail as $data) {
                        $insertinvoice = self::sendQuickBooksRequest('PUT', $paymenturl, $refreshToken, $data);

                        $chartofaccounts = ChartOfAccount::where('name', $data['Name'])->get();
                        if (isset($insertinvoice->Accounts[0]->AccountID)) {
                            foreach ($chartofaccounts as $chartofaccount) {
                                $xeroaccount                    = new XeroChartOfAccount();
                                $xeroaccount->chartofaccount_id = $account_data->id;
                                $xeroaccount->xero_id           = $insertinvoice->Accounts[0]->AccountID;
                                $xeroaccount->xero_code         = $insertinvoice->Accounts[0]->Code;
                                $xeroaccount->workspace         = getActiveWorkSpace();
                                $xeroaccount->created_by        = creatorId();
                                $xeroaccount->save();
                            }
                        } else {
                            if ($insertinvoice == false) {
                                return redirect()->route('invoice.index')->with('error', 'Your Xero token is expired please regenrate xero Token');
                            }
                        }
                    }

                    return redirect()->back()->with('success', __('Xero Chartofaccount import successfully'));
                } else {
                    if ($itemResponse == false) {
                        return redirect()->route('invoice.index')->with('error', 'Your Xero token is expired please regenrate xero Token');
                    }

                    return redirect()->route('chart-of-account.index')->with('error', __('Sometings Wents Wrong'));
                }
            } else {
                return redirect()->route('chart-of-account.index')->with('error', __('Sometings Wents Wrong'));
            }
        } else {
            return redirect()->route('chart-of-account.index')->with('error', __('Please First genrate xero token the after you can synchronize chart of account '));
        }
    }

    public static function invoiceNumber()
    {
        $latest = company_setting('invoice_starting_number');
        if ($latest == null) {
            return 1;
        } else {
            return $latest;
        }
    }
}
