<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\ReviewController;
use App\Models\Recipe;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ウェルカムページを表示するルート
Route::get('/', [RecipeController::class, 'home'])->name('home');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipe.index');

// ダッシュボードページのルート定義
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証済みユーザー向けのグループ化されたルート
Route::middleware('auth')->group(function () {
    Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipe.create');
    Route::post('/recipes', [RecipeController::class, 'store'])->name('recipe.store');
    Route::get('/recipes/edit/{id}', [RecipeController::class, 'edit'])->name('recipe.edit');
    Route::patch('/recipes/update/{id}', [RecipeController::class, 'update'])->name('recipe.update');
    Route::delete('/recipes/{id}', [RecipeController::class, 'destroy'])->name('recipe.destroy');
    Route::post('/recipes/{id}/review', [ReviewController::class, 'store'])->name('review.store');
    // ユーザープロフィールの編集ページへのルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // ユーザープロフィールの更新を行うルート
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ユーザープロフィールの削除を行うルート
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/recipes/{id}', [RecipeController::class, 'show'])->name('recipe.show');

// 外部の認証関連のルートを読み込む
require __DIR__ . '/auth.php';
