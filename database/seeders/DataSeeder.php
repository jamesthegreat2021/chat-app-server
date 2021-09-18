<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $john = User::create([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $jane = User::create([
            'name' => 'Jane Doe',
            'email' => 'janedoe@gmail.com',
            'password' => bcrypt('123'),
        ]);

        $chat = Chat::create();

        $chatUser1 = ChatUser::create([
            'user_id' => $john->id,
            'chat_id' => $chat->id,
        ]);

        $chatUser2 = ChatUser::create([
            'user_id' => $jane->id,
            'chat_id' => $chat->id,
        ]);

        $messages = [
            [
                'body' => 'Hello Jane',
                'sender_id' => $john->id,
                'recepient_id' => $jane->id,
                'chat_id' => $chat->id,
            ],
            [
                'body' => 'How are you doing?',
                'sender_id' => $jane->id,
                'recepient_id' => $john->id,
                'chat_id' => $chat->id,
            ],
            [
                'body' => 'I\'m doing good, hope you are good too...',
                'sender_id' => $john->id,
                'recepient_id' => $jane->id,
                'chat_id' => $chat->id,
            ]
        ];

        foreach ($messages as $msg) {
            ChatMessage::create($msg);
        }
    }
}
