<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'type'          => 'authors',
            'id'            => $this->id,
            'attributes'    => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'patronymic' => $this->patronymic,
                'email'     => $this->email->value,
                'biography' => $this->biography,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => route('custom:api:v1:authors.show', ['id' => $this->id]),
            ]
        ];
    }
}
