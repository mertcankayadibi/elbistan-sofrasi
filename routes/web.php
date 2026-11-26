<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/urunler', [ProductController::class, 'index'])->name('products.index');
Route::get('/kategori/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/urun/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/sepet', [CartController::class, 'index'])->name('cart.index');
Route::post('/sepet/ekle', [CartController::class, 'add'])->name('cart.add');
Route::patch('/sepet/guncelle', [CartController::class, 'update'])->name('cart.update');
Route::delete('/sepet/cikar', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/sepet/temizle', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/hakkimizda', [StoryController::class, 'show'])->name('page.story');
Route::get('/tarifler', [RecipeController::class, 'index'])->name('recipes.index');
