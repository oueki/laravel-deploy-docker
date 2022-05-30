<?php

namespace App\Http\Resources\OpenApi\Comment;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class CommentResource extends JsonResource
{
    #[OA\Schema(
        schema: 'CommentResource',
        properties: [
            new OA\Property(
                property: 'id',
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: 'post_id',
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: 'user_id',
                format: 'int64',
                example: 1
            ),
            new OA\Property(
                property: 'content',
                format: 'string',
                example: 'Eum asperiores cumque inventore assumenda'
            )
        ],
        type: 'object',
    )]
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'post_id'       => $this->post_id,
            'user_id'       => $this->user_id,
            'content'       => $this->content,
        ];
    }
}
