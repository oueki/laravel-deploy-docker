<?php
namespace App\Http\Requests\OpenApi\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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

    public function rules()
    {
        return [
            'slug' => [Rule::unique('posts', 'slug')->ignore($this->id)],
        ];
    }
}
