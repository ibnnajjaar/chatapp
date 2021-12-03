<?php

namespace App\Actions;

use App\Models\User;

class PrivateKey
{

    public function get(): int
    {
        // Get the private key from the database
        $primaryKey = config('defaults.prime_number');
        return rand(1, $primaryKey);
    }

    public function savePrivateKey(User $user): User
    {

        if ($user->private_key) {
            return $user;
        }

        $privateKey = $this->get();
        $user->private_key = $privateKey;
        $user->save();

        return $user->refresh();
    }
}
