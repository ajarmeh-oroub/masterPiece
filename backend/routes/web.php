<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PharamcyController;
use App\Models\Article;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard.index');
    
    Route::get('/user', [UserController::class ,'index'])->name('user.index');
    Route::get('/user/{id}/{active}', [UserController::class ,'update'])->name('user.edit');

    Route::get('/product', [ProductController::class ,'index'])->name('product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}/show', [ProductController::class, 'show'])->name('product.show');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/{id}/status/{visible}', [ProductController::class, 'updateStatus'])->name('product.Status');

    Route::get('/brands' , [BrandController::class , 'index'])->name('brand.index');
    Route::get('/brand/create' , [BrandController::class , 'create'])->name('brand.create');
    Route::post('brand/store' , [BrandController::class , 'store'])->name('brand.store');
    Route::get('/brand/{id}/edit' , [BrandController::class , 'edit'])->name('brand.edit');
    Route::put('brand/{id}/update',[BrandController::class , 'update'])->name('brand.update');
    Route::put('/brand/{id}' , [BrandController::class , 'toggleStatus'])->name('brand.status');

    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::delete('/category/{id}/destroy/', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/{id}/update', [CategoryController::class, 'update'])->name('category.update');

    Route::delete('/subcategory/{id}' , [CategoryController::class , 'sub_delete'])->name('subcategory.destroy');
    Route::put('/subcategory/{id}', [CategoryController::class, 'sub_update'])->name('subcategory.update');
    Route::get('/subcategory/{id}' , [CategoryController::class , 'sub_edit'])->name('subcategory.edit');

    Route::get('/store', [PharamcyController::class, 'index'])->name('store.index');
    Route::get('/store/create', [PharamcyController::class, 'create'])->name('store.create');
    Route::post('/store/store', [PharamcyController::class, 'store'])->name('store.store');
    Route::get('/store/{id}/show', [PharamcyController::class, 'show'])->name('store.show');
    Route::get('/store/{id}/status/{visible}', [PharamcyController::class, 'toggleStatus'])->name('store.Status');

    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/review/{id}/show', [ReviewController::class, 'show'])->name('review.show');
    Route::get('/review/{id}/status/{visible}', [ReviewController::class, 'status'])->name('review.status');

    Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
    Route::get('/comment/{id}/show', [CommentController::class, 'show'])->name('comment.show');
    Route::get('/comment/{id}/status/{visible}', [CommentController::class, 'status'])->name('comment.status');

    Route::get('/blog', [ArticleController::class, 'index'])->name('blog.index');
    Route::get('/blog/{id}/show', [ArticleController::class, 'show'])->name('blog.show');
    Route::get('/blog/{id}/edit', [ArticleController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{id}/update', [ArticleController::class, 'update'])->name('blog.update');
    Route::get('/blog/create', [ArticleController::class, 'create'])->name('blog.create');
    Route::post('blog/store' , [ArticleController::class, 'store'])->name('blog.store');
    Route::delete('/blog/{id}/destroy', [ArticleController::class, 'destroy'])->name('blog.destroy');

    Route::get('/contact' , [ContactController::class , 'index' ])->name('contact.index');
    Route::get('/contact/{id}/show' , [ContactController::class , 'show' ])->name('contact.show');

    Route::get('/orders' , [OrderController::class , 'index'])->name('order.index');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
