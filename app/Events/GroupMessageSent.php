<?php

namespace App\Events;

use App\Models\GroupMessage;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Broadcasting\PrivateChannel;

class GroupMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(GroupMessage $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn(): array
    {
        return [

            new PrivateChannel(
                'group.'.$this->message->group_id
            )

        ];
    }

    public function broadcastAs()
    {
        return 'group.message.sent';
    }

    public function broadcastWith()
    {
        return [

            'message'=>$this->message

        ];
    }
}