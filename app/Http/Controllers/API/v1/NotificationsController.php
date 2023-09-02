<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Helpers\JSON;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class NotificationsController extends Controller
{
    /**
     * Show requested
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'count' => ['numeric', 'min:1', 'max:1000'],
        ]);

        $notifications = $request
            ->user()
            ->unreadNotifications()
            ->orderByDesc('created_at')
            ->when($request->has('count'), fn ($query) => $query->limit($request->query('count')))
            ->get()
            ->sortBy('created_at')
            ->values();

        return JSON::success($notifications);
    }

    public function read(Request $request): JsonResponse
    {
        $request->user()->notifications()->unread()->update(['read_at' => now()]);

        return JSON::success();
    }

    public function destroy(Request $request)
    {
        $request->user->notifications()->delete();

        return JSON::success();
    }
}
