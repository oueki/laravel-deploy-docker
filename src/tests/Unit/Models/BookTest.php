<?php

namespace Tests\Unit\Models;

use App\Events\BookUpdatePrice;
use App\Models\Book;
use App\ValueObjects\Money;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_event_price_change_reduction()
    {
        $book = Book::factory()->create([
            'price' => new Money(1000)
        ]);
        $book->changePrice(200);

        $this->assertEventsHas(BookUpdatePrice::class, $book->releaseEvents());
    }

    /** @test */
    public function test_no_event_price_change()
    {
        $book = Book::factory()->create([
            'price' => new Money(1000)
        ]);
        $book->changePrice(1200);

        $this->assertEventsNoHas(BookUpdatePrice::class, $book->releaseEvents());
    }
}
