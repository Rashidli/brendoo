<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-contacts|create-contacts|edit-contacts|delete-contacts', ['only' => ['index','show']]);
        $this->middleware('permission:create-contacts', ['only' => ['create','store']]);
        $this->middleware('permission:edit-contacts', ['only' => ['edit']]);
        $this->middleware('permission:delete-contacts', ['only' => ['destroy']]);
    }

    public function index()
    {

        $contacts = Contact::query()->orderByDesc('id')->paginate(10);
        return view('admin.contacts.index', compact('contacts'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {

        $contact->delete();
        return redirect()->route('contacts.index')->with('message', 'Contact deleted successfully');

    }
}
