<?php

namespace App\Actions;

use App\Models\User;

class SharedKey
{
    private int $primeNumber;
    private int $privateNumber;
    private int $sharedPublicKey;

    public function __construct(int $primeNumber, int $privateNumber, int $sharedPublicKey)
    {
        $this->primeNumber = $primeNumber;
        $this->privateNumber = $privateNumber;
        $this->sharedPublicKey = $sharedPublicKey;
    }

    public function getSharedKey(): int
    {
        return bcpowmod($this->sharedPublicKey, $this->privateNumber, $this->primeNumber);
    }

    public function saveKeyFor(User $owner, User $user)
    {
        $sharedKey = new \App\Models\SharedKey();
        $sharedKey->owner()->associate($owner);
        $sharedKey->user()->associate($user);
        $sharedKey->shared_key = $this->getSharedKey();
        $sharedKey->save();
    }

    public function modulus(int $nominator, int $denominator): int
    {
        $result = $nominator % $denominator;
        if ($result < 0) {
            $result += $denominator;
        }
        return $result;
    }
}
