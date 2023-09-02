<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ChatController extends Controller
{
    /**
     * Display the view for chat application.
     *
     * @return \Illuminate\View\View
     */
    public function __invoke(): View
    {
        return view('roles.shared.chat');
    }
}
