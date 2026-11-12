<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Home (First Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Login / Register ...)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout (إذا تستخدمه من AuthController)
   
    /*
    |--------------------------------------------------------------------------
    | Inventory
    |--------------------------------------------------------------------------
    */
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/table', [InventoryController::class, 'table'])->name('inventory.table');
    Route::get('/inventory/alerts', [InventoryController::class, 'alerts'])->name('inventory.alerts');

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::get('/search', [CategoryController::class, 'search'])->name('categories.search');
        Route::get('/{id}/details', [CategoryController::class, 'getCategoryDetails'])->name('categories.details');
    });

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::post('/', [ProductController::class, 'store'])->name('products.store');
        Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/{id}/details', [ProductController::class, 'getProductDetails'])->name('products.details');
        Route::get('/generate-barcode', [ProductController::class, 'generateBarcode'])->name('products.generate-barcode');
        Route::get('/check-barcode/{barcode}', [ProductController::class, 'checkBarcode'])->name('products.check-barcode');
        Route::post('/{id}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::get('/stats', [ProductController::class, 'getStats'])->name('products.stats');
    });

    /*
    |--------------------------------------------------------------------------
    | Sales (POS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('sales')->group(function () {
        Route::get('/', [SalesController::class, 'index'])->name('sales.index');
        Route::post('/', [SalesController::class, 'store'])->name('sales.store');
        Route::get('/{sale}', [SalesController::class, 'show'])->name('sales.show');
        Route::get('/{sale}/print', [SalesController::class, 'print'])->name('sales.print');
        Route::delete('/{sale}/cancel', [SalesController::class, 'cancel'])->name('sales.cancel');
    });

    /*
    |--------------------------------------------------------------------------
    | Customers
    |--------------------------------------------------------------------------
    */
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    Route::post('/customer-payments', [CustomerController::class, 'storePayment'])->name('customer-payments.store');

    /*
    |--------------------------------------------------------------------------
    | Suppliers
    |--------------------------------------------------------------------------
    */
    Route::resource('suppliers', SupplierController::class);
    Route::get('suppliers/{supplier}/purchases', [SupplierController::class, 'purchases'])->name('suppliers.purchases');
    Route::get('suppliers/{supplier}/payments', [SupplierController::class, 'payments'])->name('suppliers.payments');

    /*
    |--------------------------------------------------------------------------
    | Purchases
    |--------------------------------------------------------------------------
    */
    Route::prefix('purchases')->group(function () {
        Route::get('/', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('/create', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

        // APIs
        Route::get('/api/suppliers', [PurchaseController::class, 'getSuppliers'])->name('purchases.api.suppliers');
        Route::get('/api/products', [PurchaseController::class, 'getProducts'])->name('purchases.api.products');
        Route::get('/api/invoice-number', [PurchaseController::class, 'generateInvoiceNumber'])->name('purchases.api.invoice-number');
    });

    /*
    |--------------------------------------------------------------------------
    | Reports
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/data', [ReportController::class, 'getReportData'])->name('reports.data');
        Route::post('/export', [ReportController::class, 'export'])->name('reports.export');
    });

   

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/profile/update', [SettingsController::class, 'updateProfile'])->name('settings.profile.update');
        Route::post('/password/change', [SettingsController::class, 'changePassword'])->name('settings.password.change');
        Route::post('/system/save', [SettingsController::class, 'saveSystemSettings'])->name('settings.system.save');
        Route::get('/profile/data', [SettingsController::class, 'getProfileData'])->name('settings.profile.data');
        Route::get('/system/data', [SettingsController::class, 'getSystemSettingsData'])->name('settings.system.data');
    });

});

/*
|--------------------------------------------------------------------------
| Fallback
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return view('errors.404');
});

// روتات العملاء
Route::middleware(['auth'])->group(function () {
    // صفحات العملاء
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    
    // إضافة عميل جديد
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    
    // عرض تفاصيل عميل
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    
    // تعديل عميل
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    
    // حذف عميل
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    // تسديد دين عميل
    Route::post('/customer-payments', [CustomerController::class, 'storePayment'])->name('customer.payments.store');
});



// مسارات العملاء
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    
    // إضافة مسار debug
    Route::get('/{id}/debug', function($id) {
        $customer = \App\Models\Customer::find($id);
        if ($customer) {
            return response()->json([
                'found' => true,
                'customer' => $customer,
                'route' => 'customers/' . $id
            ]);
        }
        return response()->json([
            'found' => false,
            'message' => 'Customer not found',
            'route' => 'customers/' . $id
        ]);
    });
});

// مسارات مدفوعات العملاء
Route::prefix('customer-payments')->group(function () {
    Route::post('/', [CustomerPaymentController::class, 'store'])->name('customer-payments.store');
    Route::get('/customer/{customerId}', [CustomerPaymentController::class, 'getCustomerPayments'])->name('customer-payments.customer');
    Route::delete('/{id}', [CustomerPaymentController::class, 'destroy'])->name('customer-payments.destroy');
    
    // إضافة مسار debug
    Route::get('/test/{customerId}', function($customerId) {
        return response()->json([
            'route' => 'customer-payments/test/' . $customerId,
            'customer_id' => $customerId
        ]);
    });
});

// مسار للفحص
Route::get('/api-test/{id}', function($id) {
    $customer = \App\Models\Customer::find($id);
    return response()->json([
        'customer_exists' => $customer ? true : false,
        'customer_id' => $id,
        'app_url' => config('app.url')
    ]);
});

Route::get('/customers/{id}/debug', [CustomerController::class, 'debug']);

// Route لعرض نموذج التعديل
Route::get('/products/{id}/edit', 'ProductController@edit')->name('products.edit');

// Route لتحديث المنتج
Route::put('/products/{id}', 'ProductController@update')->name('products.update');