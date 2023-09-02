<?php

namespace App\Http\Controllers\Roles\Admin;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Roles\Provider;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureProviderLimits;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\User\Created as UserCreated;
use App\Mail\User\Updated as UserUpdated;
use App\Models\Roles\Client;

class ProvidersController extends Controller
{
    public function __construct()
    {
        $this->middleware(EnsureProviderLimits::class)->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // Load all providers under current admin with user-specific details
        $providers = $request
            ->user()
            ->admin
            ->providers
            ->map(function (Provider $provider) {

                $user = $provider->user;
                $user->provider_id = $provider->id; // For update/delete

                return $user;
            });

        return view('roles.admin.providers', compact('providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'email' => ['required', 'string', 'min:6', 'max:255', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:50'],
        ]);

        $admin = $request->user()->admin;

        // Wrapping in transaction because we want things to run in sequence
        DB::transaction(function () use ($request, $admin) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create new provider record for the user
            $user
                ->provider()
                ->create([
                    'admin_id' => $admin->id
                ]);

            // Assign appropriate role
            $user->assignRole('provider');

            try {
                Mail::to($user->email)->send(
                    new UserCreated(
                        $admin->user,
                        $user,
                        $request->password,
                        'provider'
                    )
                );
            } catch (Exception $error) {
                Log::critical('Could not send new provider account email!', [
                    'address' => $user->email,
                    'error' => $error->getMessage()
                ]);
            }
        }, 3);

        return redirect()
            ->route('admin.dashboard.providers')
            ->with('created', 'The provider was created successfully!');
    }

    /**
     * Admin can edit only his created providers
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'password' => ['string', 'min:8', 'max:50']
        ]);

        $admin = $request->user()->admin;

        // If the provider does not belongs to the admin it will throw a
        // NotFoundException, 404 error
        $provider = $admin->providers()->findOrFail($id);

        // The data that needs to be updated
        $updateData = ['name' => $request->name];

        // If password was provided then encrypt and store the password
        if ($request->has('password'))
            $updateData['password'] = Hash::make($request->password);

        // If a new email is provided then validate and update the email
        if (
            $request->has('email') &&
            $request->email !== $provider->user->email
        ) {
            $request->validate([
                'email' => [
                    'string',
                    'min:6',
                    'max:255',
                    'email',
                    // The new email must not be linked with any existing
                    // account!
                    Rule::unique('users', 'email')
                ],
            ]);

            // Update the user's email address
            $updateData['email'] = $request->email;
        }

        // Update appropriate data
        $provider->user->update($updateData);
        $user = $provider->user->fresh();

        try {
            Mail::to($user->email)->send(
                new UserUpdated(
                    $admin->user,
                    $user,
                    $request->password ?? '',
                    'provider'
                )
            );
        } catch (Exception $error) {
            Log::critical('Could not send provider account update email!', [
                'address' => $user->email,
                'error' => $error->getMessage()
            ]);
        }

        return redirect()
            ->route('admin.dashboard.providers')
            ->with('updated', 'The provider was updated successfully!');
    }

    /**
     * The admin can delete only his providers
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // If the provider does not belongs to the admin it will throw a
        // NotFoundException, 404 error
        $provider = $request
            ->user()
            ->admin
            ->providers()
            ->with(['clients'])
            ->findOrFail($id);

        // Delete all clients of providers
        $provider->clients->each(function (Client $client) {
            // This should also delete client records as well due to database
            // level constraints enforcement
            $client->user->delete();
        });

        // dd($provider->);
        // exit();

        $provider->delete(); // Delete the provider

        return redirect()
            ->route('admin.dashboard.providers')
            ->with('deleted', 'The provider and all of their clients were deleted');
    }
}
