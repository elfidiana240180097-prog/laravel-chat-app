<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use App\Events\UserTyping;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id','!=',auth()->id())->get();

        return view('chat.index',compact('users'));
    }

    public function show(User $user)
    {
        $users = User::where('id','!=',auth()->id())->get();

        $messages = Message::where(function($q) use($user){

            $q->where('sender_id',auth()->id())
              ->where('receiver_id',$user->id);

        })->orWhere(function($q) use($user){

            $q->where('sender_id',$user->id)
              ->where('receiver_id',auth()->id());

        })->orderBy('created_at')->get();

        return view('chat.room',compact(
            'users',
            'user',
            'messages'
        ));
    }

    public function store(Request $request,User $user)
    {
        $request->validate([
            'message'=>'required'
        ]);

        $message = Message::create([

            'sender_id'=>auth()->id(),

            'receiver_id'=>$user->id,

            'message'=>$request->message

        ]);

        broadcast(new MessageSent($message))->toOthers();

        return redirect()->route('chat.show',$user);
    }

    // ===== BARU =====

    public function typing(User $user)
    {
        broadcast(new UserTyping(
            auth()->id(),
            $user->id
        ))->toOthers();

        return response()->json([
            'success' => true
        ]);
    }
}