<?php

namespace App\Http\Controllers\Roles\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Roles\Admin;
use Illuminate\Http\Request;
use App\Models\Roles\Provider;
use App\Models\ClientToDoListSelf;
use App\Models\ClientToDoListPivot;
use App\Http\Controllers\Controller;

class AdminTaskController extends Controller
{

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

    public function index(Request $req){
        $appointments = ClientToDoListSelf::where('assigned_to_id',$req->user()->id)->get();
        // dd($appointments);
        return view('roles.admin.todo_calendar',compact('appointments'));
    }

    public function show(Request $req,$id){
        $task = ClientToDoListSelf::find($id);
        $provider = User::find($task->assignee_id);
        return view('roles.admin.todo_preview',compact('task','provider'));

    }

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
    
    public function create(Request $request){
        $user = $request->user();
        $admin = Admin::where('user_id',$user->id)->get('id')->first();
        $client = Provider::where('admin_id',$admin->id)->get('user_id');
        $clientUserIds = $client->pluck('user_id');
        $clientNames = User::whereIn('id', $clientUserIds)->select('name', 'email', 'id')->get()->mapWithKeys(function ($user) {
            return [$user->id => ['name' => $user->name, 'email' => $user->email]];
        });
        
        
       
        $listings = ClientToDoListSelf::where('assignee_id',$user->id)->get();

        $listings = $listings->filter(function($value, $key){
            return $value->assigned_to_id != null;
        });

        return view('roles.admin.therapy_to_do_listing',[
            'listings' => $listings,
            'clients' => $clientNames,
            'user' => $user,
        ]);
    }
}
