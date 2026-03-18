<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => Invoice::where('type', 'sale')->where('status', 'confirmed')->sum('total_amount'),
            'total_payments' => Payment::sum('amount'),
            'low_stock_products' => Product::where('stock_quantity', '<', 10)->count(),
            'recent_movements' => StockMovement::count(),
        ];

        $sales_by_day = Invoice::where('type', 'sale')
            ->where('status', 'confirmed')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('admin.reports.index', compact('stats', 'sales_by_day'));
    }
}
