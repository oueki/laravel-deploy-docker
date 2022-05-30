<?php

namespace Tests\Unit\Service;

use App\Dto\BookDto;
use App\Events\BookCreated;
use App\Mail\NewBook;
use App\Models\Author;
use App\Models\Book;
use App\Services\Repository\BookRepository;
use App\Services\Sms\SmsLog;
use App\UseCase\Book\BookServiceNoFacade;
use App\ValueObjects\Money;
use Illuminate\Support\Testing\Fakes\EventFake;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Testing\Fakes\MailFake;
use Tests\Fakes\BookFakeRepository;
use Tests\Fakes\FakeConnection;
use Tests\TestCase;

class BookServiceNoFacadeTest extends TestCase
{
    /** @test */
    public function test_create()
    {
        $eventFake = new EventFake($this->createMock(Dispatcher::class));

        $mailFake = new MailFake();


        $bookService = new BookServiceNoFacade(
            $mailFake,
            $eventFake,
            new FakeConnection(),
            new BookFakeRepository(),
            new SmsLog()
        );

        $dto = new BookDto(
            isbn: '234234234',
            title: 'New Book Title',
            price: new Money(500),
            page: 55,
            year: 2020,
        );
        $book = $bookService->create($dto, [1,2,3]);

        $eventFake->assertDispatched(BookCreated::class);


    }
}
