<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    Route::post('/login', 'AuthController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/profile', 'AuthController@profile')->name('api.profile');
        Route::get('/setting', 'AuthController@setting')->name('api.setting');
        Route::put('/setting', 'AuthController@updateSetting')->name('api.setting.store');
        Route::get('/logout', 'AuthController@logout')->name('logout');
        Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');

        Route::get('/users', 'UserController@index')->name('api.users.index');
        Route::post('/users', 'UserController@store')->name('api.users.store');
        Route::get('/users/create', 'UserController@create')->name('api.users.create');
        Route::get('/users/{id}', 'UserController@show')->name('api.users.show');
        Route::put('/users/{id}', 'UserController@update')->name('api.users.update');
        Route::delete('/users/{id}', 'UserController@delete')->name('api.users.delete');
        Route::get('/users/{id}/edit', 'UserController@edit')->name('api.users.edit');

        Route::get('/brands', 'BrandController@index')->name('api.brands.index');
        Route::post('/brands', 'BrandController@store')->name('api.brands.store');
        Route::get('/brands/create', 'BrandController@create')->name('api.brands.create');
        Route::get('/brands/{id}', 'BrandController@show')->name('api.brands.show');
        Route::put('/brands/{id}', 'BrandController@update')->name('api.brands.update');
        Route::delete('/brands/{id}', 'BrandController@delete')->name('api.brands.delete');
        Route::get('/brands/{id}/edit', 'BrandController@edit')->name('api.brands.edit');


        Route::post('/categories', 'CategoryController@store')->name('api.categories.store');
        Route::get('/categories', 'CategoryController@index')->name('api.categories.index');
        Route::get('/categories/create', 'CategoryController@create')->name('api.categories.create');
        Route::get('/categories/{id}', 'CategoryController@show')->name('api.categories.show');
        Route::put('/categories/{id}', 'CategoryController@update')->name('api.categories.update');
        Route::delete('/categories/{id}', 'CategoryController@delete')->name('api.categories.delete');
        Route::get('/categories/{id}/edit', 'CategoryController@edit')->name('api.categories.edit');


        Route::get('/products', 'ProductController@index')->name('api.products.index');
        Route::post('/products', 'ProductController@store')->name('api.products.store');
        Route::get('/products/create', 'ProductController@create')->name('api.products.create');
        Route::get('/products/{id}', 'ProductController@show')->name('api.products.show');
        Route::put('/products/{id}', 'ProductController@update')->name('api.products.update');
        Route::delete('/products/{id}', 'ProductController@delete')->name('api.products.delete');
        Route::get('/products/{id}/edit', 'ProductController@edit')->name('api.products.edit');
        Route::get('/products/restore/{id}', 'ProductController@restore')->name('api.products.restore');
        Route::delete('/products/permanent/{id}', 'ProductController@permanent_delete')->name('api.products.permanent.delete');
        Route::get('/products/search/{query}', 'ProductController@search')->name('api.products.search');


        Route::get('/suppliers', 'SupplierController@index')->name('api.suppliers.index');
        Route::post('/suppliers', 'SupplierController@store')->name('api.suppliers.store');
        Route::get('/suppliers/create', 'SupplierController@create')->name('api.suppliers.create');
        Route::get('/suppliers/{id}', 'SupplierController@show')->name('api.suppliers.show');
        Route::put('/suppliers/{id}', 'SupplierController@update')->name('api.suppliers.update');
        Route::get('/suppliers/{id}/edit', 'SupplierController@edit')->name('api.suppliers.edit');
        Route::get('/suppliers/emailexist/{email}', 'SupplierController@emailexist')->name('api.suppliers.emailexist');
        Route::get('/suppliers/phoneexist/{phone}', 'SupplierController@phoneexist')->name('api.suppliers.phoneexist');

        Route::get('/purchases', 'PurchaseController@index')->name('api.purchases.index');
        Route::post('/purchases', 'PurchaseController@store')->name('api.purchases.store');
        Route::get('purchases/create', 'PurchaseController@create')->name('api.purchase.create');
        Route::get('/purchases/{id}', 'PurchaseController@show')->name('api.purchases.show');
        Route::put('/purchases/{id}', 'PurchaseController@update')->name('api.purchases.update');
        Route::delete('/purchases/{id}', 'PurchaseController@delete')->name('api.purchases.delete');
        Route::get('/purchases/{id}/edit', 'PurchaseController@edit')->name('api.purchases.edit');

        Route::get('/sales', 'SaleController@index')->name('api.sales.index');
        Route::post('/sales', 'SaleController@store')->name('api.sales.store');
        Route::get('sales/create', 'SaleController@create')->name('api.sale.create');
        Route::get('/sales/{id}', 'SaleController@show')->name('api.sales.show');
        Route::put('/sales/{id}', 'SaleController@update')->name('api.sales.update');
        Route::delete('/sales/{id}', 'SaleController@delete')->name('api.sales.delete');
        Route::get('/sales/{id}/edit', 'SaleController@edit')->name('api.sales.edit');

        Route::get('/companies', 'CompanyController@index')->name('api.companies.index');
        Route::put('/companies', 'CompanyController@update')->name('api.companies.update');

        Route::get('/stock', 'CurrentStockController@index')->name('api.current.stock.index');
        Route::get('/stock/check/{product_id}', 'CurrentStockController@check')->name('api.current.stock.check');

        Route::get('/opening-stock', 'OpeningStockDetailsController@index')->name('api.opening.stock.index');
        Route::post('/opening-stock', 'OpeningStockDetailsController@store')->name('api.opening.stock.store');

        Route::get('/reports/daily', 'ReportController@daily')->name('api.reports.sales.daily');
        Route::get('/reports/monthly', 'ReportController@monthly')->name('api.reports.sales.monthly');
        Route::get('/reports/yearly', 'ReportController@yearly')->name('api.reports.sales.yearly');
        Route::get('/reports/daily/{date}', 'ReportController@specific_date')->name('api.reports.sales.specific_date');
        Route::get('/reports/yearly/{year}', 'ReportController@specific_yearly')->name('api.reports.sales.specific_yearly');
        Route::get('/reports/monthly/{month}/{year}', 'ReportController@specific_monthly')->name('api.reports.sales.specific_month');


    });

});



