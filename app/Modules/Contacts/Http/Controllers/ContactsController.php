<?php

namespace App\Modules\Contacts\Http\Controllers;

use App\Mail\MailSent;
use App\Modules\Contacts\Models\Contact;
use App\Modules\Contacts\Http\Requests\SendContactRequest;

use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactsController extends Controller
{
    public function index(){

        $contacts = Contact::active()->reversed()->get();

        SEOTools::setTitle(config('app.name') . ' - ' . $contacts->first()->meta_title);
        SEOTools::setDescription($contacts->first()->meta_description);
        SEOMeta::addKeyword(explode(', ', $contacts->first()->meta_keywords));

        return view('contacts::front.index', compact('contacts'));
    }


    public function store(Request $request) {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:50|min:2',
            'email' => 'required|email',
            'subject' => 'required|max:75',
            'comment' => 'required|max:300|min:1',
            'captcha' => 'required|captcha'
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
