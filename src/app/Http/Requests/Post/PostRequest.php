<?php

namespace App\Http\Requests\Post;

use OpenApi\Attributes as OA;
use Illuminate\Foundation\Http\FormRequest;


class PostRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.max' => 'custom message :attribute limit :max',
            'content.required' => 'A content is required',
        ];
    }

    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'category' => 'required',
            'slug' => 'required|unique:posts,slug',
            'content' => 'required',
        ];
    }

//    public function getPostCreateDto(): object
//    {
//        return (object) [
//            'title' => $this['title'],
//            'slug' => $this['slug'],
//            'excerpt' => $this['excerpt'],
//            'content' => $this['content'],
//        ];
//    }
}
