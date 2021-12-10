<?php
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// sales & rent
Route::get('/sales', [App\Http\Controllers\Sales::class, 'index'])->name('sales');
Route::post('/sales/add', [App\Http\Controllers\Sales::class, 'add'])->name('add');
Route::post('/sales/edit', [App\Http\Controllers\Sales::class, 'edit'])->name('edit');
Route::post('/sales/delete', [App\Http\Controllers\Sales::class, 'delete'])->name('delete');
Route::get('/rent', [App\Http\Controllers\Sales::class, 'rent'])->name('rent');

// inventory
Route::get('/inventory', [App\Http\Controllers\ItemInventory::class, 'index'])->name('inventory');
Route::post('/inventory/add', [App\Http\Controllers\ItemInventory::class, 'add'])->name('add');
Route::post('/inventory/edit', [App\Http\Controllers\ItemInventory::class, 'edit'])->name('edit');
Route::post('/inventory/delete', [App\Http\Controllers\ItemInventory::class, 'delete'])->name('delete');
Route::post('/inventory/stockIn', [App\Http\Controllers\ItemInventory::class, 'stockIn'])->name('stockIn');

// Profile
Route::post('/profile/update', [App\Http\Controllers\Main::class, 'updateProfile'])->name('updateProfile');
Route::post('/profile/changePassword', [App\Http\Controllers\Main::class, 'changePassword'])->name('changePassword');

// Main
Route::get('/about', [App\Http\Controllers\Main::class, 'about'])->name('about');
Route::get('/dashboard', [App\Http\Controllers\Main::class, 'dashboard'])->name('dashboard');

// Employee
Route::get('/employeeList', [App\Http\Controllers\Employee::class, 'index'])->name('index');
Route::post('/employee/add', [App\Http\Controllers\Employee::class, 'add'])->name('add');
Route::post('/employee/edit', [App\Http\Controllers\Employee::class, 'edit'])->name('edit');
Route::post('/employee/delete', [App\Http\Controllers\Employee::class, 'delete'])->name('delete');
Route::post('/schedule/add', [App\Http\Controllers\Employee::class, 'addSchedule'])->name('addSchedule');
Route::post('/schedule/get', [App\Http\Controllers\Employee::class, 'getSchedule'])->name('getSchedule');

// Measurement
Route::get('/measurement', [App\Http\Controllers\Measurement::class, 'index'])->name('measurement');
Route::post('/measurement/add', [App\Http\Controllers\Measurement::class, 'add'])->name('add');


//orders
Route::get('/orders', [App\Http\Controllers\Orders::class, 'index'])->name('index');
Route::post('/orders/add', [App\Http\Controllers\Orders::class, 'add'])->name('add');
Route::post('/orders/edit', [App\Http\Controllers\Orders::class, 'edit'])->name('edit');
Route::post('/orders/delete', [App\Http\Controllers\Orders::class, 'delete'])->name('delete');

//customization
Route::get('/customization', [App\Http\Controllers\Customization::class, 'index'])->name('index');
Route::post('/customize/add', [App\Http\Controllers\Customization::class, 'add'])->name('add');
Route::post('/customize/edit', [App\Http\Controllers\Customization::class, 'edit'])->name('edit');
Route::post('/customize/delete', [App\Http\Controllers\Customization::class, 'delete'])->name('delete');