<?php

namespace App\Services;

class FizzBuzz
{
    public static function convert(int $number): int|string
    {
        $result = '';

        if ($number % 3 === 0) {
            $result .= 'fizz';
        }

        if ($number % 5 === 0) {
            $result .= 'buzz';
        }

        return $result ?: $number;
    }
}
