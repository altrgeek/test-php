<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'super_admin/dashboard', 'middleware' => 'auth'], function () {
    // Super admin routes
    Route::group(['middleware' => 'role:Super Admin', 'namespace' => 'SuperAdmin'], function () {
        // Super admin basic routes
        Route::group(['controller' => 'SuperAdminController'], function () {
            Route::get('/', 'index')->name('super_admin_dashboard');
            Route::get('/addClient', 'addClients')->name('super_admin_dashboard.addClients');
        });
        // Route::post('/')
    });
});
