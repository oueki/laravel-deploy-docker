<?php

namespace App\Http\Resources\OpenApi\Post;

use Illuminate\Http\Resources\Json\JsonResource;


class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    /**
     *  @OA\Schema(
     *    schema="PostResource",
     *    type="object",
     *
     *    @OA\Property(
     *      property="id",
     *      format="int64",
     *      example="1"
     *    ),
     *    @OA\Property(
     *      property="category_id",
     *      format="int64",
     *      example="1"
     *    ),
     *    @OA\Property(
     *      property="title",
     *      format="string",
     *      example="Example Post Name"
     *    ),
     *
     *    @OA\Property(
     *      property="slug",
     *      format="string",
     *      example="post-slug-url"
     *    ),
     *
     *    @OA\Property(
     *      property="excerpt",
     *      format="string",
     *      example="lorem lorem lorem lorem"
     *    ),
     *
     *    @OA\Property(
     *      property="content",
     *      format="string",
     *      example="lorem ipsum lorem ipsumlorem ipsum lorem ipsum lorem ipsum"
     *    ),
     *     @OA\Property(property="category", type="object",
     *         @OA\Property(property="id", type="integer", example="1"),
     *         @OA\Property(property="name", type="string"),
     *         @OA\Property(property="default", type="boolean"),
     *     ),
     *  )
     */



    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'category_id'   => $this->category_id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'excerpt'       => $this->excerpt,
            'content'       => $this->content,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'default' => (boolean) $this->category->default,
            ],
        ];
    }
}


