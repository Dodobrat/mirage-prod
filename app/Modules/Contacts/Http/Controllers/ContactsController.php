<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Mail\MailSent;
use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Http\Requests\SendContactRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    public function index(){

        $contacts = Contact::active()->reversed()->get();

        return view('contacts::front.index', compact('contacts'));
    }


    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:50|min:2',
            'email' => 'required|email',
            'subject' => 'required|max:75',
            'comment' => 'required|max:300|min:1',
        ]);
        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $contact_id = $request->input('contact_id');

        $contact = Contact::where('id', $contact_id)->first();


        Mail::to($contact->email)->send(new MailSent($request->all()));

        return response()->json(['success'=>trans('contacts::front.email_success')], 200);

    }
}
