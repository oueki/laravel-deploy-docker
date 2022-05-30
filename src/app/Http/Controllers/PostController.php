<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{

    public function index(Request $request): View
    {
        $categories = Category::pluck('name', 'id');
        $filters = $request->get('filter');
        $query = Post::query();

        $query->when($filters['category.id'] ?? null, function ($query, $category_id) {
            $query->where('category_id', $category_id);
        })->when($filters['category.name'] ?? null, function ($query, $category_name) {
            $query->whereHas('category', function (Builder $query) use($category_name){
                $query->where('name', 'like', $category_name . '%');
            });
        });


        $postsCollection = $query->orderBy('id', 'desc')
           ->with('category:id,name')
            ->paginate(10)
            ->withQueryString();


        return view('web.posts.index', [
            'postsCollection' => $postsCollection,
            'categories' => $categories
        ]);
    }


    public function create()
    {

    }


    public function store(PostRequest $request): RedirectResponse
    {

         $category = Category::findOrFail($request->input('category'));

         $post = new Post;
         $post->title = $request->input('title');
         $post->slug = $request->input('slug');
         $post->excerpt = $request->input('excerpt');
         $post->content = $request->input('content');
         $post->category()->associate($category);
         $post->saveOrFail();


        return back()->with('success', 'The post was created');
    }


    public function show(Post $post): View
    {
        return view('web.posts.show', [
            'post' => $post,
        ]);
    }


    public function edit(Post $post): View
    {
        $categories = Category::pluck('name', 'id');
        $postsCollection = Post::orderBy('id', 'desc')
            ->with('category')
            ->paginate(5);

        return view('web.posts.edit', [
            'post' => $post,
            'postsCollection' => $postsCollection,
            'categories' => $categories,
        ]);
    }


    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {

        $category = Category::findOrFail($request->input('category'));

        $post->title = $request['title'];
        $post->slug = $request['slug'];
        $post->excerpt = $request['excerpt'];
        $post->content = $request['content'];
        $post->category()->associate($category);
        $post->updateOrFail();

        return back()->with('success', 'The post has been successfully updated');
    }


    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index');
        // return redirect()->back();
    }

    public function showApi(): JsonResponse
    {
        return new JsonResponse(
            data: Post::all(),
        );
    }
}
