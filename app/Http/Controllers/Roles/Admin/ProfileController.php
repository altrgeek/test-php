<?php

namespace App\Http\Controllers\Roles\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Roles\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {

        return view('roles.admin.profile.index', [
            'user' => $request->user()
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        $segments = config('cogni.admins.segments');
        $user = $request->user();
        $admin = Admin::where('id', $user->id)->first();
        return view('roles.admin.profile.edit', compact('user', 'segments','admin'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        // dd($request);
        $user = $request->user();
        $admin = Admin::where('id', $user->id)->first();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:30'],
        ]);

        // If a new phone number is passed then validate it
        if (
            $request->has('phone') &&
            is_string($request->input('phone')) && strlen($request->input('phone')) > 0 &&
            $request->input('phone') !== $user->phone
        ) {
            $validated['phone'] = $request->validate([
                'phone' => [
                    'string',
                    'min:9',
                    'max:15',
                    'regex:/\+(\d){9,15}/',
                    // Make sure the new phone number is not assigned to
                    // another user!
                    Rule::unique('users', 'phone')
                ]
            ])['phone'];
        }

        // If date of birth is passed then validate it
        if ($request->has('dob') && is_string($request->dob) && strlen($request->dob) > 0) {
            $validated['dob'] = $request->validate([
                'dob' => ['required', 'date_format:Y-m-d']
            ])['dob'];
        }

        // If address is passed then validate it
        if ($request->has('address') && is_string($request->address) && strlen($request->address) > 0) {
            $validated['address'] = $request->validate([
                'address' => ['required', 'string', 'min:10', 'max:255']
            ])['address'];
        }

        // If a new password is passed then validate it and hash it
        if (
            $request->has('password') &&
            is_string($request->password) && strlen($request->password) > 0
        ) {
            $validated['password'] = Hash::make(
                $request->validate([
                    'password' => ['string', 'min:8']
                ])['password']
            );
        }


        $user->update($validated);
        if (
            $request->has('business_website') &&
            is_string($request->business_website) && strlen($request->business_website) > 0
        ) {
            $validated['website'] = 
                $request->validate([
                    'business_website' => ['string', 'min:2']
                ])['business_website'];
        }
        if (
            $request->has('pricing_range') &&
            is_string($request->pricing_range) && strlen($request->pricing_range) > 0
        ) {
            $validated['pricing_range'] = 
                $request->validate([
                    'pricing_range' => ['string', 'min:2']
                ])['pricing_range'];
        }
        $admin->update($validated);
        return redirect()
            ->route('admin.profile')
            ->with('updated', 'Your profile was updated!');
    }

    public function avatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'file', 'mimes:jpg,jpeg,png,webp']
        ]);


        $request->user()->update([
            'avatar' => $request->file('avatar')->storePublicly('avatars')
        ]);

        return redirect()
            ->back()
            ->with('updated', 'Your avatar was updated successfully!');
    }
}
