<?php

namespace App\Actions;

class PublicKey
{

    private int $primeNumber;
    private int $generatorNumber;
    private int $privateNumber;

    public function __construct(int $primeNumber, int $generatorNumber, int $privateNumber)
    {
        $this->primeNumber = $primeNumber;
        $this->generatorNumber = $generatorNumber;
        $this->privateNumber = $privateNumber;
    }

    public function calculate(): int
    {
        return $this->generatorNumber * $this->privateNumber % $this->primeNumber;
    }
}
