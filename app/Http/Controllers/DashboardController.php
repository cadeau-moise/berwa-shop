<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductOut;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStockIn = ProductIn::sum('Quantity');
        $totalStockOut = ProductOut::sum('Quantity');
        $currentStock = $totalStockIn - $totalStockOut;

        $recentStockIns = ProductIn::with('product')
            ->latest()
            ->take(5)
            ->get();

        $recentStockOuts = ProductOut::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalStockIn',
            'totalStockOut',
            'currentStock',
            'recentStockIns',
            'recentStockOuts'
        ));
    }
}
