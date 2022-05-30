<?php

namespace App\UseCase\Book;

use App\Dto\BookDto;
use App\Events\BookUpdatePrice;
use App\Exceptions\BusinessException;
use App\Infrastructure\MultiDispatcher;
use App\Mail\NewBook;
use App\Models\Book;
use Illuminate\Database\ConnectionInterface;

class BookServiceAlt
{

    public function __construct(
        public MultiDispatcher $dispatcher,
        public ConnectionInterface $connection,
    ) {
    }

    public function create(BookDto $bookDto, array $authors_ids): Book
    {
        $this->isbnIsUnique($bookDto->isbn);

        $book = new Book;

        $this->connection->transaction(function() use ($bookDto, $authors_ids, $book) {
            $book->isbn = $bookDto->isbn;
            $book->title = $bookDto->title;
            $book->price = $bookDto->price;
            $book->page = $bookDto->page;
            $book->year = $bookDto->year;
            $book->excerpt = $bookDto->excerpt;
            $book->save();

//            $book = Book::createFromService($bookDto);

            $book->authors()->sync($authors_ids);
        });

        $this->dispatcher->multiDispatch($book->releaseEvents());


        return $book;
    }



    public function update(int $id, array $authors_ids, BookDto $bookDto): Book
    {
        $book = Book::findOrFail($id);

        $this->isbnIsUnique($bookDto->isbn, $id);

        $this->connection->transaction(function() use ($book, $bookDto, $authors_ids) {
            $book->update([
                'isbn' => $bookDto->isbn,
                'title' => $bookDto->title,
                'year' => $bookDto->year,
                'page' => $bookDto->page,
                'excerpt' => $bookDto->excerpt,
            ]);
            $book->changePrice($bookDto->price->amount);
            $book->authors()->sync($authors_ids);
        });

        $this->dispatcher->multiDispatch($book->releaseEvents());

        return $book;
    }

    private function isbnIsUnique(string $isbn, $exceptId = null): void
    {
        if($exceptId){
            $existBook = Book::where('isbn', $isbn)->where('id', '<>', $exceptId)->count();
        }else{
            $existBook = Book::where('isbn', $isbn)->count();
        }

        if($existBook){
            throw new BusinessException("Book with this isbn already exists " . $isbn);
        }
    }
}
