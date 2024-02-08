<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
         $exampleUser = User::query()
             ->where('email', 'example@gmail.com')
             ->first();

         $users = User::query()
             ->whereNot('email', 'example@gmail.com')
             ->get();

         foreach($users as $user) {
             for($i=0; $i<rand(0, 5); $i++) {
                 Message::factory([
                     'sender_id' => $user->id,
                     'receiver_id' => $exampleUser->id
                 ])
                     ->createOne();

                 Message::factory([
                     'sender_id' => $exampleUser->id,
                     'receiver_id' => $user->id
                 ])
                     ->createOne();
             }
         }
    }
}
