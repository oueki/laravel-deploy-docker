<?php

namespace App\Http\Controllers\CustomJsonApi;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController
{
    public function index(): BookCollection
    {
        $books = Book::paginate();
        return new BookCollection($books);
    }


    public function show($id): BookResource
    {
        $book = Book::findOrFail($id);
        return new BookResource($book);
    }

}
