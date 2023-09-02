<?php

namespace App\Http\Controllers\Roles\Provider;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ClientToDoListSelf;
use App\Models\ClientToDoListPivot;
use App\Http\Controllers\Controller;

class ProviderTaskController extends Controller
{
    public function index(Request $req){
        $appointments = ClientToDoListSelf::where('assigned_to_id',$req->user()->id)->get();
        return view('roles.provider.todo_calendar',compact('appointments'));
    }

    public function show(Request $req,$id){
        $task = ClientToDoListSelf::find($id);
        $provider = User::find($task->assignee_id);
        return view('roles.provider.todo_preview',compact('task','provider'));
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
}
