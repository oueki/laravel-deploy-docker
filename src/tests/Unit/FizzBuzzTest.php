<?php

use App\Services\FizzBuzz;
use Tests\TestCase;

class FizzBuzzTest extends TestCase
{
    /** @test */
    function it_returns_fizz_for_multiples_of_three()
    {
        foreach ([3, 6, 9, 12] as $number) {
            $this->assertEquals('fizz', FizzBuzz::convert($number));
        }
    }

    /** @test */
    function it_returns_buzz_for_multiples_of_five()
    {
        foreach ([5, 10, 20, 25] as $number) {
            $this->assertEquals('buzz', FizzBuzz::convert($number));
        }
    }

    /** @test */
    function it_returns_fizzbuzz_for_multiples_of_three_and_five()
    {
        foreach ([15, 30, 45, 60] as $number) {
            $this->assertEquals('fizzbuzz', FizzBuzz::convert($number));
        }
    }

    /** @test */
    function it_returns_the_original_number_if_not_divisible_by_three_or_five()
    {
        foreach ([1, 2, 4, 7, 8, 11] as $number) {
            $this->assertEquals($number, FizzBuzz::convert($number));
        }
    }


}
