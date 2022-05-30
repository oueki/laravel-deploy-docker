<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class BookRelationshipResource extends JsonResource
{
    public function toArray($request)
    {
        if(!$this->whenLoaded('authors') instanceof MissingValue){
            $data['authors'] =  [
                'data' => $this->authors->map(function ($item)  {
                    return ['type' => 'authors', 'id' => $item->id];
                })->toArray()
            ];
        }else{
            $data['authors'] = [];
        }

        return $data;
    }
}
