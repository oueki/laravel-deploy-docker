<?php

namespace App\Services\Repository;

use App\Models\Book;

interface BookRepository
{
    public function save(Book $book);
    public function sync(Book $book, array $authors_ids);
}
