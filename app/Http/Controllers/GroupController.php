<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMessage;
use App\Events\GroupMessageSent;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function show(Group $group)
    {
        $messages = GroupMessage::with('user')
            ->where('group_id', $group->id)
            ->orderBy('created_at')
            ->get();

        $memberCount = $group->members()->count();

        return view('group.room', compact(
        'group',
        'messages',
        'memberCount'
        ));
    }

    public function store(Request $request, Group $group)
    {
        $request->validate([
            'message' => 'required'
        ]);

        $message = GroupMessage::create([

            'group_id' => $group->id,

            'user_id' => auth()->id(),

            'message' => $request->message

        ]);

        broadcast(new GroupMessageSent($message))->toOthers();

        return back();
    }
}