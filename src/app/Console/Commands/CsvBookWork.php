<?php

namespace App\Console\Commands;

use App\Dto\BookDto;
use App\UseCase\Book\BookService;
use Illuminate\Console\Command;


class CsvBookWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:csv-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle(BookService $service)
    {
        $books = [
            ['isbn' => '1345345345', 'title' => 'Enduring Love Enduring Love', 'price' => 100, 'page'=> 500],
            ['isbn' => '99945345', 'title' => 'The Fox The Fox', 'price' => 150, 'page'=> 350],
            ['isbn' => '75755345', 'title' => 'Doctor Faustus Doctor Faustus', 'price' => 200, 'page'=> 250],
        ];
        foreach ($books as $book) {
           try {
               $dto = new BookDto(
                   isbn: $book['isbn'],
                   title: $book['title'],
                   price: $book['price'],
                   page: $book['page'],
               );
               $service->create($dto);

               $this->info($book['title']);
           } catch (\Throwable $th) {
                $this->error($th->getMessage());
           }
        }
    }

}
