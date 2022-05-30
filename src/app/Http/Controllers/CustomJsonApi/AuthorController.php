<?php

namespace App\Http\Controllers\CustomJsonApi;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorController
{
    public function index(): AuthorCollection
    {
        $authors = Author::all();
        return new AuthorCollection($authors);
    }


    public function show($id): AuthorResource
    {
        $author = Author::findOrFail($id);
        return new AuthorResource($author);
    }
}
