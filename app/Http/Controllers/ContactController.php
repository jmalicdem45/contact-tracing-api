<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
   public function getAll(Request $request) {
        $date = $request->date;
        $result = Contact::query()
        ->when($date, function($result) use ($date) {
            return $result->whereDate('created_at', $date);
        })
        ->orderBy('id', 'DESC')
        ->get();

        return new Response($result, 200);
   }

   public function create(Request $request) {
       $input = $request->all();
       $newContact = Contact::create($input);

       return new Response($newContact, 201);
   }

   public function setPositive(Request $request, $id) {
       $contact = Contact::findOrFail($id);
       $contact->positive = $request->isPositive;
       $contact->save();

       return new Response($contact, 200);
   }

   public function delete($id) {
       $contact = Contact::findOrFail($id);
       $contact->delete();
       return new Response('', 200);
   }
}
