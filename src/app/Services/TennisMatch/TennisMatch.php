<?php

namespace App\Services\TennisMatch;

class TennisMatch
{

    protected Player $playerOne;


    protected Player $playerTwo;


    public function __construct(Player $playerOne, Player $playerTwo)
    {
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
    }


    public function score(): string
    {
        if ($this->hasWinner()) {
            return 'Winner: '.$this->leader()->name;
        }

        if ($this->hasAdvantage()) {
            return 'Advantage: '.$this->leader()->name;
        }

        if ($this->isDeuce()) {
            return 'deuce';
        }

        return sprintf(
            "%s-%s",
            $this->playerOne->toTerm(),
            $this->playerTwo->toTerm(),
        );
    }


    protected function leader(): Player
    {
        return $this->playerOne->points > $this->playerTwo->points
            ? $this->playerOne
            : $this->playerTwo;
    }


    protected function isDeuce(): bool
    {
        if (! $this->hasReachedDeuceThreshold()) {
            return false;
        }

        return $this->playerOne->points === $this->playerTwo->points;
    }


    protected function hasReachedDeuceThreshold(): bool
    {
        return $this->playerOne->points >= 3 && $this->playerTwo->points >= 3;
    }


    protected function hasAdvantage(): bool
    {
        if (! $this->hasReachedDeuceThreshold()) {
            return false;
        }

        return ! $this->isDeuce();
    }


    protected function hasWinner(): bool
    {
        if ($this->playerOne->points < 4 && $this->playerTwo->points < 4) {
            return false;
        }

        return abs($this->playerOne->points - $this->playerTwo->points) >= 2;
    }
}
