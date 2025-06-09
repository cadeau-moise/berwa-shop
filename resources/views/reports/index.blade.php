@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Stock Status Report</h5>
                <p class="card-text">View the current stock status of all products.</p>
                <a href="{{ route('reports.stock-status') }}" class="btn btn-primary">View Report</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Stock In Report</h5>
                <p class="card-text">View detailed stock in transactions.</p>
                <a href="{{ route('reports.stock-in') }}" class="btn btn-success">View Report</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Stock Out Report</h5>
                <p class="card-text">View detailed stock out transactions.</p>
                <a href="{{ route('reports.stock-out') }}" class="btn btn-danger">View Report</a>
            </div>
        </div>
    </div>
</div>
@endsection
