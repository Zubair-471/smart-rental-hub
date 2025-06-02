<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\Catalog\DeviceController as AdminDeviceController;
use App\Http\Controllers\Admin\Catalog\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\Rentals\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Settings\SettingsController;
use App\Http\Controllers\Admin\Settings\ProfileController;

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

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Public Device Routes
Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');

// Public Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');



    // Rental Routes
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [RentalController::class, 'show'])->name('rentals.show');
Route::put('/rentals/{rental}/return', [RentalController::class, 'return'])->name('rentals.return');

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Device management
    Route::get('/devices', [AdminDeviceController::class, 'index'])->name('devices.index');
    Route::get('/devices/create', [AdminDeviceController::class, 'create'])->name('devices.create');
    Route::post('/devices', [AdminDeviceController::class, 'store'])->name('devices.store');
    Route::get('/devices/{device}/edit', [AdminDeviceController::class, 'edit'])->name('devices.edit');
    Route::put('/devices/{device}', [AdminDeviceController::class, 'update'])->name('devices.update');
    Route::delete('/devices/{device}', [AdminDeviceController::class, 'destroy'])->name('devices.destroy');
    
    // Category management
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Rental management
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [AdminRentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [AdminRentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::put('/rentals/{rental}/status', [AdminRentalController::class, 'updateStatus'])->name('rentals.status.update');
    Route::delete('/rentals/{rental}', [AdminRentalController::class, 'destroy'])->name('rentals.destroy');

    // Users Management
    Route::resource('users', UserController::class);

    // Role management
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/test-email', [SettingsController::class, 'testEmail'])->name('settings.test-email');
    Route::get('/settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';