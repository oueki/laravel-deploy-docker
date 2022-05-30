<?php

namespace App\UseCase\Book;

use App\Dto\BookDto;
use App\Events\BookCreated;
use App\Mail\NewBook;
use App\Models\Book;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;

class BookServiceFacade
{
    public function create(BookDto $bookDto, array $authors_ids): Book
    {
        $book = new Book;

        DB::transaction(function() use ($book, $bookDto, $authors_ids) {
            $book->isbn = $bookDto->isbn;
            $book->title = $bookDto->title;
            $book->price = $bookDto->price;
            $book->page = $bookDto->page;
            $book->year = $bookDto->year;
            $book->excerpt = $bookDto->excerpt;
            $book->save();
            $book->authors()->sync($authors_ids);
        });

        Event::dispatch(new BookCreated($book->id));

        Mail::send(new NewBook($book));

        return $book;
    }
}
