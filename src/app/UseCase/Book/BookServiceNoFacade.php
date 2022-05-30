<?php

namespace App\UseCase\Book;

use App\Events\BookCreated;
use App\Mail\NewBook;
use App\Models\Book;
use App\Services\Repository\BookRepository;
use App\Services\Sms\Sms;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Database\ConnectionInterface;

class BookServiceNoFacade
{

    public function __construct(
        public Mailer $mailer,
        public Dispatcher $dispatcher,
        public ConnectionInterface $connection,
        public BookRepository $repository,
        public Sms $sms,
    ) {
    }

    public function create($bookDto, $authors_ids): Book
    {
        $book = new Book;

        $this->connection->transaction(function() use ($book, $bookDto, $authors_ids, ) {
            $book->isbn = $bookDto->isbn;
            $book->title = $bookDto->title;
            $book->price = $bookDto->price;
            $book->page = $bookDto->page;
            $book->year = $bookDto->year;
            $book->excerpt = $bookDto->excerpt;
//            $book->save();
//            $book->authors()->sync($authors_ids);
            $this->repository->save($book);
            $this->repository->sync($book, $authors_ids);

        });

        $this->dispatcher->dispatch(
            new BookCreated($book->id)
        );
        $this->mailer->send(new NewBook($book));

        $this->sms->send('+7999999999', 'New Book Created');


        return $book;
    }
}
