<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\tempImagesController;

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
// Route::get('/register', [AuthController::class, 'register'])->name('account.register');



// Route::get('/', function () {
//     return view('welcome');
// });
    Route::get('/', [FrontController::class, 'index'])->name('front.home');
    Route::get('/product', [ShopController::class, 'index'])->name('front.product');
    Route::get('/product/{slug}', [ShopController::class, 'product'])->name('front.detilProduct');

    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/process-register', [AuthController::class, 'processRegister'])->name('account.processRegister');

        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
        Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
        Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
        Route::post('/delete-cart', [CartController::class, 'deleteCart'])->name('front.deleteCart.cart');
    });


Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        //Category Routes   
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        //temp-images.create
        Route::post('/upload-temp-images', [tempImagesController::class, 'create'])->name('temp-images.create');
        //Product Routes
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.buat');
        Route::post('/product', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product-page', [ProductController::class, 'index'])->name('product.page');


        Route::get('/getSlug', function (Request $request) {
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});
