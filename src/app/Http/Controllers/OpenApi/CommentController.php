<?php

namespace App\Http\Controllers\OpenApi;

use App\Http\Resources\OpenApi\Comment\CommentCollection;
use App\Models\Comment;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class CommentController
{

    #[OA\Get(
        path: '/comments',
        summary: "Get list of blog comments",
        tags: ['comments'],
    )]
    #[OA\Parameter(
        name: "filter",
        description: "filter",
        in: "query",
        schema: new OA\Schema(
            properties: [
                new OA\Property(
                    property: "id",
                    type: "integer"
                ),
                new OA\Property(
                    property: "post_id",
                    type: "integer"
                ),
                new OA\Property(
                    property: "user_id",
                    type: "integer"
                )
            ],
            type: "object"
        ),
        style: "deepObject",
    )]
    #[OA\Parameter(
        name: "page",
        description: "page",
        in: "query",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
        examples: [
            new OA\Examples(
                example: 1,
                summary: 1,
                value: 1,
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: "#/components/schemas/CommentResource"
            )
        )
    )]

    public function index(Request $request): CommentCollection
    {
        $filters = $request->get('filter');
        $query = Comment::query();

        $query->when($filters['id'] ?? null, function ($query, $id) {
            $query->where('id', $id);
        })->when($filters['post_id'] ?? null, function ($query, $post_id) {
            $query->where('post_id', $post_id);
        })->when($filters['user_id'] ?? null, function ($query, $user_id) {
            $query->where('user_id', $user_id);
        });


        $comments = $query
            ->paginate();

        return new CommentCollection($comments);
    }

}
