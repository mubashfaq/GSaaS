<?php

namespace Workdo\VCard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Workdo\VCard\DataTables\ContactDataTable;
use Workdo\VCard\Entities\Business;
use Workdo\VCard\Entities\ContactsDetails;
use Workdo\VCard\Entities\AppointmentDetails;
use Workdo\VCard\Events\CreateContact;
use Workdo\VCard\Events\DestroyContact;
use Workdo\VCard\Events\UpdateContact;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ContactDataTable $dataTable, Request $request)
    {

        if (\Auth::user()->isAbleTo('card contact manage')) {
            $id = '';
            $id = $request->business_id;
            $businessData = Business::where('created_by', creatorId())->where('workspace', getActiveWorkSpace())->get()->pluck('title', 'id');
            return $dataTable->render('vcard::contacts.index', compact('businessData', 'id'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $business_id = $request->business_id;
        $business = Business::where('id', $business_id)->first();

        $contact = ContactsDetails::create([
            'business_id' => $request->business_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_by' => $business->created_by,
            'workspace' => $business->workspace,
        ]);
        event(new CreateContact($request, $contact));

        return redirect()->back()->with('success', __('Contact created successfully.'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if (\Auth::user()->isAbleTo('card contact delete')) {
            $contact = ContactsDetails::find($id);
            if ($contact) {
                event(new DestroyContact($contact));
                $contact->delete();
                return redirect()->back()->with('success', __('Contact has been deleted.'));
            }
            return redirect()->back()->with('error', __('Contact not found.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function addNote($id)
    {
        if ($id) {
            $contact = ContactsDetails::where('id', $id)->first();
            return view('vcard::contacts.add_note', compact('contact'));
        } else {
            return response()->json(['error' => __('Something went wrong.')], 401);
        }
    }
    public function noteStore($id, Request $request)
    {
        if (\Auth::user()->isAbleTo('card contact add note')) {
            $contacts = ContactsDetails::where('id', $id)->first();
            $contacts->status = $request->status;
            $contacts->note = $request->note;
            $contacts->save();
            event(new UpdateContact($request, $contacts));
            return redirect()->back()->with('success', __('Contact note added successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function viewmessage($id)
    {
        $contacts = ContactsDetails::where('id', $id)->first();

        return view('vcard::contacts.message', compact('contacts'));
    }
}
