<?php

namespace App\Models\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PostQueryBuilder extends Builder
{
    public function filter(array $filters)
    {
        $this->when($filters['id'] ?? null, function ($query, $id) {
            $query->where('id', $id);
        })->when($filters['slug'] ?? null, function ($query, $slug) {
            $query->where('slug', $slug);
        });
        return $this;
    }
}
