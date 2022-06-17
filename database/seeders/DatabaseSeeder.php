<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'firstname' => 'utilisateur',
            'lastname' => '1',
            'email' => 'user1@gmail.com',
            'password' => '12345678'
        ]);
        $user2 = User::create([
            'firstname' => 'utilisateur',
            'lastname' => '2',
            'email' => 'user2@gmail.com',
            'password' => '12345678'
        ]);

        Todo::create([
            'name' => 'todo user 1',
            'description' => 'description',
            'user_id' => $user1->id
        ]);

        Todo::create([
            'name' => 'todo user 2',
            'description' => 'description',
            'user_id' => $user2->id
        ]);
    }
}
