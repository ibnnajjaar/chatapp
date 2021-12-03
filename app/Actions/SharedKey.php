<?php

namespace App\Actions;

use App\Models\User;

class SharedKey
{
    private int $primeNumber;

    public function __construct(int $primeNumber)
    {
        $this->primeNumber = $primeNumber;
    }

    public function getSharedKey($privateNumber, $sharedPublicKey): int
    {
        return bcpowmod($sharedPublicKey, $privateNumber, $this->primeNumber);
    }
}
