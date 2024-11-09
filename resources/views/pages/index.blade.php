@extends('layouts.masterLayout')
@section('title', 'All Products')
@section('content')
    <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center">
            <h2>Get All Products</h2>
            <div class="d-flex">
                <a href="{{ route('create.product.show') }}" class="btn btn-outline-success btn-sm mr-2">Add Products</a>
                <form action="{{ route('product.index') }}" method="GET" class="form-inline">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by ID or Description" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-info btn-sm ml-2">Search</button>
                </form>
            </div>
        </div>

        <table class="table table-striped table-dark mt-3">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Product ID</th>
                    <th scope="col">
                        <a href="{{ route('product.index', ['sort' => 'name', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Product Name
                        </a>
                    </th>
                    <th scope="col">
                        <a href="{{ route('product.index', ['sort' => 'price', 'direction' => request('direction') === 'asc' ? 'desc' : 'asc']) }}">
                            Price
                        </a>
                    </th>
                    <th scope="col">Image</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <th scope="row">{{ $product->id }}</th>
                        <td>{{ $product->product_id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>৳ {{ number_format($product->price, 2) }}</td>
                        <td><img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" width="70" class="img-fluid rounded shadow"></td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('show.product', $product->id) }}" class="btn btn-sm btn-success">View</a>
                            <a href="{{ route('show.edit.product', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('delete.product', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-warning text-center">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
