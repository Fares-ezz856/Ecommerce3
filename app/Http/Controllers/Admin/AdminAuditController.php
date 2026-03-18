<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminAuditController extends Controller
{
    public function index()
    {
        $logs = AuditLog::with('admin')->latest()->paginate(50);
        return view('admin.audit.index', compact('logs'));
    }
}
