<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'type'          => 'books',
            'id'            => $this->id,
            'attributes'    => [
                'isbn' => $this->isbn,
                'title' => $this->title,
                'price' => $this->price->format(),
                'page' => $this->page,
                'excerpt' => $this->excerpt,
                'year' => $this->year,
                'created-at'    => (string)$this->created_at,
                'updated-at'    => (string)$this->updated_at,
            ],
            'relationships' => new BookRelationshipResource($this),
            'links' => [
                'self' => route('custom:api:v1:books.show', ['id' => $this->id]),
            ]
        ];
    }
}
