@extends('layouts.app')

@section('title', 'Stock Out Report')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Stock Out Report</h4>
        <a href="{{ route('reports') }}" class="btn btn-secondary">Back to Reports</a>
    </div>
    <div class="card-body">
        <form action="{{ route('reports.stock-out') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="alert alert-info">
            Total Amount: {{ number_format($totalAmount, 2) }}
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unique Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stockOuts as $stockOut)
                    <tr>
                        <td>{{ $stockOut->Date->format('Y-m-d') }}</td>
                        <td>{{ $stockOut->product->ProductCode }}</td>
                        <td>{{ $stockOut->product->ProductName }}</td>
                        <td>{{ $stockOut->Quantity }}</td>
                        <td>{{ number_format($stockOut->UniquePrice, 2) }}</td>
                        <td>{{ number_format($stockOut->TotalPrice, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
