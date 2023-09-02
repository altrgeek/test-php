<?php

use App\Http\Controllers\Roles\Provider\ProviderToDoListingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CalendarContoller;
use App\Http\Controllers\Shared\VRTherapiesController;
use Packages\AgoraRTC\RtcTokenBuilder2 as TokenBuilder;
use App\Http\Controllers\Roles\Client\ClientToDoListingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Roles\Admin\AdminTaskController;
use App\Http\Controllers\Roles\Provider\ProviderTaskController;
use App\Http\Controllers\Roles\SuperAdmin\SuperAdminTaskController;
use App\Http\Controllers\Shared\ToDoChatController;

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

// Login form will be displayed instead of landing page
Route::get('/', [LoginController::class, 'showLoginForm'])
    ->name('show-login');

Auth::routes();
Route::get('/invoice', function () {
    return view('super-admin.invoice');
});

// Authentication routes
Route::middleware('auth')->group(function () {

    // Super Admin accessible routes
    Route::group([
        'prefix' => 'super-admin',
        'middleware' => 'role:super_admin',
        'namespace' => 'Roles\SuperAdmin'
    ], function () {
        Route::name('super_admin.')->group(function () {
        Route::get('/dashboard', 'SuperAdminController@dashboard')->name('dashboard');
            
            Route::prefix('dashboard')->name('dashboard.')->group(function () {
                Route::resource('marketplace', 'MarketplaceController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create', 'show', 'edit'])
                    ->names([
                        'index'   => 'marketplace',
                        'store'   => 'marketplace.create',
                        'destroy' => 'marketplace.delete'
                    ]);

                // New requests CRUD operations
                Route::resource('requests', 'RequestsController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create', 'show', 'edit'])
                    ->names([
                        'index' => 'requests',
                        'store' => 'requests.create',
                        'destroy' => 'requests.delete'
                    ]);


                // Read-only resources
                Route::get('requests', 'RequestsController@index');
                Route::get('clients', 'ClientsController@index')
                    ->name('clients')
                    ->middleware('check.support');

                // Admin accounts CRUD operations
                Route::resource('admins', 'AdminsController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create', 'show', 'edit'])
                    ->names([
                        'index' => 'admins',
                        'store' => 'admins.create',
                        'destroy' => 'admins.delete'
                    ]);

                // User accounts CRUD operations
                Route::resource('users', 'UsersController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create', 'show', 'edit'])
                    ->names([
                        'index' => 'users',
                        'store' => 'users.create',
                        'destroy' => 'users.delete'
                    ])
                    ->middleware('check.support');

                // subscriptions CRUD operations
                Route::resource('subscription', 'SubscriptionController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create', 'edit'])
                    ->names([
                        'index' => 'subscriptions',
                        'store' => 'subscriptions.create',
                        'show' => 'subscriptions.show',
                        'update' => 'subscriptions.update',
                        'destroy' => 'subscriptions.delete'
                    ]);

                // Payments operations
                Route::resource('payments', 'PaymentsController')
                    ->except(['create', 'edit'])
                    ->names([
                        'index' => 'payments',
                        'store' => 'payments.create',
                        'show' => 'payments.show',
                        'destroy' => 'payments.delete'
                    ]);

                // Package operations
                Route::resource('packages', 'PackagesController')
                    ->only(['index', 'show', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'packages',
                        'show' => 'packages.show',
                        'store' => 'packages.create',
                        'destroy' => 'packages.delete'
                    ]);

                // Appointments CRUD operations
                Route::patch('appointments/decline/{id}', 'AppointmentsController@decline')
                    ->name('appointments.decline');
                Route::resource('appointments', 'AppointmentsController')
                    // No need of create route as it will be handled through
                    // a popup modal
                    ->except(['create'])
                    ->names([
                        'index' => 'appointments',
                        'destroy' => 'appointments.delete'
                    ]);

                    
                Route::get('/support-password', [\App\Http\Controllers\Roles\Support\Supportpassword::class, 'index'])
                    ->name('support.password');
                Route::post('/support-password', [\App\Http\Controllers\Roles\Support\Supportpassword::class, 'verify_password'])
                    ->name('support.password');
            });
        });
    });

    // Admin accessible routes
    Route::group([
        'prefix' => 'admin',
        'middleware' => 'role:admin',
        'namespace' => 'Roles\Admin'
    ], function () {
        Route::name('admin.')->group(function () {
            Route::get('/profile', 'ProfileController@index')->name('profile');
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/edit', 'ProfileController@edit')->name('edit');
                Route::put('/', 'ProfileController@update')->name('update');
                Route::patch('/avatar', 'ProfileController@avatar')->name('avatar');
            });
            Route::get('provider-to-do-listing',[AdminTaskController::class,'create'])->name('client-to-do-listing');
            Route::post('/storeListing',[AdminTaskController::class,'store'])->name('storeListing');
            Route::put('editTodoListing',[AdminTaskController::class,'edit'])->name('editTodoListing');

            Route::get('/calendar',[AdminTaskController::class,'index'])->name('todo_calendar');
            Route::get('/showTask/{id}',[AdminTaskController::class,'show'])->name('showTask');
            Route::get('/accept/{id}',[AdminTaskController::class,'accept'])->name('accept');
            Route::get('/reject/{id}',[AdminTaskController::class,'reject'])->name('reject');
            Route::get('/complete/{id}',[AdminTaskController::class,'complete'])->name('complete');
            Route::get('/delete/{id}',[AdminTaskController::class,'delete'])->name('delete');
         
            // Moving the route definition out of group because the route name
            // prefix will make it `dashboard.dashboard` if placed inside name
            // prefix group
            Route::get('/dashboard', 'AdminController@dashboard')->name('dashboard');
            Route::post('/update_branding', 'AdminController@update_branding')->name('update_branding');
            Route::prefix('dashboard')->name('dashboard.')->group(function () {
                
                
                // Providers accounts CRUD operations
                Route::resource('providers', 'ProvidersController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->only(['index', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'providers',
                        'store' => 'providers.create',
                        'update' => 'providers.edit',
                        'destroy' => 'providers.delete'
                    ]);

                // Subscription operations
                Route::get('subscriptions/subscribed', 'SubscriptionsController@details')
                    ->name('subscriptions.details');
                Route::resource('subscriptions', 'SubscriptionsController')
                    ->only(['index', 'show', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'subscriptions',
                        'show' => 'subscriptions.show',
                        'store' => 'subscriptions.create',
                        'destroy' => 'subscriptions.delete'
                    ]);

                // Package operations
                Route::resource('packages', 'PackagesController')
                    ->only(['index', 'show', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'packages',
                        'show' => 'packages.show',
                        'store' => 'packages.create',
                        'destroy' => 'packages.delete'
                    ]);

                // Payments operations
                Route::resource('payments', 'PaymentsController')
                    ->except(['create', 'edit'])
                    ->names([
                        'index' => 'payments',
                        'store' => 'payments.create',
                        'show' => 'payments.show',
                        'destroy' => 'payments.delete'
                    ]);

                Route::prefix('appointments')
                    ->name('appointments.')
                    ->group(function () {
                        // Appointments with super admin
                        Route::resource('super_admin', 'SuperAdminAppointmentsController')
                            // No need of create route as it will be handled through
                            // a popup modal
                            ->except(['create'])
                            ->names([
                                'index' => 'super_admin',
                                'destroy' => 'super_admin.delete'
                            ]);

                        // Appointments with providers
                        Route::prefix('provider/{id}')
                            ->controller('ProviderAppointmentsController')
                            ->group(function () {
                                Route::get('/review', 'reviewForm')->name('provider.reviewForm');
                                Route::patch('/review', 'review')->name('provider.review');
                                Route::patch('/decline', 'decline')->name('provider.decline');
                            });
                        Route::resource('provider', 'ProviderAppointmentsController')
                            // No need of create route as it will be handled through
                            // a popup modal
                            ->except(['create'])
                            ->names([
                                'index' => 'provider',
                                'destroy' => 'provider.delete'
                            ]);
                    });
            });
        });
    });

    // Provider accessible routes
    Route::group([
        'prefix' => 'provider',
        'middleware' => 'role:provider',
        'namespace' => 'Roles\Provider'
    ], function () {
        Route::name('provider.')->group(function () {
            Route::post('/storeGroupListing',[ProviderToDoListingController::class,'storeGroup'])->name('storeGroup');
            Route::post('/storeListing',[ProviderToDoListingController::class,'store'])->name('storeListing');
            Route::get('/show-to-do-list/{vr_id}',[ProviderToDoListingController::class,'show'])->name('show-to-do-list');
            Route::get('/show-to-do-list-groups/{vr_id}',[ProviderToDoListingController::class,'showGroups'])->name('show-to-do-list-groups');
            Route::put('editTodoListing',[ProviderToDoListingController::class,'edit'])->name('editTodoListing');
            Route::put('editTodoListingGroup',[ProviderToDoListingController::class,'editgroup'])->name('editTodoListingGroup');

            
            Route::get('/calendar',[ProviderTaskController::class,'index'])->name('todo_calendar');
            Route::get('/showTask/{id}',[ProviderTaskController::class,'show'])->name('showTask');
            Route::get('/accept/{id}',[ProviderTaskController::class,'accept'])->name('accept');
            Route::get('/reject/{id}',[ProviderTaskController::class,'reject'])->name('reject');
            Route::get('/complete/{id}',[ProviderTaskController::class,'complete'])->name('complete');
            Route::get('/delete/{id}',[ProviderTaskController::class,'delete'])->name('delete');

            // Moving the route definition out of group because the route name
            // prefix will make it `dashboard.dashboard` if placed inside name
            // prefix group
            Route::get('/dashboard', 'ProviderController@dashboard')->name('dashboard');
            Route::prefix('dashboard')->name('dashboard.')->group(function () {

                // Client accounts CRUD operations
                Route::resource('clients', 'ClientsController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create', 'show', 'edit'])
                    ->names([
                        'index' => 'clients',
                        'store' => 'clients.create',
                        'destroy' => 'clients.delete',
                        'edit' => 'clients.update'
                    ]);

                // Payments operations
                Route::resource('payments', 'PaymentsController')
                    ->except(['create', 'edit'])
                    ->names([
                        'index' => 'payments',
                        'store' => 'payments.create',
                        'show' => 'payments.show',
                        'destroy' => 'payments.delete'
                    ]);

                // Packages operations
                Route::resource('packages', 'PackageController')
                    ->except(['create', 'edit'])
                    ->names([
                        'index' => 'packages',
                        'store' => 'packages.create',
                        'show' => 'packages.show',
                        'destroy' => 'packages.delete'
                    ]);

                Route::prefix('appointments')
                    ->name('appointments.')
                    ->group(function () {
                        // Appointments with admin
                        Route::resource('admin', 'AdminAppointmentsController')
                            // No need of create route as it will be handled through
                            // a popup modal
                            ->except(['create'])
                            ->names([
                                'index' => 'admin',
                                'destroy' => 'admin.delete'
                            ]);

                        // Appointments with clients
                        Route::prefix('client/{id}')
                            ->controller('ClientAppointmentsController')
                            ->group(function () {
                                Route::get('/review', 'reviewForm')->name('client.reviewForm');
                                Route::patch('/review', 'review')->name('client.review');
                                Route::patch('/decline', 'decline')->name('client.decline');
                            });

                        Route::resource('client', 'ClientAppointmentsController')
                            // No need of create route as it will be handled through
                            // a popup modal
                            ->except(['create'])
                            ->names([
                                'index' => 'client',
                                'destroy' => 'client.delete'
                            ]);
                    });

                // Archive viewing and downloading
                Route::group([
                    'prefix' => 'archives',
                    'controller' => 'ArchivesController'
                ], function () {
                    Route::get('/', 'index')->name('archives');
                    Route::get('/download/{id}', 'download_data_file')->name('archives.download');
                });
            });
        });
    });

    // Client accessible routes
    Route::group([
        'prefix' => 'client',
        'middleware' => 'role:client',
        'namespace' => 'Roles\Client'
    ], function () {
        Route::name('client.')->group(function () {
            // Moving the route definition out of group because the route name
            // prefix will make it `dashboard.dashboard` if placed inside name
            // prefix group
            Route::get('/dashboard', 'ClientController@dashboard')->name('dashboard');
            Route::name('dashboard.')->group(function () {
                // Appointments CRUD operations
                Route::resource('appointments', 'AppointmentsController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->except(['create'])
                    ->names([
                        'index' => 'appointments',
                        'destroy' => 'appointments.delete'
                    ]);

                Route::get("client-to-do",[ClientToDoListingController::class,'index'])->name('client_to_do');
                Route::get("client-to-do/{id}",[ClientToDoListingController::class,'preview'])->name('client_to_do_preview');

                //make accept and reject routes
                Route::get('/accept/{id}',[ClientToDoListingController::class,'accept'])->name('accept');
                Route::get('/reject/{id}',[ClientToDoListingController::class,'reject'])->name('reject');
                Route::get('/complete/{id}',[ClientToDoListingController::class,'complete'])->name('complete');
                Route::resource('orders', 'OrderController')
                    // No need of additional views as CRUD operations will be
                    // handled from a single table view through modals
                    ->only(['store'])
                    ->names([
                        'store' => 'order.create',
                    ]);

                // Payments operations
                Route::resource('payments', 'PaymentsController')
                    ->except(['create', 'edit'])
                    ->names([
                        'index' => 'payments',
                        'store' => 'payments.create',
                        'show' => 'payments.show',
                        'destroy' => 'payments.delete'
                    ]);

                // Package operations
                Route::resource('packages', 'PackagesController')
                    ->only(['index', 'show', 'store', 'update', 'destroy'])
                    ->names([
                        'index' => 'packages',
                        'show' => 'packages.show',
                        'store' => 'packages.create',
                        'destroy' => 'packages.delete'
                    ]);
            });
        });
    });

    // Shared routes
    Route::prefix('dashboard')
        ->namespace('Shared')
        ->name('dashboard.')
        ->group(function () {
            // Profile routes
            Route::get('/wellness-program', function () {
                return view("roles.shared.wellness_program");
            })->name('wellness-program');
            Route::get('/profile', 'ProfileController@index')->name('profile');
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('/edit', 'ProfileController@edit')->name('edit');
                Route::put('/', 'ProfileController@update')->name('update');
                Route::patch('/avatar', 'ProfileController@avatar')->name('avatar');
            });
            
            Route::post('todoChat/{taskId}', [ToDoChatController::class,'create'])->name('todoChat');


            Route::get('/delete/{id}',[SuperAdminTaskController::class,'delete'])->name('delete');
            // VR Therapies routes
            Route::resource('vr-therapies', 'VRTherapiesController')
                // No need of additional views as CRUD operations will be
                // handled from a single table view through modals
                ->except(['create', 'show', 'edit'])
                ->names([
                    'index'   => 'vr-therapies',
                    'store'   => 'vr-therapies.create',
                    'destroy' => 'vr-therapies.delete'
                ]);
            Route::get('vr-therapies-groups',[VRTherapiesController::class,'groups'])->name('vr-therapies-groups');
            Route::get('superadmin-todo-listing',[SuperAdminTaskController::class,'create'])->name('show-super-admin-todo-listing');
            Route::post('/storeGroupListing',[SuperAdminTaskController::class,'storeGroup'])->name('storeGroup');
            Route::post('/storeListing',[SuperAdminTaskController::class,'store'])->name('storeListing');
            Route::put('editTodoListing',[SuperAdminTaskController::class,'edit'])->name('editTodoListing');
            Route::put('editTodoListingGroup',[SuperAdminTaskController::class,'editgroup'])->name('editTodoListingGroup');
            
               

            // About Cogni collective support
            Route::resource('collective-support', 'CollectiveSupportGroupController')
                ->only(['index', 'store'])
                ->names([
                    'index' => 'collective-support',
                    'store' => 'collective-support.save',
                ]);

            // Chat routes
            Route::get('chats', 'ChatController')->name('chat');

            // Archive route
            Route::get('archives', 'ArchivesController@index')->name('archives');

            // Meeting routes
            Route::prefix('session')
                ->controller('MeetingController')
                ->name('session.')
                ->group(function () {
                    Route::view('/', 'roles.shared.meeting.auth')->name('auth');
                    Route::get('join', 'session')->name('join');
                    Route::post('verify', 'verify')->name('verify');
                });

            // Site analytics routes
            Route::group([
                'prefix' => 'analytics',
                'namespace' => 'Analytics',
            ], function () {
                Route::get('analytics', 'BaseAnalyticsController')->name('analytics');

                Route::name('analytics.')->group(function () {
                    // Client analytics routes
                    Route::get('/clients', 'ClientAnalyticsController@index')->name('clients');
                    Route::prefix('client/{client}')
                        ->name('client.')
                        ->controller('ClientAnalyticsController')
                        ->group(function () {
                            Route::get('/sessions', 'sessions')->name('sessions');
                            Route::get('/packages', 'packages')->name('packages');
                            Route::get('/spending', 'spending')->name('spending');
                        });

                    // Provider analytics routes
                    Route::get('/providers', 'ProviderAnalyticsController@index')->name('providers');
                    Route::prefix('provider/{provider}')
                        ->name('provider.')
                        ->controller('ProviderAnalyticsController')
                        ->group(function () {
                            Route::get('/sessions', 'sessions')->name('sessions');
                            Route::get('/therapies', 'therapies')->name('therapies');
                        });
                    

                    // Admin analytics routes
                    Route::get('/admins', 'AdminAnalyticsController@index')->name('admins');
                    Route::prefix('admin/{admin}')
                        ->name('admin.')
                        ->controller('AdminAnalyticsController')
                        ->group(function () {
                            Route::get('/packages', 'packages')->name('packages');
                        });
                });
            });
        });
});

// User translation preference updates
Route::get('translation', 'TranslationController@index')->name('language.update');



Route::get('/test',[VRTherapiesController::class,'test']);