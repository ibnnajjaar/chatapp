<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{

    protected array $users = [
        [
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => 'alice12345'
        ],
        [
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => 'bob12345'
        ],
        [
            'name' => 'Eve',
            'email' => 'eve@example.com',
            'password' => 'eve12345'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $userData) {
            $user = User::where('email', $userData['email'])->first();
            if ($user) {
                continue;
            }

            $user = new User();
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = Hash::make($userData['password']);
            $user->save();
        }
    }
}
