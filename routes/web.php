<?php

use App\Http\Controllers\AboutController;
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
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\tempImagesController;
use App\Http\Controllers\admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserDetailsController;

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
Route::get('/admin', [AdminLoginController::class, 'index'])->name('admin.login');
Route::get('/product', [ShopController::class, 'index'])->name('front.product');
Route::get('/product/{slug}', [ShopController::class, 'product'])->name('front.detilProduct');
Route::post('/save-rating/{productId}', [ShopController::class, 'saveRating'])->name('front.saveRating');
Route::get('/about', [AboutController::class, 'index'])->name('front.about');

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
    Route::post('/profileadd', [UserDetailsController::class, 'store'])->name('account.profileAdd');
    Route::get('/profile/{user}/edit', [AuthController::class, 'profileEdit'])->name('account.profileEdit');
    Route::put('/profile/{user}', [UserDetailsController::class, 'update'])->name('account.profileUpdate');
    Route::get('/product/{slug}/review', [ShopController::class, 'review'])->name('front.review');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
    Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
    Route::post('/delete-cart', [CartController::class, 'deleteCart'])->name('front.deleteCart.cart');

     //transaksi 
     Route::get('/transaksi', [TransaksiController::class, 'index'])->name('front.transaksi');
     Route::post('/transaksi/process', [TransaksiController::class, 'process'])->name('front.transaksiProcess');
     Route::post('/transaksi/pay', [TransaksiController::class, 'pay'])->name('front.pay');
     Route::get('/transaksi/pay/{transaction}', [TransaksiController::class, 'status'])->name('transaction.pay');
     Route::get('/transaksi/cek', [TransaksiController::class, 'cek'])->name('transaction.cek');
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
        Route::post('/product-image/update', [ProductImageController::class, 'update'])->name('productImage.update');
        Route::get('/product-page/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product-page/{product}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/product-page', [ProductController::class, 'index'])->name('product.page');
        Route::delete('/product-page/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('/remove-image', [ProductController::class, 'removeImage'])->name('product.removeImage');
        Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('admin.transaksi');
       

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
