<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = Admin::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
}
