<?php

namespace App\ValueObjects;

class Money
{
    public readonly int $amount;

    public function __construct(int $amount)
    {
        if ($amount < 0) {
            throw new \InvalidArgumentException('Money value cannot be negative');
        }

        $this->amount = $amount;
    }

    public function format(): string
    {
        return number_format($this->amount) . ' $';
    }

}
