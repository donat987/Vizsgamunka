<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get("/admin/ujtermek", [PageController::class, 'create']);
    Route::post("/admin/ujtermek/kategoriamentes", [CategoryController::class, 'store'])->name("categorysave");
    Route::post("/admin/ujtermek/markamentes", [BrandController::class, 'store'])->name("brandsave");
    Route::post("/admin/ujtermek/categlekeres", [PageController::class, 'categ1'])->name("category1");
    Route::post("/admin/ujtermek/categlekeres1", [PageController::class, 'categ2'])->name("category2");
    Route::post("/admin/ujtermek/categlekeres2", [PageController::class, 'categ3'])->name("category3");
    Route::post("/admin/ujtermek/categlekeres3", [PageController::class, 'categ4'])->name("category4");
    Route::post("/admin/ujtermek/addcateglekeres", [PageController::class, 'categ1'])->name("addcategory1");
    Route::post("/admin/ujtermek/addcateglekeres1", [PageController::class, 'categ2'])->name("addcategory2");
    Route::post("/admin/ujtermek/addcateglekeres2", [PageController::class, 'categ3'])->name("addcategory3");
    Route::post("/admin/ujtermek/addcateglekeres3", [PageController::class, 'categ4'])->name("addcategory4");
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__ . '/auth.php';
