<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
  public function getContacts(){
      $contacts = Contact::all();
      return $contacts;
  }

  public function save_contact(Request $request){
     $contact = new Contact;
     if($request->has('image') && !empty($request->image )){
       $imageName = time() . '.' . $request->image->getClientOriginalExtension();
       $request->image->move(public_path('images/gallery'), $imageName );
       $path = ('/images/gallery/'.$imageName);
       $contact->image = $path;
     }

     $contact->name = $request->name;
     $contact->email = $request->email;
     $contact->bio = $request->bio;
     $contact->designation = $request->designation;
     $contact->contact_no = $request->contact_no;

     if($contact->save()){
       return response()->json(['status'=> true, 'message'=> ' Contact Added Successfullly!']);
     }else{
       return response()->json(['status'=> false, 'message' => 'There is some problem. Please try again later.']);
     };


  }

  public function edit_contact($id){
    $contact = Contact::find($id);
    return response()->json($contact);
  }

  public function update_contact(Request $request, $id)
  {
    $contact = Contact::where('id', $id)-> first();
    if ($request->has('image') && !empty($request->image)) {
      $imageName = time() . '.' . $request->image->getClientOriginalExtension();
      $request->image->move(public_path('images/gallery'), $imageName);
      $path = ('/images/gallery/' . $imageName);
      $contact->image = $path;
    }

    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->bio = $request->bio;
    $contact->designation = $request->designation;
    $contact->contact_no = $request->contact_no;

    if ($contact->save()) {
      return response()->json(['status' => true, 'message' => ' Contact Updated Successfullly!']);
    } else {
      return response()->json(['status' => false, 'message' => 'There is some problem. Please try again later.']);
    };
  }

  public function deleteContact($id){
    $contact = Contact::find($id);
    if ($contact->delete()) {
      return response()->json(['status'=> true, 'message'=> 'Contact Deleted Successfully!']);
    }else{
      return response()->json(['status'=> false, 'message' => 'There is some problem. Please try again later.']);
    }
  }
}
