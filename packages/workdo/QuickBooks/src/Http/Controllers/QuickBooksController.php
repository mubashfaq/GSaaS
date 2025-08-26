<?php

namespace Workdo\QuickBooks\Http\Controllers;

use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Workdo\Account\Entities\ChartOfAccount;
use Workdo\Account\Entities\ChartOfAccountSubType;
use Workdo\Account\Entities\ChartOfAccountType;
use Workdo\QuickBooks\Entities\QuickbookChartOfAccount;
use phpDocumentor\Reflection\Types\Self_;
use PHPUnit\Exception;

class QuickBooksController extends Controller
{
    public $base_url;

    public function set_setting()
    {
        $setting =  getCompanyAllSetting();

        if ($setting['company_quickbook_mode'] == "live") {
            $this->base_url = "https://quickbooks.api.intuit.com";
        } else {
            $this->base_url = "https://sandbox-quickbooks.api.intuit.com";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('quick-books::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        return view('quick-books::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function show($id)
    {
        return view('quick-books::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function edit($id)
    {
        return view('quick-books::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function saveQuickbookSettings(Request $request)
    {

        if (Auth::user()->isAbleTo('quickbooks manage')) {
            if ($request->has('quickbook_is_on')) {
                $validator = Validator::make(
                    $request->all(),
                    [
                        'quickbook_client_id' => 'required',
                        'quickbook_client_secretkey' => 'required',
                        'quickbook_company_id' => 'required',
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
            if ($request->has('quickbook_is_on')) {
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
                    'key' => 'quickbook_is_on',
                    'workspace' => getActiveWorkSpace(),
                    'created_by' => creatorId(),
                ];

                // Check if the record exists, and update or insert accordingly
                Setting::updateOrInsert($data, ['value' => 'off']);
            }

            // Settings Cache forget
            comapnySettingCacheForget();

            return redirect()->back()->with('success', 'QuickBook setting save sucessfully.');

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function gettoken(Request $request)
    {
        $setting = getCompanyAllSetting();

        if (isset($setting['quickbook_is_on']) && ($setting['quickbook_is_on'] == 'on')) {
            try {
                $clientId = $setting['quickbook_client_id'];
                $clientSecret = $setting['quickbook_client_secretkey'];

                $authorizationUrl = 'https://appcenter.intuit.com/connect/oauth2';

                // Define the scopes you need (e.g., read and write access to customer data)
                $scopesarray = ['com.intuit.quickbooks.accounting', 'openid', 'profile', 'email', 'phone', 'address'];
                $scopes = implode(' ', $scopesarray);


                // Redirect URL where the user will be redirected after authorization
                $redirectUri = route('quickbook.callback');

                // Generate a random state parameter for security
                $state = bin2hex(random_bytes(16));


                // Create the authorization URL
                $authorizationUrl .= "?client_id=$clientId&scope=$scopes&redirect_uri=$redirectUri&response_type=code&state=$state";

                // Redirect the user to the authorization URL for consent
                header("Location: $authorizationUrl");
                exit();
            } catch (\Exception $e) {
                return redirect()->route('settings.index')->with('error', __('SomeThing Went Wrong'));
            }
        } else {
            return redirect()->route('settings.index')->with('error', __('Please first enable quickbook setting'));
        }
    }

    public function callback(Request $request)
    {
        if (isset($request->code) && isset($request->state) && isset($request->realmId)) {
            $setting = getCompanyAllSetting();

            // Replace with your QuickBooks client ID and secret key
            $clientId = $setting['quickbook_client_id'];
            $clientSecret = $setting['quickbook_client_secretkey'];

            // QuickBooks OAuth 2.0 token endpoint
            $tokenUrl = 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';

            // Create a Guzzle HTTP client
            $client = new Client();

            // Prepare the request data to exchange the authorization code for an access token
            $data = [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'code' => $request->code,
                    'redirect_uri' => route('quickbook.callback'),
                ],
                'auth' => [
                    $clientId,
                    $clientSecret,
                ],
            ];

            try {
                // Send a POST request to obtain the access token
                $response = $client->post($tokenUrl, $data);

                // Parse the response JSON to get the access token
                $responseData = json_decode($response->getBody(), true);

                // The access token is in $responseData['access_token']
                $refresh_token = $responseData['refresh_token'];

                $getActiveWorkSpace = getActiveWorkSpace();
                $creatorId          = creatorId();
                $data = [
                    'key' => 'quickbook_refresh_token',
                    'workspace' => $getActiveWorkSpace,
                    'created_by' => $creatorId,
                ];


                // Check if the record exists, and update or insert accordingly
                $setting = Setting::updateOrInsert($data, ['value' => $refresh_token]);


                return redirect()->route('settings.index')->with('success', __('Quickbook Token Genrated successfully'));
            } catch (\Exception $e) {
                return redirect()->route('settings.index')->with('error', __('Something Went Wrong'));

            }
        } else {
            return redirect()->route('settings.index')->with('error', __('Please first enable quickbook setting'));
        }
    }

    public function ChartofAccountSync(Request $request)
    {
        $setting = getCompanyAllSetting();

        if(isset($setting['quickbook_refresh_token']))
        {
            $refreshToken = $setting['quickbook_refresh_token'];
            $company_id = $setting['quickbook_company_id'];
            $this->set_setting();

            $paymentCreateUrl = $this->base_url . '/v3/company/' . $company_id . '/query';
            $paymentData = 'Select * from Account';

            $paymentResponse = Self::sendQuickBooksRequest('GET', $paymentCreateUrl, $refreshToken, $paymentData);

            $account_data = ChartOfAccount::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->select('id', 'name')->get()->toArray();
            $searchNames = array_column($account_data, 'name');

            if (isset($paymentResponse->QueryResponse)) {
                $quickbookitem = [];
                foreach ($paymentResponse->QueryResponse->Account as $key => $item) {
                    if (in_array($item->Name, $searchNames)) {
                        $quickbookitem[] = $item->Name;
                        $account_data = ChartOfAccount::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->where('name', $item->Name)->first();
                        $quickbooksaccount = QuickbookChartOfAccount::where('chartofaccount_id', $account_data->id)->first();

                        if (!isset($quickbooksaccount) || empty($quickbooksaccount)) {
                            $quickbooksaccount = new QuickbookChartOfAccount();
                            $quickbooksaccount->chartofaccount_id = $account_data->id;
                            $quickbooksaccount->quickbook_id = $item->Id;
                            $quickbooksaccount->workspace = getActiveWorkSpace();
                            $quickbooksaccount->created_by = creatorId();
                            $quickbooksaccount->save();
                        }
                    } else {
                        if (!isset($item->Classification)) {
                            $item->Classification = "Costs of Goods Sold";
                        }
                        $type = QuickbookChartOfAccount::gettype($item->Classification);
                        $subtype = QuickbookChartOfAccount::getsubtype($type, $item->AccountType);

                        $chartofaccount = new ChartOfAccount();
                        $chartofaccount->name = $item->Name;
                        $chartofaccount->type = $type;
                        $chartofaccount->sub_type = $subtype;
                        $chartofaccount->is_enabled = 1;
                        $chartofaccount->workspace = getActiveWorkSpace();
                        $chartofaccount->created_by = creatorId();
                        $chartofaccount->save();

                        $quickbooksaccount = new QuickbookChartOfAccount();
                        $quickbooksaccount->chartofaccount_id = $chartofaccount->id;
                        $quickbooksaccount->quickbook_id = $item->Id;
                        $quickbooksaccount->workspace = getActiveWorkSpace();
                        $quickbooksaccount->created_by = creatorId();
                        $quickbooksaccount->save();

                        $quickbookitem[] = $item->Name;
                    }
                }

                $account_datas = ChartOfAccount::where('created_by', '=', creatorId())->where('workspace', getActiveWorkSpace())->whereNotIn('name', $quickbookitem)->get();
                $datadetail = [];
                foreach ($account_datas as $account_data) {
                    $accounttype = ChartOfAccountType::where('id', $account_data->type)->first();
                    $accountsubtype = ChartOfAccountSubType::where('id', $account_data->sub_type)->first();

                    $type = '';
                    if ($accounttype->name == "Assets" || $accounttype->name == "Current Asset") {
                        $type = "Asset";
                    } elseif ($accounttype->name == "Equity") {
                        $type = "Equity";
                    } elseif ($accounttype->name == "Expenses") {
                        $type = "Expense";
                    } elseif ($accounttype->name == "Liabilities") {
                        $type = "Liability";
                    } elseif ($accounttype->name == "Income") {
                        $type = "Revenue";
                    } else {
                        $type = $accounttype->name;
                    }

                    if ($accountsubtype->name == "Current Asset" || $accountsubtype->name == "Inventory Asset" || $accountsubtype->name == "Share Capital") {
                        $accountsubtype->name = "Other Current Asset";
                    } elseif ($accountsubtype->name == "Non-current Asset") {
                        $accountsubtype->name = "Fixed Asset";
                    } elseif ($accountsubtype->name == "Current Liabilities") {
                        $accountsubtype->name = "Accounts Payable";
                    } elseif ($accountsubtype->name == "Retained Earnings") {
                        $accountsubtype->name = "Other Current Liability";
                    } elseif ($accountsubtype->name == "Long Term Liabilities") {
                        $accountsubtype->name = "Long Term Liability";
                    } elseif ($accountsubtype->name == "Owners Equity") {
                        $accountsubtype->name = "Equity";
                    }

                    $data_id = [];
                    $data_id = [
                        "Classification" => $type,
                        "AccountType" => $accountsubtype->name,
                        "Name" => $account_data->name,
                    ];
                    $datadetail[] = $data_id;
                }

                $this->set_setting();
                $paymentCreateUrl = $this->base_url . '/v3/company/' . $company_id . '/account';
                $d = 0;
                foreach ($datadetail as $data) {
                    $paymentResponse =  Self::sendQuickBooksRequest('POST', $paymentCreateUrl, $refreshToken, $data);

                    $chartofaccounts = ChartOfAccount::where('name', $data['Name'])->get();

                    if (isset($paymentResponse->Account)) {
                        foreach ($chartofaccounts as $chartofaccount) {
                            $quickbooksaccount = new QuickbookChartOfAccount();
                            $quickbooksaccount->chartofaccount_id = $chartofaccount->id;
                            $quickbooksaccount->quickbook_id = $paymentResponse->Account->Id;
                            $quickbooksaccount->workspace = getActiveWorkSpace();
                            $quickbooksaccount->created_by = creatorId();
                            $quickbooksaccount->save();
                        }
                    }
                }

                return redirect()->route('chart-of-account.index')->with('success', __('QuickBook data synchronized successfully'));
            } else {

                return redirect()->route('chart-of-account.index')->with('error', __('Sometings Wents Wrong'));
            }
        }
        else
        {
            return redirect()->route('chart-of-account.index')->with('error', __('Please First genrate quickbook token the after you can synchronize chart of account '));
        }

    }

    public static function refreshAccessToken($refreshToken)
    {
        $setting = getCompanyAllSetting();

        // Replace with your QuickBooks client ID and secret key
        $clientId = $setting['quickbook_client_id'];
        $clientSecret = $setting['quickbook_client_secretkey'];

        $url = 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer';

        $data = array(
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken
        );

        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic ' . base64_encode($clientId . ':' . $clientSecret)
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if (isset($responseData['access_token'])) {
            return $responseData['access_token'];
        } else {
            // Handle error
            return null;
        }
    }

    public static function sendQuickBooksRequest($method, $url, $refreshToken, $data)
    {

        $responseData = Self::refreshAccessToken($refreshToken);

        if ($method != "GET") {
            $data = json_encode($data);
            $contenttype = 'application/json';
        } else {
            $method = "POST";
            $contenttype = 'application/text';
        }

        $curl = curl_init();

        $details = curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                'User-Agent: Intuit-qbov3-postman-collection2',
                'Accept: application/json',
                'Content-Type: ' . $contenttype,
                'Authorization: Bearer ' . $responseData
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


        $response = json_decode($response);

        return $response;
    }
}
