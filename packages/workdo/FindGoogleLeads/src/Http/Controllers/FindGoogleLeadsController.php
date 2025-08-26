<?php

namespace Workdo\FindGoogleLeads\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Http;
use Workdo\FindGoogleLeads\DataTables\GoogleLeadContactDataTable;
use Workdo\FindGoogleLeads\DataTables\GoogleLeadDataTable;
use Workdo\FindGoogleLeads\Entities\GoogleLead;
use Workdo\FindGoogleLeads\Entities\GoogleLeadContact;
use Workdo\Lead\Entities\LeadStage;
use Workdo\FindGoogleLeads\Events\CreateGoogleLead;
use Workdo\FindGoogleLeads\Events\CreateGoogleLeadContact;
use Workdo\FindGoogleLeads\Events\DestroyGoogleLead;
use Workdo\FindGoogleLeads\Events\DestroyGoogleLeadContact;

class FindGoogleLeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function setting(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'findgoogleleads_api_key' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        } else {
            $getActiveWorkSpace = getActiveWorkspace();
            $creatorId = creatorId();
            $post = $request->all();
            unset($post['_token']);
            foreach ($post as $key => $value) {
                $data = [
                    'key' => $key,
                    'workspace' => $getActiveWorkSpace,
                    'created_by' => $creatorId,
                ];
                Setting::updateOrInsert($data, ['value' => $value]);
            }
            // Settings Cache forget
            comapnySettingCacheForget();
            return redirect()->back()->with('success', __('The Google Leads settings has been saved successfully.'));
        }
    }
    public function index(GoogleLeadDataTable $dataTable)
    {
        if (\Auth::user()->isAbleTo('findgooglelead manage')) {
            return $dataTable->render('findgoogleleads::lead.index');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function get_stage(Request $request)
    {

        $lead_stages = LeadStage::where('pipeline_id', $request->id)->pluck('name', 'id');
        if (!empty($lead_stages)) {
            $response = ['status' => 1, 'data' => $lead_stages];
        } else {
            $response = ['status' => 0, 'data' => []];
        }
        return json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        if (\Auth::user()->isAbleTo('findgooglelead find')) {

            return view('findgoogleleads::lead.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        try {

            $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?';
            $url .= http_build_query([
                'query' => $request->title . ' in ' . $request->address,
                'type' => $request->keyword,
                'radius' => company_setting('finsgoogleleads_radius'),
                'key' => company_setting('findgoogleleads_api_key'),
            ]);
            $client = new Client();
            $response = $client->get($url);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();
            $response_data = json_decode($body, true);
            if ($statusCode == 200) {
                $lead = new GoogleLead();
                $lead->name = $request->title;
                $lead->keywords = $request->keyword;
                $lead->address = $request->address;
                $lead->created_by = \Auth::user()->id;
                $lead->workspace = getActiveWorkSpace();
                $lead->save();

                $this->processLocations($response_data, $lead);
                $count = GoogleLeadContact::where('founded_lead_id', $lead->id)->count();
                $lead->contact = $count;
                $lead->save();
                event(new CreateGoogleLead($request, $lead));
                return redirect()->route('find-google-leads.index')->with('success', __('Lead found successfully.'));
            } else {
                if (isset($response_data['status']) && $response_data['status'] == 'error') {
                    return redirect()->back()->with('error', $response_data['message']);
                } else {
                    return redirect()->back()->with('error', __('Something went wrong.'));
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Something went wrong.'));
        }
    }

    protected function processLocations($response_data, $lead)
    {
        if (isset($response_data['results'])) {
            $locations = $response_data['results'];
            foreach ($locations as $location) {
                $this->place_detail($location['place_id'], $lead->id);
            }

            if (isset($response_data['next_page_token'])) {
                $this->processNextPage($response_data['next_page_token'], $lead);
            }
        }
    }

    protected function processNextPage($next_page_token, $lead)
    {
        $nextpagedata = $this->next_page_data($next_page_token);
        if ($nextpagedata['status']) {
            $this->processLocations($nextpagedata['data'], $lead);
        }
    }

    public function next_page_data($nextPageToken)
    {
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?';
        $url .= http_build_query([
            'pagetoken' => $nextPageToken,
            'key' => company_setting('findgoogleleads_api_key'),
        ]);
        $client = new Client();
        $response = $client->get($url);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();
        $response_data = json_decode($body, true);

        if ($statusCode == 200) {
            return ['status' => true, 'data' => $response_data];
        } else {
            return ['status' => false];
        }
    }

    public function place_detail($place_id = null, $lead_id = null)
    {
        $place_detail_url = 'https://maps.googleapis.com/maps/api/place/details/json?';
        $place_detail_url .= http_build_query([
            'place_id' => $place_id,
            'fields' => 'name,formatted_phone_number,website,formatted_address,international_phone_number',
            'key' => company_setting('findgoogleleads_api_key')
        ]);
        $place_detail_client = new Client();
        $place_detail_response = $place_detail_client->get($place_detail_url);
        $place_detail_statusCode = $place_detail_response->getStatusCode();
        $place_detail_body = $place_detail_response->getBody()->getContents();
        $place_detail_response_data = json_decode($place_detail_body, true);
        if ($place_detail_statusCode == 200) {
            if (isset($place_detail_response_data['result'])) {
                $contact = new GoogleLeadContact();
                $contact->founded_lead_id = $lead_id;
                $contact->name = isset($place_detail_response_data['result']['name']) ? $place_detail_response_data['result']['name'] : "";
                $contact->email = isset($place_detail_response_data['result']['email']) ? $place_detail_response_data['result']['email'] : "";
                $contact->phone_no = isset($place_detail_response_data['result']['international_phone_number']) ?
                    $place_detail_response_data['result']['international_phone_number'] : (isset($place_detail_response_data['result']['formatted_phone_number']) ?
                        $place_detail_response_data['result']['formatted_phone_number'] : "");
                $contact->website = isset($place_detail_response_data['result']['website']) ? $place_detail_response_data['result']['website'] : "";
                $contact->address = isset($place_detail_response_data['result']['formatted_address']) ? $place_detail_response_data['result']['formatted_address'] : "";
                $contact->created_by = \Auth::user()->id;
                $contact->workspace = getActiveWorkSpace();
                $contact->save();
                $request = $place_detail_response_data;
                event(new CreateGoogleLeadContact($request, $contact));
            }
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(GoogleLeadContactDataTable $dataTable, $id)
    {
        if (\Auth::user()->isAbleTo('findgooglelead show')) {
            $lead = GoogleLead::where('id', $id)->where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->first();

            if ($lead) {
                return $dataTable->with('leadId', $id)->render('findgoogleleads::lead.view', compact('lead'));
            } else {
                return redirect()->back()->with('error', __('The lead is not found.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('findgoogleleads::edit');
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

    public function contact_destroy($id)
    {
        if (\Auth::user()->isAbleTo('findgooglelead contact delete')) {
            $contact = GoogleLeadContact::find($id);
            if ($contact) {
                $lead_id = $contact->founded_lead_id;
                $contact->delete();
                $lead = GoogleLead::find($lead_id);
                if ($lead) {
                    $count = GoogleLeadContact::where('founded_lead_id', $lead_id)->count();
                    $lead->contact = $count;
                    $lead->save();
                    event(new DestroyGoogleLead($lead));
                    return redirect()->route('find-google-leads.index')->with('success', __('The google lead contact has been deleted.'));
                } else {
                    return redirect()->back()->with('error', __('The lead is not found.'));
                }
            } else {
                return redirect()->back()->with('error', __('The lead contact is not found.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function destroy($id)
    {
        if (\Auth::user()->isAbleTo('findgooglelead delete')) {
            $lead = GoogleLead::find($id);
            if ($lead) {
                $contact = GoogleLeadContact::where('founded_lead_id', $lead->id)->delete();
                event(new DestroyGoogleLeadContact($contact));
                $lead->delete();
                return redirect()->route('find-google-leads.index')->with('success', __('The google lead has been deleted.'));
            } else {
                return redirect()->back()->with('error', __('The lead is not found.'));
            }

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
