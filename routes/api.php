<?php

use App\Http\Controllers\API\v1\TherapyDataController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

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

// @see https://laravel.com/docs/9.x/sanctum#authorizing-private-broadcast-channels
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::group([
    'namespace' => 'v1',
    'prefix' => 'v1',
], function () {
    Route::middleware('auth:sanctum')->group(function () {
        // Chatting
        Route::namespace('Chat')->group(function () {
            Route::prefix('chat')->group(function () {
                Route::controller('ChatController')->group(function () {
                    Route::get('/', 'index');
                    Route::get('/search', 'search'); // Search for chat and contacts
                    Route::get('/{chat}', 'show'); // Load individual/group chat

                    Route::post('/', 'create'); // Create new individual/group chat
                    Route::put('/{chat}', 'update'); // Update chat
                });

                Route::controller('MessageController')->group(function () {
                    Route::post('/{chat}/message', 'store'); // Send new message
                    Route::delete('/{chat}/message/{message}', 'destroy'); // Delete message
                    Route::put('/{chat}/message/{message}/seen', 'seen'); // Saw the message
                });
            });

            Route::group([
                'prefix' => 'group',
                'controller' => 'GroupController'
            ], function () {
                Route::post('/', 'store'); // Create new group chat
                Route::put('/{chat}', 'update'); // Update group chat
                Route::put('/{chat}/leave', 'update'); // Leave group chat
            });
        });

        // Notifications
        Route::group([
            'prefix' => 'notifications',
            'controller' => 'NotificationsController'
        ], function () {
            Route::get('/', 'index');
            Route::put('/read', 'read');
            Route::delete('/delete', 'destroy');
        });
    });
    Route::post('/after-tharapy/data', [TherapyDataController::class, 'store']);
    Route::post('/tharapy/send_chat', [TherapyDataController::class, 'send_chat']);
});

Route::post('/analysis-test', function (Request $request) {
    $request->validate([
        'image' => [
            'required',
            File::image()
                ->types(['image/png', 'image/jpeg', 'image/webp'])
                ->max(5 * 1024)
                ->dimensions(
                    Rule::dimensions()
                        ->minHeight(400)
                        ->minWidth(400)
                        ->maxWidth(1000)
                        ->maxHeight(1000)
                )
        ]
    ]);

    if (!$request->file('image')->isValid())
        return response()
            ->setStatusCode(Response::HTTP_BAD_REQUEST)
            ->json(['message' => 'The image was not received as expected!']);

    $filename = sprintf('%s-%s.png', now()->timestamp, hash('crc32b', Str::random()));
    $path = $request->file('image')->storeAs('images', $filename);

    return response()
        ->json([
            'message' => 'The image was uploaded successfully!',
            'path' => $path
        ]);
});

Route::get('test', function () {
    return response()->json(['message' => 'Test API is working!']);
});
