<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShoeController;
use App\Http\Controllers\CartController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Shoe Routes for authenticated users
Route::middleware('auth')->group(function () {
    // Show the form to post a new shoe
    Route::get('/shoes/create', [ShoeController::class, 'create'])->name('shoes.create');

    
    // Store a new shoe
    Route::post('/shoes', [ShoeController::class, 'store'])->name('shoes.store');
    
    // List all shoes posted by the user
    Route::get('/shoes', [ShoeController::class, 'index'])->name('shoes.index');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    //Shoe routes
    Route::resource('shoes', ShoeController::class);
    Route::get('/api/top-shoes', [ShoeController::class, 'topShoes']);
    Route::get('/api/latest-shoes', [ShoeController::class, 'latestShoes']);
});

require __DIR__.'/auth.php';
