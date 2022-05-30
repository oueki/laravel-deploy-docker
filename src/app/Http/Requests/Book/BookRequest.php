<?php

namespace App\Http\Requests\Book;

use App\Dto\BookDto;
use App\ValueObjects\Money;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
//            'isbn' => 'required|unique:books,isbn',
            'isbn' => 'required',
            'title' => 'required|max:255',
            'price' => 'required|integer',
            'page' => 'required|integer',
            'authors' => 'required|array',
            'year' => 'required|integer',
            'file' => 'file|image',
        ];
    }

    public function getDto(): BookDto
    {
        return new BookDto(
            isbn: $this->input('isbn'),
            title: $this->input('title'),
            price: new Money($this->input('price')),
            page: $this->input('page'),
            year: $this->input('year'),
            excerpt: $this->input('excerpt') ?? '',
        );
    }

    public function getAuthorsIds(): array
    {
        return $this->input('authors');
    }

    public function bookFile(): array
    {
        return [
            'hasFile' => $this->hasFile('file'),
            'file' => $this->file
        ];
    }

}
