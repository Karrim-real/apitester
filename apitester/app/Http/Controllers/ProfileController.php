<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
   public function index(){
       return response()->json('Welcome Mr Adeola Mike', 200);
   }

   public function store(Request $request)
   {
    $input = $request->validate();
    $input = $request->all();
    $user = User::where('id', Auth::user()->id)->first();
    if($user){
       $createProfile =  Profile::create([
            'user_id' => Auth::user()->id,
            'fullname' => $input['fullname'],
            'profile_id' => time().'-'.rand(1000, 9999),
            'skills' => $input['skills'],
        ]);
        if($createProfile){
            return response('You have Created your Profile Successfully', 201);
        }else{
            return response('An error occur while creating profile', 400);
        }

    }else{
        return response('No user Found', 203);
    }
   }
}
