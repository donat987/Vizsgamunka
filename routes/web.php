<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
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

Route::get("/", [PageController::class, 'index']);
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get("/admin", [PageController::class, 'adminpage']);
    Route::get("/admin/ujtermek", [PageController::class, 'create']);
    Route::post("/admin/ujtermek/mentes", [ProductController::class,'store'])->name("productsave");
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
    Route::get("/admin/rendelesek", [PageController::class, 'order'])->name("adminorder");
    Route::get("/admin/rendelesek/{id}", [PageController::class, 'ordershow']);
    Route::get("/admin/blog", [BlogController::class, 'blog']);
    Route::post("/admin/blog", [BlogController::class, 'save'])->name("blogsave");
    Route::post("/admin/rendelesek/modsoitas", [PageController::class, 'ordershowsave'])->name("ordershowsave");
});


Route::middleware('auth')->group(function () {
    Route::get('/profil', [UserController::class, 'show'])->name('profil');
    Route::get('/profil/modositas', [UserController::class, 'profilupdate'])->name('profilupdate');
    Route::get('/profil/cimek', [UserController::class, 'profiltitles'])->name('profiltitles');
    Route::get('/profil/cimek/hozzaad', [UserController::class, 'addtitles'])->name('addtitles');
    Route::get('/profil/cimek/modositas/{id}', [UserController::class, 'titlesupdate'])->name('titlesupdate');
    Route::get('/profil/cimek/torles/{id}', [UserController::class, 'titlesdelete'])->name('titlesdelete');
    Route::post('/profil/cimek/modositas/mentes', [UserController::class, 'titlesupdatesave'])->name('titlesupdatesave');
    Route::post('/profil/cimek/hozzaad/mentes', [UserController::class, 'addtitlessave'])->name('addtitlessave');
    Route::post('/profil/modositas/mentes', [UserController::class, 'profilupdatesave']);
    Route::get('/profil/rendelesek', [UserController::class, 'profilorder'])->name("orders");
    Route::get('/profil/teljesitettrendelesek', [UserController::class, 'profiloldorder']);
    /*Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy')*/;
});

Route::get('/termekek', [ProductController::class, 'search']);
Route::get('/termekek/{termek}', [ProductController::class, 'productshow']);

Route::get('/akcios-termekek', [ProductController::class, 'action']);
Route::get('/osszes-termekek', [ProductController::class, 'all']);
Route::get('/termekek/{termek}', [ProductController::class, 'productshow']);
Route::get('/kereses', [ProductController::class, 'search']);
Route::post("/termek/ertekeles", [ProductController::class,'star'])->name("starsave");
Route::post("/kosarhozadas", [CartController::class, "addToCart"])->name("addtocart");
Route::get('/kosar', [CartController::class, 'show']);
Route::post('/kosar/kupon', [CartController::class, "cupon"])->name("cupon");
Route::get('/kosarvegleges', [CartController::class, 'cartall'])->name("teljes");
Route::get('/kosar/betolt', [CartController::class, 'cart'])->name("cartt");
Route::get('/kosartorles', [CartController::class, 'delet']);
Route::get('/kosar/veglegesites', [CartController::class, 'checkout'])->name("checkout");
Route::post('/kosar/veglegesites/rendeles', [CartController::class, 'order'])->name("order");


Route::get('/email', [UserController::class, 'hiteles']);



require __DIR__ . '/auth.php';
