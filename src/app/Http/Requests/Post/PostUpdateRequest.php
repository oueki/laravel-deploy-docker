<?php

namespace App\Http\Requests\Post;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        return [
            'title' => 'required|max:255',
            'category' => 'required',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($this->post)],
            'content' => 'required',
        ];
    }

//    public function getPostUpdateDto(): object
//    {
//        return (object) [
//            'title' => $this['title'],
//            'slug' => $this['slug'],
//            'excerpt' => $this['excerpt'],
//            'content' => $this['content'],
//        ];
//    }
}
