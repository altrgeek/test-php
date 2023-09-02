<?php

namespace App\Http\Controllers\Roles\SuperAdmin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use App\Models\Roles\SuperAdmin;
use App\Models\ClientToDoListSelf;
use App\Models\ClientToDoListPivot;
use App\Http\Controllers\Controller;

class SuperAdminTaskController extends Controller
{

    public function delete($id){
        $listing = ClientToDoListSelf::where('id',$id);
        $pivot = ClientToDoListPivot::where('to_do_list_id',$id);

        if($pivot->exists()){
            $pivot->delete();
        }
        if($listing->exists()){
            $listing->delete();
        }

        return back();
        
    }
    
    public function create(Request $request){
        $user = $request->user();
        $provider = SuperAdmin::where('user_id',$user->id)->get('user_id')->first();
        $client = Admin::select('user_id')->get();
        $clientUserIds = $client->pluck('user_id');
        $clientNames = User::whereIn('id', $clientUserIds)->select('name', 'email', 'id')->get()->mapWithKeys(function ($user) {
            return [$user->id => ['name' => $user->name, 'email' => $user->email]];
        });
        
        // dd($user->id);
        
       
        $listings = ClientToDoListSelf::where('assignee_id',$user->id)->get();

        $listings = $listings->filter(function($value, $key){
            return $value->assigned_to_id != null;
        });
        


        return view('roles.super-admin.therapy_to_do_listing',[
            'listings' => $listings,
            'clients' => $clientNames,
            'user' => $user,
        ]);
    }

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
}
