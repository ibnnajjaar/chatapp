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
}
