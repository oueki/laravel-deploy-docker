<?php

namespace App\ValueObjects;

class Email
{
    public readonly string $value;

    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Incorrect email.');
        }
        $this->value = mb_strtolower($value);
    }



    public function __toString()
    {
        return $this->value;
    }

}
