<?php

namespace App\Http\Resources;

use App\Models\Author;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;

class BookCollection extends ResourceCollection
{

//    public $collects = BookResource::class;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }

    public function with($request): array
    {
        $include_type = $request->query('include');

        if(empty($include_type)){
            return [];
        }

        $include_type = explode(',', $include_type);
        $includes = $this->generateIncludes($include_type)->unique();
        return [
            'included' => $this->withIncluded($includes)
        ];
    }

    private function withIncluded($included)
    {
        return $included->map(function ($include) {
            if ($include instanceof Author) {
                return new AuthorResource($include);
            }
        });
    }

    private function generateIncludes($types): Collection
    {
        $included = collect();
        foreach ($types as $type){
            if($type == 'authors'){
                $authors = $this->collection->flatMap(function ($book) {
                    return $book->authors;
                });
                $included[] = $authors;
            }
        }
        return $included->collapse()->unique('id')->filter()->values();
    }

}
