<?php

namespace App\ValueObjects;

class Name
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string|null $patronymic,
    ) {
    }

    public function getFull(): string
    {
        $full = $this->first_name . ' ' . $this->last_name;
        if($this->patronymic){
            return $full . ' ' . $this->patronymic;
        }
        return $full;
    }
}
