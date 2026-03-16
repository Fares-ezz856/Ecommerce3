<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    use ApiResponse;
    public function register(RegisterUserRequest $registerUser){
        $validated=$registerUser->validated();
        $user=User::create($validated);
        $token=$user->createToken('register_user')->plainTextToken;
        return $this->success('Registered Successfully',200,$token);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
            $user=User::where('email',$request->email)->first();
            if(!$user || !password_verify($request->password,$user->password)){
                return $this->error('Credintioals is false',200);
            }
            $token=$user->createToken('login_user')->plainTextToken;
            return $this->success('Login Successfully',200,$token);
    }
    public function logout(){
        $user=auth('user')->user();
        $user->currentAccessToken()->delete();
        return $this->success('Logout Successfully');
    }
}
