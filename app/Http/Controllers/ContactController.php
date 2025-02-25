<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\ContactAttachment;

use function PHPSTORM_META\map;

class ContactController extends Controller
{
    //view contact
    public function viewContact(){
        return view('admin.contact');
    }
    // getContactsPageData
    public function getContactPageData(){
        // $data['contact_list'] = Contact::orderBy('id', 'desc')->get();
        $query = Contact::with('replies')->orderBy('id', 'desc')->latest();
        // name: 
        if(request()->has('name') && request('name') != ''){
            $query->where('name', 'like', '%'.request('name').'%');
        }
        // email: 
        if(request()->has('email') && request('email') != ''){
            $query->where('email', 'like', '%'.request('email').'%');
        }
        // phone: 
        if(request()->has('phone') && request('phone') != ''){
            $query->where('phone', 'like', '%'.request('phone').'%');
        }
        // subject: 
        if(request()->has('subject') && request('subject') != ''){
            $query->where('subject', 'like', '%'.request('subject').'%');
        }
        // message: 
        // if(request()->has('message') && request('message') != ''){
        //     $query->where('message', 'like', '%'.request('message').'%');
        // }
        // date: 
        if(request()->has('date') && request('date') != ''){
            $query->whereDate('created_at', request('date'));
        }
        $data['contact_list'] = $query->get();
        return  response()->json(['status' => 200, 'message' => "", 'data' => $data]);
    }
    // getContactDetail
    public function getContactDetail(Request $request){
        // order by lastet reply with replies attachemnts
        $contact = Contact::with(['replies' => function($query){
            $query->orderBy('id', 'desc');
        },'replies.attachments'])->find($request->id);
        // $contact = Contact::with('replies','replies.attachments')->find($request->id);
        

        // $contact = Contact::with('replies','replies.attachments')->find($request->id);
        // set attachment path
        // use map
        $contact->replies->map(function($reply){
            $reply->attachments->map(function($attachment){
                $attachment->path = url('/',$attachment->path);
            });
        });
        return  response()->json(['status' => 200, 'message' => "", 'data' => $contact]);
    }
    // saveRelyContact
    public function saveRelyContact(Request $request){
        // dd($request->all(), $_FILES);
        $validatedData = $request->validate([
            'reply_message' => 'required|max:250',
            'attachment_files' => 'nullable|array', // Ensure it's an array of files
            'attachment_files.*' => 'max:10240',
        ]);
        // Save the reply
        $ContactReply = new ContactReply();
        $ContactReply->contact_id = $request->contact_id;
        $ContactReply->reply_message = $request->reply_message;
        $ContactReply->user_id = auth()->user()->id;
        $ContactReply->save();
        $emailAttachments = [];
        // Save the files
        if ($request->hasFile('attachment_files')) {
            foreach ($request->file('attachment_files') as $attachmentFile) {
                // get file type
                $type = $attachmentFile->getClientMimeType();
                $attachmentName = 'contact_' . time() . '_' . $attachmentFile->getClientOriginalName(); 
                $contactPath = 'uploads/contact'; 
                $attachmentFile->move(public_path($contactPath), $attachmentName); 
                
                // Save Reply the attachment
                $ContactAttachment = new ContactAttachment();
                $ContactAttachment->contact_reply_id = $ContactReply->id;
                $ContactAttachment->name = $attachmentFile->getClientOriginalName();
                $ContactAttachment->type = $type;
                $ContactAttachment->path = $contactPath . '/' . $attachmentName;
                $ContactAttachment->save();
                array_push($emailAttachments, url('/'.$ContactAttachment->path));
            }
        }
        $userContact = Contact::find($request->contact_id);
        $send_to_name = $userContact->name;
        $send_to_email = $userContact->email;
        $email_from_name = env('MAIL_FROM_NAME');
        $subject = $userContact->subject;
        $body = $request->reply_message;
        // $send_to_email = "muhammad.farooq.raaj@gmail.com";
        // send email
        $is_send = sendMailAttachments($send_to_name, $send_to_email, $email_from_name, $subject, $body, $attachments = []);
        return  response()->json(['status' => 200, 'message' => "Reply Sent Successfully.", 'emailAttachments'=> $emailAttachments]);
    }

}
