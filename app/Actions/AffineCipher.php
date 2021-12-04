<?php

namespace App\Actions;


class AffineCipher
{
    private int $key1;
    private int $key2;
    private static array $available_keys = [1,3,5,7,9,11,15,17,19,21,23,25];
    private Alphabet $alphabet;

    public function __construct(int $key1, int $key2)
    {
        $this->key1 = $key1;
        $this->key2 = $key2;
        $this->alphabet = new Alphabet();
    }


    public function encrypt(string $plainText): string
    {
        $cipherText = '';

        foreach (str_split($plainText) as $char) {
            $numericValue = $this->alphabet->getAlphabetValue($char);
            $cipherValue = $numericValue * $this->key1 + $this->key2;
            $cipherValue = fmod($cipherValue, 26);
            $cipherText .= $this->alphabet->getAlphabetLetter($cipherValue);
        }

        return $cipherText;

    }

    /**
     * @throws \Exception
     */
    public function decrypt(string $cipherText): string
    {
        $plainText = '';

        // P = ((C - k2) * (1/k1)) mod 26
        foreach (str_split($cipherText) as $char) {

            $keyOneInverse = $this->modInverse($this->key1);
            $cipherValue = $this->alphabet->getAlphabetValue($char);
            $plainTextValue = ($cipherValue - $this->key2) * $keyOneInverse;

            while ($plainTextValue < 0) {
                $plainTextValue += 26;
            }

            $plainTextValue = fmod($plainTextValue, 26);
            $plainText .= $this->alphabet->getAlphabetLetter($plainTextValue);
        }

        return $plainText;
    }

    // Multiplicative inverse of a modulo 26

    /**
     * @throws \Exception
     */
    private function modInverse(int $key1): int
    {
        $key1 = $key1 % 26;
        for ($i = 1; $i < 26; $i++) {
            if (($key1 * $i) % 26 == 1) {
                return fmod($i, 26);
            }
        }
        throw new \Exception("No inverse found");
    }


    public static function getKeyOneFor(int $key)
    {
        return self::getClosest($key, self::$available_keys);
    }

    private static function getClosest($search, $arr) {
        $closest = null;
        foreach ($arr as $item) {
            if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                $closest = $item;
            }
        }
        return $closest;
    }
}
