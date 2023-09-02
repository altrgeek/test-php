<?php

namespace App\Http\Controllers\Roles\Provider;

use Exception;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Roles\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use App\Mail\User\Created as UserCreated;
use App\Mail\User\Updated as UserUpdated;


class ClientsController extends Controller
{
    /**
     * Display a listing all clients of the provider
     *
     * @param \Illuminate\Http\Request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $provider = $request->user()->provider;

        $clients = $provider->clients->map(function (Client $client) {
            $user = $client->user;
            $packages = $client->bought_packages();

            $packages->value('title');
            $packages->value('sessions');

            // Also include the admin record ID in case of deletes and updates
            $user->client_id = $client->id;

            return $user;
        });

        return view('roles.provider.clients', compact('clients'));
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
            // We are creating a new user-record so email must be unique
            'email' => ['required', 'string', 'min:6', 'max:255', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:50'],
        ]);

        // Wrapping in transaction because we want things to run in sequence
        DB::transaction(function () use ($request) {
            // Get current provider record
            $provider = $request->user()->provider;

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create new provider record for the user
            $user->client()->create([
                'provider_id' => $provider->id
            ]);

            // Assign appropriate role
            $user->assignRole('client');

            try {
                Mail::to($user->email)->send(
                    new UserCreated(
                        $provider->user,
                        $user,
                        $request->password,
                        'client'
                    )
                );
            } catch (Exception $error) {
                Log::critical('Could not send new client account email!', [
                    'address' => $user->email,
                    'error' => $error->getMessage()
                ]);
            }
        }, 3);

        return redirect()
            ->route('provider.dashboard.clients')
            ->with('created', 'New client was added');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'password' => ['string', 'min:8', 'max:50']
        ]);

        $provider = $request->user()->provider;

        // If the client does not belongs to the provider it will throw a
        // NotFoundException, 404 error
        $client = $provider->clients()->findOrFail($id);

        // The data that needs to be updated
        $updateData = ['name' => $request->name];

        // If password was provided then encrypt and store the password
        if ($request->has('password'))
            $updateData['password'] = Hash::make($request->password);

        // If a new email is provided then validate and update the email
        if (
            $request->has('email') &&
            $request->email !== $client->user->email
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
        $client->user->update($updateData);

        $user = $client->user->fresh();

        try {
            Mail::to($user->email)->send(
                new UserUpdated(
                    $provider->user,
                    $user,
                    $request->password ?? '',
                    'client'
                )
            );
        } catch (Exception $error) {
            Log::critical('Could not send client account update email!', [
                'address' => $user->email,
                'error' => $error->getMessage()
            ]);
        }

        return redirect()
            ->route('provider.dashboard.clients')
            ->with('updated', 'The client was updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        // If the client does not belongs to the provider it will throw a
        // NotFoundException, 404 error
        $client = $request
            ->user()
            ->provider
            ->clients()
            ->findOrFail($id);

        $client->delete(); // Delete the client

        return redirect()
            ->route('provider.dashboard.clients')
            ->with('deleted', 'The client was removed successfully!');
    }
}
