@extends('layouts.app')

@section('title', 'Stock Status Report')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Stock Status Report</h4>
        <a href="{{ route('reports') }}" class="btn btn-secondary">Back to Reports</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Total Stock In</th>
                        <th>Total Stock Out</th>
                        <th>Current Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->ProductCode }}</td>
                        <td>{{ $product->ProductName }}</td>
                        <td>{{ $product->product_ins_sum_quantity }}</td>
                        <td>{{ $product->product_outs_sum_quantity }}</td>
                        <td>{{ $product->current_stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
