<?php

namespace App\Http\Controllers\Roles\Client;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use App\Models\Roles\Admin;
use App\Models\Roles\Client;
use Illuminate\Http\Request;
use App\Models\Roles\Provider;
use Illuminate\Validation\Rule;
use App\Models\CompletedListing;
use App\Models\Roles\SuperAdmin;
use App\Models\ClientToDoListSelf;
use App\Models\ClientToDoListPivot;
use App\Http\Controllers\Controller;
use Symfony\Contracts\Service\Attribute\Required;



class ClientToDoListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $appointments = ClientToDoListSelf::where('assigned_to_id', $request->user()->id)->get();
        
        $client_to_do_list_pivot = ClientToDoListPivot::where('client_id', $request->user()->id)->get();
        $client_to_do_list_pivot = $client_to_do_list_pivot->pluck('to_do_list_id');

        $d = ClientToDoListSelf::whereIn('id',$client_to_do_list_pivot)->get();

        $appointments = $appointments->merge($d);

        

        return view('roles.client.TherapyTodoListing.therapy_to_do_listing',compact('appointments'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
    }
   /**
    * Show Todo Preview
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function preview(Request $request, $id): View
    {
        $appointment =  ClientToDoListSelf::with('vrTherapy')->findOrFail($id);
        //also find the provider name and id using the provider and user table
        $provider = Provider::where('user_id', $appointment->assignee_id)->first();
        $provider_name = User::where('id', $provider->user_id)->select('name','email')->first();
        $appointment->provider_name = $provider_name->name;
        $appointment->provider_email = $provider_name->email;


        return view('roles.client.TherapyTodoListing.to_do_preview', compact('appointment'));
    }
    //make accept and reject methods
    public function accept(Request $request, $id) {
        $appointment =  ClientToDoListSelf::findOrFail($id);
        $appointment->status = 'accepted';
        $appointment->save();

        return back();
    }
    
    public function reject(Request $request, $id){
        $appointment =  ClientToDoListSelf::findOrFail($id);
        $appointment->status = 'rejected';
        $appointment->save();
        return back();
    }

    public function complete(Request $request, $id){
        $appointment =  ClientToDoListSelf::findOrFail($id);
        
        $appointment->status = 'completed';
        $appointment->save();
        
        
        
        

        return back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function storeGroup(Request $request){
        
        $validated = $request->validate([
            'title'           => ['required', 'string'],
            'description'    => ['required', 'string'],
            'start'      => ['required','date_format:Y-m-d\TH:i'],
            'duration'      => ['required', 'numeric'],
            'unit'          => ['required','string'],
            'client_id' =>['required'],
            'provider_id' =>['required','numeric']

        ]);
        $unit = $validated['unit'];
        $duration_in_minutes = $validated['duration'];
        if($validated['unit'] == 'hours'){
            $duration_in_minutes = $validated['duration'] * 60;
        }
        if($validated['unit'] == 'days'){
            $duration_in_minutes = $validated['duration'] * 60 * 24;
        }
        if($validated['unit'] == 'weeks'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 7;
        }
        if($validated['unit'] == 'months'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 30;
        }
        if($validated['unit'] == 'years'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 365;
        }

        $user = User::where('id',$request->user()->id)->first();
        $isProvider = $user->isProvider();
        $isAdmin = $user->isAdmin();
        $isSuperAdmin = $user->isSuperAdmin();

        $role = $isProvider ? 'provider' : ($isAdmin ? 'admin' : ($isSuperAdmin ? 'super_admin' : 'client'));
        
        

        $listing = ClientToDoListSelf::create([
            'created_at' => time(),
            'updated_at' => time(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start' => $validated['start'],
            'duration' => $validated['duration'],
            'unit' =>   $unit,
            'status' => 'pending',
            'assigned_to_id' => null,
            'assignee_role' => $role,
            'assignee_id' => $validated['provider_id'],
            'vr_therapy_id' => $request->has('vr_therapy_id') ? $request->vr_therapy_id : null,
            'end' => Carbon::parse($validated['start'])->addMinutes($duration_in_minutes)
        ]);

        //creating pivot

        // dd($validated['client_id']);
        //foreach client_id store it in ClientToDoListPivot
        $client_id = $request->client_id;
        // dd($client_id);
        foreach($client_id as $client){
            ClientToDoListPivot::create([
                'client_id' => $client,
                'to_do_list_id' => $listing->id,
            ]);
        }
        
    

        return back();
        
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => ['required', 'string'],
            'description'    => ['required', 'string'],
            'start'      => ['required','date_format:Y-m-d\TH:i'],
            'duration'      => ['required', 'numeric'],
            'unit'          => ['required','string'],
            'client_id' =>['required','numeric'],
            'provider_id' =>['required','numeric']

        ]);
        $unit = $validated['unit'];
        $duration_in_minutes = $validated['duration'];
        if($validated['unit'] == 'hours'){
            $duration_in_minutes = $validated['duration'] * 60;
        }
        if($validated['unit'] == 'days'){
            $duration_in_minutes = $validated['duration'] * 60 * 24;
        }
        if($validated['unit'] == 'weeks'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 7;
        }
        if($validated['unit'] == 'months'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 30;
        }
        if($validated['unit'] == 'years'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 365;
        }
        $user = User::where('id',$request->user()->id)->first();
        $isProvider = $user->isProvider();
        $isAdmin = $user->isAdmin();
        $isSuperAdmin = $user->isSuperAdmin();

        $role = $isProvider ? 'provider' : ($isAdmin ? 'admin' : ($isSuperAdmin ? 'super_admin' : 'client'));
        

        
        ClientToDoListSelf::create([
            'created_at' => time(),
            'updated_at' => time(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start' => $validated['start'],
            'duration' => $validated['duration'],
            'unit' =>   $unit,
            'assigned_to_id' => $validated['client_id'],
            'assignee_id' => $validated['provider_id'],
            'assignee_role' => $role,
            'vr_therapy_id' => $request->has('vr_therapy_id') ? $request->vr_therapy_id : null,
            'end' => Carbon::parse($validated['start'])->addMinutes($duration_in_minutes)
        ]);

        return back();
        
        
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req,$vr_id)
    {
        $user = $req->user();
        $provider = Provider::where('user_id',$user->id)->get('id')->first();
        $client = Client::where('provider_id',$provider->id)->get('user_id');
        $clientUserIds = $client->pluck('user_id');
        $clientNames = User::whereIn('id', $clientUserIds)->select('name', 'email', 'id')->get()->mapWithKeys(function ($user) {
            return [$user->id => ['name' => $user->name, 'email' => $user->email]];
        });
       
        $listings = ClientToDoListSelf::where('assignee_id',$user->id)->get();

        $listings = $listings->filter(function($value, $key){
            return $value->assigned_to_id != null;
        });
        


        return view('roles.provider.therapy_to_do_listing',[
            'listings' => $listings,
            'clients' => $clientNames,
            'user' => $user,
            'vr_therapy_id' => $vr_id
        ]);
    }

    public function showGroups(Request $req,$vr_id){
        $user = $req->user();
        $provider = Provider::where('user_id',$user->id)->get('id')->first();
        $client = Client::where('provider_id',$provider->id)->get('user_id');

        $clientUserIds = $client->pluck('user_id');
        $clientNames = User::whereIn('id', $clientUserIds)->select('name', 'email', 'id')->get()->mapWithKeys(function ($user) {
            return [$user->id => ['name' => $user->name, 'email' => $user->email]];
        });
        $listings = ClientToDoListSelf::where('assigned_to_id',null)->where('assignee_id',$user->id)->get();
        $client_to_do_list_pivot = ClientToDoListPivot::whereIn('to_do_list_id',$listings->pluck('id'))->get();
          
        return view('roles.provider.therapy_to_do_listing_group',[
            'groups' => $client_to_do_list_pivot,
            'listings' => $listings,
            'clients' => $clientNames,
            'user' => $user,
            'vr_therapy_id' => $vr_id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $req)
    {
        $validated = $req->validate([
            'title'           => ['required', 'string'],
            'description'    => ['required', 'string'],
            'start'      => ['required','date_format:Y-m-d\TH:i'],
            'duration'      => ['required', 'numeric'],
            'unit'          => ['required','string'],
            'client_id' =>['required','numeric'],
            'provider_id' =>['required','numeric']

        ]);
        $unit = $validated['unit'];
        $duration_in_minutes = $validated['duration'];
        if($validated['unit'] == 'hours'){
            $duration_in_minutes = $validated['duration'] * 60;
        }
        if($validated['unit'] == 'days'){
            $duration_in_minutes = $validated['duration'] * 60 * 24;
        }
        if($validated['unit'] == 'weeks'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 7;
        }
        if($validated['unit'] == 'months'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 30;
        }
        if($validated['unit'] == 'years'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 365;
        }
        $user = User::where('id',$req->user()->id)->first();
        $isProvider = $user->isProvider();
        $isAdmin = $user->isAdmin();
        $isSuperAdmin = $user->isSuperAdmin();

        $role = $isProvider ? 'provider' : ($isAdmin ? 'admin' : ($isSuperAdmin ? 'super_admin' : 'client'));
        

        $listing = ClientToDoListSelf::find($req->list_id);
        $listing->update([
            'created_at' => time(),
            'updated_at' => time(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start' => $validated['start'],
            'duration' => $validated['duration'],
            'unit' =>   $unit,
            'assigned_to_id' => $validated['client_id'],
            'assignee_id' => $validated['provider_id'],
            'assignee_role' => $role,
            'vr_therapy_id' => $req->has('vr_therapy_id') ? $req->vr_therapy_id : null,
            'end' => Carbon::parse($validated['start'])->addMinutes($duration_in_minutes)
        ]);

        return back();
        
    }

    public function editgroup(Request $request){
        $validated = $request->validate([
            'title'           => ['required', 'string'],
            'description'    => ['required', 'string'],
            'start'      => ['required','date_format:Y-m-d\TH:i'],
            'duration'      => ['required', 'numeric'],
            'unit'          => ['required','string'],
            'client_id' =>['required'],
            'provider_id' =>['required','numeric']

        ]);
        $unit = $validated['unit'];
        $duration_in_minutes = $validated['duration'];
        if($validated['unit'] == 'hours'){
            $duration_in_minutes = $validated['duration'] * 60;
        }
        if($validated['unit'] == 'days'){
            $duration_in_minutes = $validated['duration'] * 60 * 24;
        }
        if($validated['unit'] == 'weeks'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 7;
        }
        if($validated['unit'] == 'months'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 30;
        }
        if($validated['unit'] == 'years'){
            $duration_in_minutes = $validated['duration'] * 60 * 24 * 365;
        }

        $user = User::where('id',$request->user()->id)->first();
        $isProvider = $user->isProvider();
        $isAdmin = $user->isAdmin();
        $isSuperAdmin = $user->isSuperAdmin();

        $role = $isProvider ? 'provider' : ($isAdmin ? 'admin' : ($isSuperAdmin ? 'super_admin' : 'client'));
        
        
        $listing = ClientToDoListSelf::find($request->list_id);
        $listing->update([
            'created_at' => time(),
            'updated_at' => time(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start' => $validated['start'],
            'duration' => $validated['duration'],
            'unit' =>   $unit,
            'status' => 'pending',
            'assigned_to_id' => null,
            'assignee_role' => $role,
            'assignee_id' => $validated['provider_id'],
            'vr_therapy_id' => $request->has('vr_therapy_id') ? $request->vr_therapy_id : null,
            'end' => Carbon::parse($validated['start'])->addMinutes($duration_in_minutes)
        ]);

        //creating pivot


        $client_ids = (array) $request->client_id;
        $to_do_list_id = $listing->id;

        //delete all record with this listing id
        ClientToDoListPivot::where('to_do_list_id', $to_do_list_id)->delete();

        foreach ($client_ids as $client_id) {
           
            ClientToDoListPivot::create([
                'client_id' => $client_id,
                'to_do_list_id' => $to_do_list_id,
            ]);
}

        return back();
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
