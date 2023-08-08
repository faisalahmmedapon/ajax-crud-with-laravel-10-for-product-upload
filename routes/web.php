<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/',[ProductController::class,'index'])->name('index');
Route::get('/products',[ProductController::class,'products'])->name('products');
Route::post('/products',[ProductController::class,'store'])->name('product.store');
Route::get('/product-edit/{id}',[ProductController::class,'edit'])->name('product.edit');
Route::post('/product-update/{id}',[ProductController::class,'update'])->name('product.update');
Route::get('/product-delete/{id}',[ProductController::class,'delete'])->name('product.delete');
