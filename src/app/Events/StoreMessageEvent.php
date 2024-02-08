<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(protected readonly Message $message)
    {
    }

    public function broadcastOn(): array
    {
        $senderId = $this->message->sender_id;
        $receiverId = $this->message->receiver_id;

        return [
            new PrivateChannel("user.$receiverId"),
            new Channel("chat.$senderId")
        ];
    }

    public function broadcastAs(): string
    {
        return 'storeMessage';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message
                ->toArray(),
        ];
    }
}
