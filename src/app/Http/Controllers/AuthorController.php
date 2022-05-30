<?php

namespace App\Http\Controllers;

use App\Dto\AuthorDto;
use App\Models\Author;
use App\Services\FileUploader\FileUploader;
use App\ValueObjects\Email;
use App\ValueObjects\Name;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthorController extends Controller
{

    public function index(): View
    {
        $authorsCollection = Author::orderBy('id', 'desc')->paginate(5);
        return view('web.authors.index', ['authorsCollection' => $authorsCollection]);
    }


    public function create()
    {
        //
    }


    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);


        $dto = new AuthorDto(
            name: new Name(
                $request->input('first_name'),
                $request->input('last_name'),
                $request->input('patronymic')
            ),
            email: new Email($request->input('email')),
            biography: $request->input('biography')
        );


        $author = new Author;
        $author->name = $dto->name;
        $author->email = $dto->email;
        $author->biography = $dto->biography;
        $author->saveOrFail();

        return back()->with('success', 'The author was created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }


    public function edit(Author $author): View
    {
        $authorsCollection = Author::orderBy('id', 'desc')->paginate(5);
        return view('web.authors.edit', ['author' => $author, 'authorsCollection' => $authorsCollection]);
    }


    /**
     * @throws Throwable
     * @throws ValidationException
     */
    public function update(Request $request, Author $author): RedirectResponse
    {

        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email'
        ]);

        $dto = new AuthorDto(
            name: new Name(
                $request->input('first_name'),
                $request->input('last_name'),
                $request->input('patronymic')
            ),
            email: new Email($request->input('email')),
            biography: $request->input('biography')
        );

        $author->name = $dto->name;
        $author->email = $dto->email;
        $author->biography = $dto->biography;
        $author->updateOrFail();


        return back()->with('success', 'The author has been successfully updated');
    }


    public function destroy(Author $author): RedirectResponse
    {
        $author->delete();
        return redirect()->route('authors.index');
    }
}
