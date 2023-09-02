<?php

namespace App\Http\Controllers\Shared;

use Illuminate\View\View;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Therapies\VRTherapy;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Therapies\MarketplaceOption;
use Illuminate\Support\Facades\Gate;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;


class VRTherapiesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:super_admin|admin|provider|client']);
        $this->middleware(['role:super_admin|admin|provider'])->except('index');
    }

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('roles.shared.vr-therapies', [
            'therapies'    => VRTherapy::with(['marketplaces'])->get(),
            'marketplaces' => MarketplaceOption::all(),
            'can_create'   => Gate::allows('create', VRTherapy::class),
            'user'         => $user,
            'admins'       => $user->isSuperAdmin() ? Admin::with(['providers'])->get() : null,
            'providers'    => $user->isAdmin() ? $user->admin->providers : null,
        ]);
    }

    public function groups(Request $req){
        $user = $req->user();
        return view('roles.shared.vr-therapies-groups', [
            'therapies'    => VRTherapy::with(['marketplaces'])->get(),
            'marketplaces' => MarketplaceOption::all(),
            'can_create'   => Gate::allows('create', VRTherapy::class),
            'user'         => $user,
            'admins'       => $user->isSuperAdmin() ? Admin::with(['providers'])->get() : null,
            'providers'    => $user->isAdmin() ? $user->admin->providers : null,
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        Gate::authorize('create', VRTherapy::class);
        $user = $request->user();

        $validated = $request->validate([
            'title'           => ['required', 'string'],
            'description'    => ['required', 'string'],
            'material'      =>['required', 'string'],
            'method'        =>['required', 'string'],
            'image'         =>['required', 'file', 'mimes:jpg,jpeg,png,webp'],
            'duration'      => ['required', 'string', 'date_format:H:i'],
            'marketplaces'   => ['required', 'array'],
            'marketplaces.*' => ['numeric', Rule::exists('marketplace_options', 'id')]
        ]);

        $vr_therapy_image_size = $validated['image']->getSize();
        $vr_therapy_image_name = $validated['image']->getClientOriginalName();
        


        // return dd(asset('vr_therapy_images/sfsdfsdf.jpg') );

        // VRTherapy will be created for provider themselves
        if ($user->isProvider())
            $validated['provider_id'] = $user->provider->id;

        // Only super admin and admin needs to specify provider
        else
            $validated['provider_id'] = $request->validate([
                'provider_id' => ['required', 'numeric', Rule::exists('providers', 'id')]
            ])['provider_id'];

        
        $ImgUrl = public_path().'/vr_therapy_images/';
        
        if(!$validated['image']->move($ImgUrl, $vr_therapy_image_name)){
            throw new \Exception('File upload failed');
        }
        
        $imageStoredPath = asset('vr_therapy_images').'/'.$vr_therapy_image_name;
        
           
        $therapy = VRTherapy::create([
            'title'        => $validated['title'],
            'description' => $validated['description'],
            'material'    => $validated['material'],
            'method'      => $validated['method'],
            'image'       => $imageStoredPath, 
            'duration'      => $validated['duration'],
            'provider_id' => $validated['provider_id'],
        ]);

        // Attach selected marketplace items with
        $therapy->marketplaces()->attach($validated['marketplaces']);

        return redirect()
            ->route('dashboard.vr-therapies')
            ->with('created', 'The VRTherapy was created successfully!');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $therapy = VRTherapy::findOrFail($id);
        $action = Gate::inspect('update', $therapy);
        $user = $request->user();

        // Make sure current user can update the record
        if ($action->denied())
            return redirect()
                ->back()
                ->with('message', $action->message());

        // Validate incoming request data
        $validated = $request->validate([
            'title'           => ['required', 'string'],
            'description'    => ['required', 'string'],
            'material'      =>['required', 'string'],
            'method'        =>['required', 'string'],
            'image'         =>['required', 'file', 'mimes:jpg,jpeg,png,webp'],
            'duration'      => ['required', 'string', 'date_format:H:i'],
            'marketplaces'   => ['required', 'array'],
            'marketplaces.*' => ['numeric', Rule::exists('marketplace_options', 'id')]
        ]);

        // If user is super-admin or admin then they must specify a provider ID
        if ($user->isAdmin() || $user->isSuperAdmin())
            $validated['provider_id'] = (int) $request->validate([
                'provider_id' => ['required', 'numeric', Rule::exists('providers', 'id')],
            ])['provider_id'];

            $vr_therapy_image_size = $validated['image']->getSize();
            $vr_therapy_image_name = $validated['image']->getClientOriginalName();
            $ImgUrl = public_path().'/vr_therapy_images/';
        
            if(!$validated['image']->move($ImgUrl, $vr_therapy_image_name)){
            throw new \Exception('File upload failed');
            }
        
        $imageStoredPath = asset('vr_therapy_images').'/'.$vr_therapy_image_name;
        $validated['image'] = $imageStoredPath;
                
        // Update the record and also sync the market place options in pivot table
        $therapy->update($validated);
        $therapy->marketplaces()->sync($validated['marketplaces']);

        return redirect()
            ->route('dashboard.vr-therapies')
            ->with('updated', 'The VRTherapy was updated successfully!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $therapy = VRTherapy::findOrFail($id);
        $action = Gate::inspect('delete', $therapy);

        // Make sure current user can delete the record
        if ($action->denied())
            return redirect()
                ->back()
                ->with('message', $action->message());

        // This will delete the record and all of its marketplace associations
        // in the pivot table as well
        $therapy->delete();

        return redirect()
            ->route('dashboard.vr-therapies')
            ->with('deleted', 'The VRTherapy was deleted successfully!');
    }


    public function test(){
        return dd(
            VRTherapy::where('id', 8)->first(),
        );
    }
}
