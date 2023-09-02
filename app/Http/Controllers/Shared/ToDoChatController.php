<?php

namespace App\Http\Controllers\Shared;


use App\Models\Chat\Chat;
use App\Models\Chat\Message;
use Illuminate\Http\Request;
use App\Models\Chat\Participant;
use App\Models\ClientToDoListSelf;
use App\Http\Controllers\Controller;

class ToDoChatController extends Controller
{
    public function create(Request $req,$taskID)
    {
        $task = ClientToDoListSelf::find($taskID);
        $visibility = [
            'audience' => [$task->assignee_id,$req->user()->id],
            'views'    => [$req->user()->id], // Only the message owner has seen it till now
        ];
        
        //check if both the assignee_id and user are participant in the same chat
        $participant1 = Participant::where('user_id',$task->assignee_id)->get();
        $participant2 = Participant::where('user_id',$req->user()->id)->get();
        $url = $req->user()->isAdmin() ? 'https://cogni4health.com/dashboard/superadmin-to-do-listing' : 'https://cogni4health.com/admin/provider-to-do-listing';
        foreach($participant1 as $p1){

            foreach($participant2 as $p2){
                
                if($p1->chat_id == $p2->chat_id){
                    Message::create([
                        'event_context'=>null,
                        'target_id'=>null,
                        'content'=>'Task Update '.$task->title.' '.'url:'.$url.'       Message:'.$req->update,
                        'is_deleted'=>0,
                        'parent_id'=>null,
                        'preview'=>null,
                        'type'=>'text',
                        'status'=>"sent",
                        'visibility' => $visibility,            
                        'chat_id'=>$p1->chat_id,
                        'user_id'=>$req->user()->id,
                        
                    ]);
                    return view('roles.shared.chat');
                }
            }
        }
    

        $chat = Chat::create([
            'type' => 'individual',
            'name' => 'Task Update',
            'icon' => null,
            'description' => "task update",
        ]);
    
        Participant::create([
            'user_id' => $req->user()->id,
            'role' => 'owner',
            'visibility' => null,
            'chat_id' => $chat->id,
        ]);

        
        Participant::create([
            'user_id' => $task->assignee_id,
            'role' => 'member',
            'visibility' => null,
            'chat_id' => $chat->id,
        ]);

        Message::create([
            'event_context'=>null,
            'target_id'=>null,
            'content'=>'Task Update '.$task->title.' '.'url:',
            'is_deleted'=>0,
            'parent_id'=>null,
            'preview'=>null,
            'type'=>'text',
            'status'=>"sent",
            'visibility' => $visibility,            
            'chat_id'=>$chat->id,
            'user_id'=>$req->user()->id,
            
        ]);
       
        return view('roles.shared.chat');
    }

}
