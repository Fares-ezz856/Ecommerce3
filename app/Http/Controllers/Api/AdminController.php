<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAdminRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
      use ApiResponse;
    public function register(RegisterAdminRequest $registerAdmin){
        $validated=$registerAdmin->validated();
        $admin=Admin::create($validated);
        $token=$admin->createToken('register_admin')->plainTextToken;
        return $this->success('Registered Successfully',200,$token);
    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
            $admin=Admin::where('email',$request->email)->first();
            if(!$admin || !password_verify($request->password,$admin->password)){
                return $this->error('Credintioals is false',200);
            }
            $token=$admin->createToken('login_admin')->plainTextToken;
            return $this->success('Login Successfully',200,$token);
    }
    public function logout(){
        $admin=auth('admin')->user();
        $admin->currentAccessToken()->delete();
        return $this->success('Logout Successfully');
    }
}
