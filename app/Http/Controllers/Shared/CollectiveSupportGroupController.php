<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CollectiveSupportGroupController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $content = Setting::firstOrCreate(['name' => 'collective_support_content'])->value;


        if ($user->isSuperAdmin())
            return view('roles.super-admin.collective-support', compact('content'));

        return view('roles.shared.collective-support', compact('content'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['content' => ['required', 'string', 'max:100000']]);

        Setting::updateOrCreate([
            'name' => 'collective_support_content'
        ], [
            'value' => $request->input('content')
        ]);

        return redirect()->route('dashboard.collective-support')
            ->with('updated', 'Collective support information updated!');
    }
}
