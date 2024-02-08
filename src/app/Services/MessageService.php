<?php
namespace App\Services;

use App\Events\StoreMessageEvent;
use App\Models\Message;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class MessageService
{
    public function listByUserIds(int $chatUserId, int $authUserId): Paginator
    {
        return Message::query()
            ->where(function ($query) use ($chatUserId, $authUserId) {
                $query->where('sender_id', $chatUserId)
                    ->where('receiver_id', $authUserId);
            })->orWhere(function ($query) use ($chatUserId, $authUserId) {
                $query->where('sender_id', $authUserId)
                    ->where('receiver_id', $chatUserId);
            })
            ->with('sender', 'receiver')
            ->orderByDesc('created_at')
            ->paginate();
    }

    public function store(int $senderId, int $receiverId, string $message): Message|Model
    {
        $message = Message::query()
            ->create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message' => $message,
            ]);

        $message->load('sender', 'receiver');

        event(new StoreMessageEvent($message));

        return $message;
    }
}
