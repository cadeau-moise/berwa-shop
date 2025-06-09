<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withCount(['productIns', 'productOuts'])
            ->withSum('productIns', 'Quantity')
            ->withSum('productOuts', 'Quantity')
            ->get()
            ->map(function ($product) {
                $product->current_stock = $product->product_ins_sum_quantity - $product->product_outs_sum_quantity;
                return $product;
            });

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ProductCode' => 'required|string|unique:products',
            'ProductName' => 'required|string|max:255',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'ProductName' => 'required|string|max:255',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function stockIn(Request $request, Product $product)
    {
        $validated = $request->validate([
            'Quantity' => 'required|integer|min:1',
            'UniquePrice' => 'required|numeric|min:0',
            'Date' => 'required|date',
        ]);

        $validated['TotalPrice'] = $validated['Quantity'] * $validated['UniquePrice'];
        $validated['ProductCode'] = $product->ProductCode;

        ProductIn::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Stock added successfully.');
    }

    public function stockOut(Request $request, Product $product)
    {
        $validated = $request->validate([
            'Quantity' => 'required|integer|min:1',
            'UniquePrice' => 'required|numeric|min:0',
            'Date' => 'required|date',
        ]);

        // Check if we have enough stock
        $currentStock = $product->productIns()->sum('Quantity') - $product->productOuts()->sum('Quantity');
        if ($currentStock < $validated['Quantity']) {
            return back()->with('error', 'Not enough stock available.');
        }

        $validated['TotalPrice'] = $validated['Quantity'] * $validated['UniquePrice'];
        $validated['ProductCode'] = $product->ProductCode;

        ProductOut::create($validated);

        return redirect()->route('products.index')
            ->with('success', 'Stock removed successfully.');
    }
}
