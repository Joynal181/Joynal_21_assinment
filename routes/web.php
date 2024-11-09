<?php

use App\Http\Controllers\ProductControlle;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'showProductList'])->name('product.index');
Route::get('/products/create',[ProductController::class,'showCreateProduct'])->name('create.product.show');
Route::post('/products',[ProductController::class,'createProduct'])->name('create.product');
Route::get('/products/{id}/show',[ProductController::class,'show'])->name('show.product');
Route::get('products/{id}/edit',[ProductController::class,'showEditProduct'])->name('show.edit.product');
Route::put('products/{id}', [ProductController::class, 'editProduct'])->name('edit.product');
Route::delete('products/{id}', [ProductController::class, 'deleteProduct'])->name('delete.product');
