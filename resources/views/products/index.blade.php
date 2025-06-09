@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Products Management</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->ProductCode }}</td>
                        <td>{{ $product->ProductName }}</td>
                        <td>{{ $product->current_stock }}</td>
                        <td>
                            <div class="btn-group">
                                <!-- Stock In Button -->
                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#stockInModal{{ $product->ProductCode }}">
                                    <i class="fas fa-plus"></i> Stock In
                                </button>

                                <!-- Stock Out Button -->
                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#stockOutModal{{ $product->ProductCode }}">
                                    <i class="fas fa-minus"></i> Stock Out
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>

                            <!-- Stock In Modal -->
                            <div class="modal fade" id="stockInModal{{ $product->ProductCode }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('products.stock-in', $product) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Stock In - {{ $product->ProductName }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="quantity" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control @error('Quantity') is-invalid @enderror"
                                                           id="quantity" name="Quantity" required min="1">
                                                    @error('Quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="unique_price" class="form-label">Unique Price</label>
                                                    <input type="number" class="form-control @error('UniquePrice') is-invalid @enderror"
                                                           id="unique_price" name="UniquePrice" required min="0" step="0.01">
                                                    @error('UniquePrice')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="form-control @error('Date') is-invalid @enderror"
                                                           id="date" name="Date" required value="{{ date('Y-m-d') }}">
                                                    @error('Date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Add Stock</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Out Modal -->
                            <div class="modal fade" id="stockOutModal{{ $product->ProductCode }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('products.stock-out', $product) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title">Stock Out - {{ $product->ProductName }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="quantity" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control @error('Quantity') is-invalid @enderror"
                                                           id="quantity" name="Quantity" required min="1" max="{{ $product->current_stock }}">
                                                    @error('Quantity')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="unique_price" class="form-label">Unique Price</label>
                                                    <input type="number" class="form-control @error('UniquePrice') is-invalid @enderror"
                                                           id="unique_price" name="UniquePrice" required min="0" step="0.01">
                                                    @error('UniquePrice')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Date</label>
                                                    <input type="date" class="form-control @error('Date') is-invalid @enderror"
                                                           id="date" name="Date" required value="{{ date('Y-m-d') }}">
                                                    @error('Date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-warning">Remove Stock</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No products found. <a href="{{ route('products.create') }}">Add a new product</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
