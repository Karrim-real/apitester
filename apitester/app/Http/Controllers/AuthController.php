<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);
        $user = User::create([
            'name' => $inputs['name'],
            'email' => $inputs['email'],
            'password' => bcrypt($inputs['password']),

        ]);
        $tokenKey = $user->createToken('tokenizer')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $tokenKey
        ];
        return response($response, 200);
    }

    public function login(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $User = User::where('email', $inputs['email'])->first();
        if(!$User || !Hash::check($inputs['password'], $User->password)){
            return response(['status' => 'Incorrect Credentials, Please check your username or Password and Try again']);
        }
        $tokens = $User->createToken('tokenizer')->plainTextToken;
        $response = [
            'user' => $User,
            'token' => $tokens
        ];
        return response($response, 200);
    }
    public function update(Request $request)
    {
        // $inputs = $request->validate([]);
        $inputs = $request->all();
        $user = User::where('id', Auth::user()->id);
        if($user->update($inputs)){
            return response('User Info update', 200);
        }else{
            return response('Error in updating data', 403);
        }


    }
    public function logout()
    {
        Auth()->user()->tokens()->delete();
        return response(['msg' => 'User Logout Successfully, Bye']);
    }
}
