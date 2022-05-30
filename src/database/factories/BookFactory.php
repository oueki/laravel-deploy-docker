<?php

namespace Database\Factories;

use App\ValueObjects\Money;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'isbn' => $this->faker->unique()->isbn13(),
            'title' => $this->faker->sentence(),
            'price' => new Money($this->faker->numberBetween(10, 800)),
            'page' => $this->faker->numberBetween(50, 400),
            'year' => $this->faker->year(),
            'excerpt' => $this->faker->paragraph(),
        ];
    }
}
