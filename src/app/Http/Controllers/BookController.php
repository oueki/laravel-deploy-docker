<?php

namespace App\Http\Controllers;


use App\Models\Author;
use App\Models\Book;
use App\Http\Requests\Book\BookRequest;
use App\UseCase\Book\BookService;
use App\UseCase\Book\BookServiceAlt;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index(Request $request): View
    {

        $query = Book::query();
        $query->when($request->get('search_price'), function ($query, $price) {
            $query->where('price', $price);
        });

        $booksCollection = $query->orderBy('id', 'desc')->paginate(5);
        return view('web.books.index', [
            'booksCollection' => $booksCollection,
        ]);
    }

    public function create(): View
    {
        $authorsList = Author::select(['id','first_name', 'last_name', 'patronymic'])->get();
        return view('web.books.create', [
            'authorsList' => $authorsList,
        ]);
    }


    public function store(BookRequest $request, BookService $service): RedirectResponse
    {

        $book = $service->create($request->getDto(), $request->getAuthorsIds(), $request->bookFile());

        $service->notifyBook($book);

        return back()->with('success', 'The book was created');
    }


    public function edit($id): View
    {
        $book = Book::findOrFail($id);
        $authorsList = Author::select(['id', 'first_name', 'last_name', 'patronymic'])->get();
        $bookAuthors = $book->authors;
//        $booksCollection = Book::orderBy('id', 'desc')->paginate(5);

        return view('web.books.edit', [
            'book' => $book,
            'bookAuthors' => $bookAuthors,
//            'booksCollection' => $booksCollection,
            'authorsList' => $authorsList,
        ]);
    }


    public function update($id, BookRequest $request, BookService $service): RedirectResponse
    {
        $service->update($id, $request->getAuthorsIds(), $request->getDto());
        return back()->with('success', 'The book has been successfully updated');
    }


    public function destroy($id): RedirectResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index');
    }


    public function showApi(): JsonResponse
    {
        return new JsonResponse(
            data: Book::all(),
        );
    }
}
