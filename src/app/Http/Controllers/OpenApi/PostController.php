<?php

namespace App\Http\Controllers\OpenApi;

use App\Http\Requests\OpenApi\Post\PostUpdateRequest;
use App\Http\Requests\Post\PostRequest;
use App\Http\Resources\OpenApi\Post\PostCollection;
use App\Http\Resources\OpenApi\Post\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class PostController
{

    #[OA\Get(
        path: '/posts',
        summary: "Get list of blog posts",
        tags: ['posts'],
    )]
    #[OA\Parameter(
        name: "sort",
        description: "sort",
        in: "query",
        schema: new OA\Schema(
            type: "array",
            items: new OA\Items(
                type: "string",
                enum: ['id', '-id', 'title', 'created_at']
            )
        )
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
                    property: "slug",
                    type: "string"
                )
            ],
            type: "object"
        ),
        style: "deepObject",
    )]
    #[OA\Parameter(
        name: "offset",
        description: "offset",
        in: "query",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
        examples: [
            new OA\Examples(
                example: 0,
                summary: 0,
                value: 0,
            )
        ]
    )]
    #[OA\Parameter(
        name: "limit",
        description: "limit",
        in: "query",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
        examples: [
            new OA\Examples(
                example: 10,
                summary: 10,
                value: 10,
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(
                ref: "#/components/schemas/PostResource"
            )
        )
    )]

    public function index(Request $request): PostCollection
    {

        $filters = $request->get('filter');
        $sort = $request->get('sort');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);


        $query = Post::query();

        $query->when($filters['id'] ?? null, function ($query, $id) {
            $query->where('id', $id);
        })->when($filters['slug'] ?? null, function ($query, $slug) {
            $query->where('slug', $slug);
        });


        $query->when($sort, function ($query, $sort) {
            $type = 'asc';
            $param = $sort;
            if($sort[0] === '-'){
                $param = ltrim($param, '-');
                $type = 'desc';
            }
            $query->orderBy($param, $type);
        });

        $posts = $query
            ->offset($offset ?? 0)
            ->limit($limit ?? 10)
            ->with('category:id,name,default')
            ->get();


        return new PostCollection($posts);
    }



    #[OA\Get(
        path: '/posts/{id}',
        summary: "Get post detail",
        tags: ['posts'],
    )]
    #[OA\Parameter(
        name: "id",
        description: "post id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
    )]
    #[OA\Response(
        response: 200,
        description: 'success',
        content: new OA\JsonContent(
           ref: "#/components/schemas/PostResource"
        )
    )]
    public function show($id): PostResource
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }


    #[OA\Post(
        path: '/posts',
        summary: "Store new post",
        tags: ['posts'],
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "title",
                    type: "string"
                ),
                new OA\Property(
                    property: "category",
                    type: "integer",
                    format: 'int64'
                ),
                new OA\Property(
                    property: "slug",
                    type: "string",
                ),
                new OA\Property(
                    property: "content",
                    type: "string"
                ) ,
                new OA\Property(
                    property: "excerpt",
                    type: "string"
                )
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_CREATED,
        description: 'success',
        content: new OA\JsonContent(
            ref: "#/components/schemas/PostResource"
        )
    )]
    public function store(PostRequest $request): JsonResponse
    {
        $category = Category::findOrFail($request->input('category'));

        $post = new Post;
        $post->title = $request->input('title');
        $post->category_id = $category->id;
        $post->slug = $request->input('slug');
        $post->excerpt = $request->input('excerpt');
        $post->content = $request->input('content');
        $post->saveOrFail();

        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }


    #[OA\Put(
        path: '/posts/{id}',
        summary: "Update existing post",
        tags: ['posts'],
    )]
    #[OA\Parameter(
        name: "id",
        description: "post id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "title",
                    type: "string"
                ),
                new OA\Property(
                    property: "category",
                    type: "integer",
                    format: 'int64'
                ),
                new OA\Property(
                    property: "slug",
                    type: "string",
                ),
                new OA\Property(
                    property: "content",
                    type: "string"
                ) ,
                new OA\Property(
                    property: "excerpt",
                    type: "string"
                )
            ]
        )
    )]
    #[OA\Response(
        response: Response::HTTP_OK,
        description: 'success',
        content: new OA\JsonContent(
            ref: "#/components/schemas/PostResource"
        )
    )]
    public function update(PostUpdateRequest $request, $id): JsonResponse
    {

        $post = Post::findOrFail($id);
        $post->fill($request->all());
        if($request->input('category')){
            $category = Category::findOrFail($request->input('category'));
            $post->category()->associate($category);
        }
        $post->updateOrFail();


        return (new PostResource($post))
            ->response()
            ->setStatusCode(Response::HTTP_OK);

    }

    #[OA\Delete(
        path: '/posts/{id}',
        summary: "Delete existing post",
        tags: ['posts'],
    )]
    #[OA\Parameter(
        name: "id",
        description: "post id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int64",
        ),
    )]
    #[OA\Response(
        response: Response::HTTP_NO_CONTENT,
        description: 'success',
        content: new OA\JsonContent()
    )]
    #[OA\Response(
        response: Response::HTTP_NOT_FOUND,
        description: 'Resource Not Found',
    )]
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}


//$qb = \DB::table('posts');
//$qb->when($filters['id'] ?? null, function ($query, $id) {
//    $query->where('id', $id);
//})->when($filters['slug'] ?? null, function ($query, $slug) {
//    $query->where('slug', $slug);
//});
//$qb->get();
