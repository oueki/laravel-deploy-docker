<?php

namespace App\Commands\Book\Create;


use App\Mail\NewBook;
use App\Models\Book;
use Illuminate\Contracts\Mail\Mailer;

class Handler
{
    public function __construct(
        public Mailer $mailer,
    ) {
    }

    public function __invoke(Command $command): void
    {
        $book = new Book;
        $book->isbn = $command->isbn;
        $book->title = $command->title;
        $book->saveOrFail();

        $this->mailer->send(new NewBook($book));
    }
}
