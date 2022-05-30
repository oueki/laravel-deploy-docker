<?php

namespace Tests\Unit\Service;


use App\Dto\BookDto;
use App\Events\BookCreated;
use App\Mail\NewBook;
use App\Models\Author;
use App\Models\Book;
use App\UseCase\Book\BookServiceFacade;
use App\ValueObjects\Money;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookServiceFacadeTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function test_create()
    {
        Event::fake();
        Mail::fake();

        $authors_id = Author::factory()->count(2)->create()->pluck('id')->toArray();

        $bookService = new BookServiceFacade();
        $dto = new BookDto(
            isbn: '234234234',
            title: 'New Book Title',
            price: new Money(500),
            page: 55,
            year: 2020,
        );
        $book = $bookService->create($dto, $authors_id);

        Event::assertDispatched(BookCreated::class);
        Mail::assertSent(function (NewBook $mail) use($book) {
            return $mail->book === $book;
        });

       $this->assertDatabaseHas(Book::class, [
            'isbn' => '234234234',
        ]);
    }
}
