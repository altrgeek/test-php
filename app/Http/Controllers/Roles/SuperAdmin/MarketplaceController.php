<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Therapies\MarketplaceOption;
use CStr;

class MarketplaceController extends Controller
{
    public function index(): View
    {
        return view('roles.super-admin.marketplace', [
            'options' => MarketplaceOption::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:30'],
            'url'  => ['string', 'url', 'unique:marketplace_options,url']
        ]);

        MarketplaceOption::create($validated);

        return redirect()
            ->route('super_admin.dashboard.marketplace')
            ->with('created', 'The marketplace option was created successfully!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $option = MarketplaceOption::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:30'],
        ]);

        if (
            $request->has('url') &&
            is_string($request->input('url')) &&
            strlen($request->input('url')) > 0 &&
            $request->input('url') != $option->url
        )
            $validated['url'] = $request->validate([
                'url'  => ['string', 'url', 'unique:marketplace_options,url']
            ]);


        $option->update($validated);

        return redirect()
            ->route('super_admin.dashboard.marketplace')
            ->with('updated', 'The marketplace option was updated successfully!');
    }

    public function destroy($id): RedirectResponse
    {
        $option = MarketplaceOption::findOrFail($id);

        $option->delete();

        return redirect()
            ->route('super_admin.dashboard.marketplace')
            ->with('deleted', 'The marketplace option was deleted successfully!');
    }
}
