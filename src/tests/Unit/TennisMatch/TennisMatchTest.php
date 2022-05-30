<?php

namespace Tests\Unit\TennisMatch;

use App\Services\TennisMatch\Player;
use App\Services\TennisMatch\TennisMatch;
use Tests\TestCase;

class TennisMatchTest extends TestCase
{
    /**
     * @test
     * @dataProvider scores
     */
    function it_scores_a_tennis_match($playerOnePoints, $playerTwoPoints, $score)
    {
        $match = new TennisMatch(
            $john = new Player('John'),
            $jane = new Player('Jane'),
        );

        for ($i = 0; $i < $playerOnePoints; $i++) {
            $john->score();
        }

        for ($i = 0; $i < $playerTwoPoints; $i++) {
            $jane->score();
        }

        $this->assertEquals($score, $match->score());
    }

    public function scores(): array
    {
        return [
            [0, 0, 'love-love'],
            [1, 0, 'fifteen-love'],
            [1, 1, 'fifteen-fifteen'],
            [2, 0, 'thirty-love'],
            [3, 0, 'forty-love'],
            [2, 2, 'thirty-thirty'],
            [3, 3, 'deuce'],
            [4, 4, 'deuce'],
            [5, 5, 'deuce'],
            [4, 3, 'Advantage: John'],
            [3, 4, 'Advantage: Jane'],
            [4, 0, 'Winner: John'],
            [0, 4, 'Winner: Jane'],
        ];
    }

    /**
     * @test
     */
    function example_test()
    {
        $player1 = $this->createStub(Player::class);
        $player2 = $this->createStub(Player::class);
        $player1->points = 3;
        $player2->points = 3;
        $player1->method('toTerm')->willReturn('deuce');
        $player2->method('toTerm')->willReturn('deuce');

        $match = new TennisMatch(
            $player1,
            $player2,
        );


        $this->assertEquals('deuce', $match->score());
    }
}
