@extends('layouts.masterLayout')
@section('title', 'Show')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('images/' . $show->image) }}" alt="{{ $show->name }}" width="400"
                    class="img-fluid rounded shadow">
            </div>

            <div class="col-md-6">
                <h2 class="mb-3">{{ $show->name }}</h2>

                <div class="mb-2">
                    <span class="text-muted">SKU:</span>
                    <span class="text-primary">{{ $show->product_id }}</span>
                </div>

                <div class="mb-3">
                    <span class="text-muted">Description:</span>
                    <p class="text-secondary">
                        {{ $show->description }}
                    </p>
                </div>

                <div class="mb-3">
                    <span class="text-muted">Price:</span>
                    <span class="h5 text-success">${{ number_format($show->price, 2) }}</span>
                </div>

                <div class="mb-4">
                    <span class="text-muted"> Only {{ $show->stock }} products are available</span>
                </div>

                <div>
                    <a href="#" class="btn btn-sm btn-success mr-2">Add to Cart</a>
                    <a href="#" class="btn btn-outline-secondary btn-sm">Wishlist</a>
                </div>
            </div>
        </div>
    </div>
@endsection
