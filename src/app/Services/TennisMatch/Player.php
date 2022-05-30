<?php

namespace App\Services\TennisMatch;

class Player
{

    public string $name;


    public int $points = 0;


    public function __construct(string $name)
    {
        $this->name = $name;
    }


    public function score(): void
    {
        $this->points++;
    }


    public function toTerm(): string
    {
        switch ($this->points) {
            case 0:
                return 'love';
            case 1:
                return 'fifteen';
            case 2:
                return 'thirty';
            case 3:
                return 'forty';
        }
    }
}
