<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    public function contact(){
        return view('frontend.contact');
    }
    public function storeMessage(Request $request){
        Contact::insert([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'phone' => $request->phone,
            'message' => $request->message,
            'created_at' => Carbon::now(),
        ]);

        $toasterNotification = array(
            'message' => 'Your Message Submitted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($toasterNotification);
    }
    public function contactMessage(){
        $contacts = Contact::latest()->get();
        return view('admin.contact.allcontact', compact('contacts'));
    }
    public function deleteMessage($id){

        Contact::findOrFail($id)->delete();

        $toasterNotification = array(
            'message' => 'Message Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($toasterNotification);
    }
}
