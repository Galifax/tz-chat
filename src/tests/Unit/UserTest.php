<?php

namespace Tests\Unit;

use App\Events\StoreMessageEvent;
use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        $this->userService = new UserService();

        parent::setUp();
    }

    public function testUsersList(): void
    {
        $user = User::factory()->createOne();

        User::factory(5)->create();

        $this->assertCount(5, $this->userService->list($user->id));
    }
}
