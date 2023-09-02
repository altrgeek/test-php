<?php

namespace App\Http\Controllers\Roles\SuperAdmin;


use Exception;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Roles\Admin;
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
use App\Models\Roles\Client;
use App\Models\Roles\Provider;
use App\Models\Subscriptions;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Load all admins with user-specific details
        $admins = Admin::all()->map(function (Admin $admin) {
            $user = $admin->user;

            // Also include the admin record ID in case of deletes and updates
            $user->admin_id = $admin->id;
            $user->segment = $admin->segment;

            return $user;
        });
        $subscriptions = Subscriptions::all();
        // Associative array of available segments (value => description)
        $segments = config('cogni.admins.segments');

        return view('roles.super-admin.admins', compact('admins', 'segments', 'subscriptions'));
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
        $data = $request->validate([
            'business_name' => ['required', 'string', 'min:5', 'max:255'],
            'contact_person_name' => ['required', 'string', 'min:2', 'max:255'],
            // We are creating a new user-record so email must be unique
            'email' => ['required', 'string', 'min:6', 'max:255', 'email', Rule::unique('users', 'email')],
            // Segments could be only one of predefined values
            'segment' => ['required', 'string', Rule::in(array_keys(config('cogni.admins.segments')))],
            'password' => ['required', 'string', 'min:8', 'max:50'],
        ]);

        // Wrapping in transaction because we want things to run in sequence
        DB::transaction(function () use ($data, $request) {
            $user = User::create([
                'name' => $data['business_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Create new admin record for the user
            $user->admin()->create([
                'segment' => $data['segment'],
                'contact_person' => $data['contact_person_name'],
            ]);

            // Assign appropriate role
            $user->assignRole('admin');

            $super_admin = $request->user();

            try {
                Mail::to($user->email)->send(
                    new UserCreated(
                        $super_admin,
                        $user,
                        $data['password'],
                        'admin',
                        $data['segment']
                    )
                );
            } catch (Exception $error) {
                Log::critical('Could not send new admin account email!', [
                    'address' => $user->email,
                    'error' => $error->getMessage()
                ]);
            }
        }, 3);

        return redirect()
            ->route('super_admin.dashboard.admins')
            ->with('created', 'A new admin was added');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Roles\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        // Validate the data that is needed must
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:50'],
            // Segments could be only one of predefined values
            'segment' => ['string', Rule::in(array_keys(config('cogni.admins.segments')))],
            'password' => ['string', 'min:8', 'max:50']
        ]);

        // The data that needs to be updated
        $updateData = ['name' => $request->name];

        // If password was provided then encrypt and store the password
        if ($request->has('password'))
            $updateData['password'] = Hash::make($request->password);

        // If a new email is provided then validate and update the email
        if (
            $request->has('email') &&
            $request->email !== $admin->user->email
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

        // Need to wrap in a transaction so every record update should be
        // guaranteed
        DB::transaction(function () use ($admin, $request, $updateData) {
            // If segment was provided the update it
            if ($request->has('segment'))
                $admin->update([
                    'segment' => $request->input('segment')
                ]);

            // Update the user
            $admin->user->update($updateData);

            $super_admin = $request->user();

            $user = $admin->user->fresh();

            try {
                Mail::to($user->email)->send(
                    new UserUpdated(
                        $super_admin,
                        $user,
                        $request->password ?? '',
                        'admin',
                        $admin->segment,
                    )
                );
            } catch (Exception $error) {
                Log::critical('Could not send admin account update email!', [
                    'address' => $user->email,
                    'error' => $error->getMessage()
                ]);
            }
        });

        return redirect()
            ->route('super_admin.dashboard.admins')
            ->with('updated', 'The admin details was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Roles\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {

        $providers = $admin->providers()->with(['clients'])->get();

        $providers->each(function (Provider $provider) {
            $provider->clients->each(function (Client $client) {
                $client->user->delete();
            });

            $provider->user()->delete();
        });

        $admin->user->delete();

        return redirect()
            ->route('super_admin.dashboard.admins')
            ->with('deleted', 'The admin and all it\'s providers and clients were deleted');
    }
}
