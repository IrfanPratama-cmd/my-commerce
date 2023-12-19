<?php

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Ecommerce\CartController;
use App\Http\Controllers\Ecommerce\CheckoutController;
use App\Http\Controllers\Ecommerce\DashboardController;
use App\Http\Controllers\Ecommerce\ProductController as EcommerceProductController;
use App\Http\Controllers\Ecommerce\ProfileController;
use App\Http\Controllers\Ecommerce\TransactionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController as ControllersTransactionController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Permission;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class, 'index'])->name('index');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware('auth');

//Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'postLogin']);
Route::post('/register', [AuthController::class, 'postRegistration']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('account/verify/{token}', [AuthController::class, 'verifyAccount'])->name('user.verify');

Route::get('/forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::get('/create-roles', [RoleController::class, 'create']);
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::get('/roles/{id}', [RoleController::class, 'edit'])->name('roles.edit');
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'edit'])->name('users.edit');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/verify/{token}', [UserController::class, 'verifyAccount'])->name('users.verify');

Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
Route::get('/permissions/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/{id}', [BrandController::class, 'edit'])->name('brands.edit');
Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/create-products', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/transactions', [ControllersTransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/{id}', [ControllersTransactionController::class, 'show'])->name('transactions.show');

Route::get('/detail-product/{id}', [DashboardController::class, 'showProduct'])->middleware(['auth','is_verify_email']);

Route::get('/user-profile', [ProfileController::class, 'index'])->name('profile.index')->middleware(['auth','is_verify_email']);
Route::get('/edit-profile', [ProfileController::class, 'edit'])->middleware(['auth','is_verify_email']);
Route::post('/update-profile', [ProfileController::class, 'update'])->middleware(['auth','is_verify_email']);

//Product
Route::get('/get-products', [EcommerceProductController::class, 'index'])->middleware(['auth','is_verify_email']);
Route::get('/get-by-category/{id}', [EcommerceProductController::class, 'getByCategory'])->middleware(['auth','is_verify_email']);

//Cart
Route::get('/carts', [CartController::class, 'index'])->middleware(['auth','is_verify_email'])->name('cart');
Route::get('add-to-cart/{id}', [CartController::class, 'addToCart'])->middleware(['auth','is_verify_email'])->name('add.to.cart');
Route::get('/delete-cart/{id}', [CartController::class, 'destroy'])->name('remove.from.cart');
Route::get('/addQty/{id}', [CartController::class, 'addQty'])->name('remove.from.cart');
Route::get('/rmQty/{id}', [CartController::class, 'rmQty'])->name('remove.from.cart');
Route::post('/cart-update/{id}/{product_id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/count-carts', [CartController::class, 'countCart']);

//Checkout
Route::get('/checkouts', [CheckoutController::class, 'index'])->middleware(['auth','is_verify_email'])->name('checkout');
Route::post('/checkouts', [CheckoutController::class, 'create'])->middleware(['auth','is_verify_email']);

//Transaction
Route::get('/user-transactions', [TransactionController::class, 'index'])->middleware(['auth','is_verify_email']);
Route::get('/invoice/{id}', [TransactionController::class, 'invoice'])->middleware(['auth','is_verify_email']);
Route::post('/cancel-transactions/{id}', [TransactionController::class, 'cancel'])->middleware(['auth','is_verify_email']);
