<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArchivesController extends Controller
{
    public function index(): View
    {
        return view('roles.shared.archives');
    }
}
