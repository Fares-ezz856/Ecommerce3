<?php

namespace App\Http\Controllers\Api;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAdminRequest;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
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
    public function stats(){
        $total_products=Product::count();
        $total_categories=Category::count();
        $total_reviews=Review::count();
        $total_users=User::count();
        $stats=[
            'Total_Products'=>$total_products,
            'Total_Categories'=>$total_categories,
            'Total_Reviews'=>$total_reviews,
            'Total_Users'=>$total_users
        ];
        return $this->success('This is dashboard stats',200,$stats);
    }
}
