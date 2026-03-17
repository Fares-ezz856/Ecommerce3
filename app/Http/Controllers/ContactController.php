<?php

namespace App\Http\Controllers;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Contact;


class ContactController extends Controller
{
    use ApiResponse;
    public function create(ContactRequest $contactRequest){
        $validated=$contactRequest->validated();
        $validated['name']=auth('user')->user()->name;
        $validated['email']=auth('user')->user()->email;
        Contact::create($validated);
        return $this->success('Your Message Sent Successfully');
    }
    public function all(){
        $contacts=Contact::all();
        if($contacts->isEmpty()){
            return $this->error('The Contact Is Empty',200);
        }
        return $this->success('This is Contacts',200,ContactResource::collection($contacts));
    }
}
