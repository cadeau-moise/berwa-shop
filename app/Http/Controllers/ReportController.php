<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function stockStatus()
    {
        $products = Product::withCount(['productIns', 'productOuts'])
            ->withSum('productIns', 'Quantity')
            ->withSum('productOuts', 'Quantity')
            ->get()
            ->map(function ($product) {
                $product->current_stock = $product->product_ins_sum_quantity - $product->product_outs_sum_quantity;
                return $product;
            });

        return view('reports.stock-status', compact('products'));
    }

    public function stockIn(Request $request)
    {
        $query = ProductIn::with('product')
            ->when($request->date_from, function ($q) use ($request) {
                return $q->where('Date', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($q) use ($request) {
                return $q->where('Date', '<=', $request->date_to);
            });

        $stockIns = $query->get();
        $totalAmount = $stockIns->sum('TotalPrice');

        return view('reports.stock-in', compact('stockIns', 'totalAmount'));
    }

    public function stockOut(Request $request)
    {
        $query = ProductOut::with('product')
            ->when($request->date_from, function ($q) use ($request) {
                return $q->where('Date', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($q) use ($request) {
                return $q->where('Date', '<=', $request->date_to);
            });

        $stockOuts = $query->get();
        $totalAmount = $stockOuts->sum('TotalPrice');

        return view('reports.stock-out', compact('stockOuts', 'totalAmount'));
    }
}
