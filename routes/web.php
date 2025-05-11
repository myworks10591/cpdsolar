<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerStatusController;
use App\Http\Controllers\UserController;
use App\Exports\CustomersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersStatusExport;
use App\Http\Controllers\DispatchController;
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
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Auth::routes(['register' => true]);

Route::get('admin/customers/export', function () {
    return Excel::download(new CustomersExport, 'customers.xlsx');
})->name('admin.customers.export');
Route::get('admin/customersstatus/export', function () {
    return Excel::download(new CustomersStatusExport, 'customersStatus.xlsx');
})->name('admin.customersstatus.export');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::resource('customers', CustomerController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('products', ProductController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('customer_statuses', CustomerStatusController::class);
    Route::get('/get-customers/{group_id}', [CustomerController::class, 'getCustomers'])->name('customers.byGroup');
    Route::post('/sync-customers', [CustomerStatusController::class, 'syncCustomers'])->name('sync-customers');
    Route::resource('users', UserController::class);
    Route::get('/getInstallationPending', [CustomerController::class, 'getInstallationPending'])->name('getInstallationPending');
    Route::get('/getNetMetringPending', [CustomerController::class, 'getNetMetringPending'])->name('getNetMetringPending');
    Route::get('/getOnlineInstallationPending', [CustomerController::class, 'getOnlineInstallationPending'])->name('getOnlineInstallationPending');
    Route::get('/getListOfDueCustomer', [CustomerController::class, 'getListOfDueCustomer'])->name('getListOfDueCustomer');
    Route::get('/getListOfPaymentReceivedCustomer', [CustomerController::class, 'getListOfPaymentReceivedCustomer'])->name('getListOfPaymentReceivedCustomer');
    Route::resource('dispatches', DispatchController::class);
    Route::get('/getListOfPendingCustomer', [CustomerController::class, 'getListOfPendingCustomer'])->name('getListOfPendingCustomer');
    Route::get('/getSupsidyPendingFirst', [CustomerController::class, 'getSupsidyPendingFirst'])->name('getSupsidyPendingFirst');
    Route::get('/getSupsidyPendingSecond', [CustomerController::class, 'getSupsidyPendingSecond'])->name('getSupsidyPendingSecond');
    Route::get('/getSupsidyFirst', [CustomerController::class, 'getSupsidyFirst'])->name('getSupsidyFirst');
    Route::get('/getSupsidySecond', [CustomerController::class, 'getSupsidySecond'])->name('getSupsidySecond');
    Route::get('/getPendingAccountNumber', [CustomerController::class, 'getPendingAccountNumber'])->name('getPendingAccountNumber');

    
});
