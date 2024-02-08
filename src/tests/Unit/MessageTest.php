<?php

namespace Tests\Unit;

use App\Events\StoreMessageEvent;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class MessageTest extends TestCase
{
    private MessageService $messageService;

    protected function setUp(): void
    {
        $this->messageService = new MessageService();

        parent::setUp();
    }

    public function testStoreMessageWithEvents(): void
    {
        $sender = User::factory()->createOne();
        $receiver = User::factory()->createOne();

        Event::fakeFor(function () use ($sender, $receiver) {
            $storeMessage = $this->storeMessage($sender, $receiver);

            Event::assertDispatched(StoreMessageEvent::class, function ($event) use($sender, $receiver, $storeMessage) {
                return $event->broadcastOn()[0]->name === "private-user.{$receiver->id}"
                    && $event->broadcastOn()[1]->name === "chat.{$sender->id}"
                    && $event->broadcastAs() === 'storeMessage'
                    && $event->broadcastWith()['message'] === $storeMessage->toArray();
            });
        });
    }

    public function testMessages()
    {
        $user1 = User::factory()->createOne();
        $user2 = User::factory()->createOne();
        $user3 = User::factory()->createOne();

        $this->storeMessage($user1, $user2);
        $this->storeMessage($user2, $user1);

        $this->assertCount(2, $this->messageService->listByUserIds($user2->id, $user1->id)->items());
        $this->assertCount(2, $this->messageService->listByUserIds($user1->id, $user2->id)->items());

        $this->storeMessage($user1, $user3);
        $this->storeMessage($user3, $user1);

        $this->assertCount(2, $this->messageService->listByUserIds($user3->id, $user1->id)->items());
        $this->assertCount(2, $this->messageService->listByUserIds($user1->id, $user3->id)->items());

        $this->storeMessage($user2, $user3);
        $this->storeMessage($user3, $user2);
        $this->storeMessage($user3, $user2);

        $this->assertCount(3, $this->messageService->listByUserIds($user3->id, $user2->id)->items());
        $this->assertCount(3, $this->messageService->listByUserIds($user2->id, $user3->id)->items());
    }

    private function storeMessage(User $sender, User $receiver): Message
    {
        $requestMessage = Message::factory([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
        ])->makeOne();

        $storeMessage = $this->messageService
            ->store($requestMessage['sender_id'], $requestMessage['receiver_id'], $requestMessage['message']);
        $this->assertEquals($requestMessage->toArray(), $storeMessage->only('sender_id', 'receiver_id', 'message'));

        return $storeMessage;
    }
}
