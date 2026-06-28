<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\GroupMember;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('group.{groupId}', function ($user, $groupId) {

    return GroupMember::where('group_id', $groupId)
        ->where('user_id', $user->id)
        ->exists();

});