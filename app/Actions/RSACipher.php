<?php
namespace App\Actions;

class RSACipher
{
    public int $p, $q, $n, $phi, $private_key, $public_key;
    private array $primePool = [11,13,17,19,23,29,31,37,41,43,47,53,59,61,67,71,73,79,83,89,97,101,103,107,109,113];

    /**
     * RSACipher set primes.
     */
    public function setPrimes()
    {
        $this->p = $this->primePool[rand(0, count($this->primePool) - 1)];
        do {
            $this->q = $this->primePool[rand(0, count($this->primePool) - 1)];
        } while ($this->p == $this->q);

        $this->n = $this->p * $this->q;
        $this->phi = ($this->p - 1) * ($this->q - 1);
        $this->setPublicKey();
        $this->setPrivateKey();
    }

    public function getPrimeP(): int
    {
        return $this->p;
    }

    public function getPrimeQ(): int
    {
        return $this->q;
    }

    public function getPublicKey(): int
    {
        return $this->public_key;
    }

    public function getPrivateKey(): int
    {
        return $this->private_key;
    }

    // Choose e as public key exponent
    private function setPublicKey()
    {
        for ($e = 2; $e < $this->phi; $e++) {
            // e is for public key exponent
            if ($this->gcd($e, $this->phi) == 1) {
                break;
            }
        }
        $this->public_key = $e;
    }

    // Choose a private key
    private function setPrivateKey()
    {
        $private_key = 1;

        for ($i = 0; $i <= 9; $i++) {
            $x = 1 + ($i * $this->phi);

            // d is for private key exponent
            if ($x % $this->public_key == 0) {
                $private_key = (int) $x / $this->public_key;
                break;
            }
        }

        $this->private_key = $private_key;
    }

    // Calculate the greatest common divisor
    private function gcd($a,$b) {
        return ($a % $b) ? $this->gcd($b,$a % $b) : $b;
    }
}
