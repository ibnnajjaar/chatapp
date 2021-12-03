<?php

namespace App\Actions;


class AffineCipher
{
    private int $key1;
    private int $key2;
    private static array $available_keys = [1,3,5,7,9,11,15,17,19,21,23,25];
    private array $alphabetValues = [
        'a' => 0,
        'b' => 1,
        'c' => 2,
        'd' => 3,
        'e' => 4,
        'f' => 5,
        'g' => 6,
        'h' => 7,
        'i' => 8,
        'j' => 9,
        'k' => 10,
        'l' => 11,
        'm' => 12,
        'n' => 13,
        'o' => 14,
        'p' => 15,
        'q' => 16,
        'r' => 17,
        's' => 18,
        't' => 19,
        'u' => 20,
        'v' => 21,
        'w' => 22,
        'x' => 23,
        'y' => 24,
        'z' => 25,
    ];
    // alphabets corresponding to a value
    private array $alphabet = [
        0 => 'a',
        1 => 'b',
        2 => 'c',
        3 => 'd',
        4 => 'e',
        5 => 'f',
        6 => 'g',
        7 => 'h',
        8 => 'i',
        9 => 'j',
        10 => 'k',
        11 => 'l',
        12 => 'm',
        13 => 'n',
        14 => 'o',
        15 => 'p',
        16 => 'q',
        17 => 'r',
        18 => 's',
        19 => 't',
        20 => 'u',
        21 => 'v',
        22 => 'w',
        23 => 'x',
        24 => 'y',
        25 => 'z',
    ];

    public function __construct(int $key1, int $key2)
    {
        $this->key1 = $key1;
        $this->key2 = $key2;
    }


    public function encrypt(string $plainText): string
    {
        $cipherText = '';

        foreach (str_split($plainText) as $char) {
            $numericValue = $this->alphabetValues[$char] ?? 0;
            $cipherValue = $numericValue * $this->key1 + $this->key2;
            $cipherValue = fmod($cipherValue, 26);
            $cipherText .= $this->alphabet[$cipherValue] ?? 'a';
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
            $cipherValue = $this->alphabetValues[$char] ?? 0;
            $plainTextValue = ($cipherValue - $this->key2) * $keyOneInverse;

            while ($plainTextValue < 0) {
                $plainTextValue += 26;
            }

            $plainTextValue = fmod($plainTextValue, 26);

            $plainText .= $this->alphabet[$plainTextValue] ?? 'a';
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
