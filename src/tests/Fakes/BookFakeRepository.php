<?php

namespace Tests\Fakes;

use App\Models\Book;
use App\Services\Repository\BookRepository;

class BookFakeRepository implements BookRepository
{

    public function save(Book $book)
    {
        $book->id = 10;
        return $book;
    }

    public function sync(Book $book, array $authors_ids)
    {
        // TODO: Implement sync() method.
    }
}
