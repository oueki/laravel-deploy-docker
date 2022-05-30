<?php

namespace App\Services\Repository;

use App\Models\Book;

class EloquentBookRepository implements BookRepository
{

    public function save(Book $book)
    {
        $book->save();
    }

    public function sync(Book $book, array $authors_ids)
    {
        $book->authors()->sync($authors_ids);
    }
}
