<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminHomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_reviews' => Review::count(),
            'total_users' => User::count(),
            'total_orders' => Order::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function profile(){
        $admin=auth('admin-web')->user();
        return view('admin.profile.index',compact('admin'));
    }
    public function edit(Request $request){
        $admin=auth('admin-web')->user();
        $request->validate([
            'name'=>'required',
            'old_password'=>'sometimes',
            'new_password'=>'sometimes'
        ]);
        if($request->old_password){
                if(!password_verify($request->old_password,$admin->password)){
            return redirect()->back()->with('error','your password is wrong');
        }
        $admin->update([
            'password'=>Hash::make($request->new_password),
        ]);
        }
        $admin->update([
            'name'=>$request->name
        ]);

        return redirect()->back()->with('success','Your Profile Updated Successfully');
    }
}
