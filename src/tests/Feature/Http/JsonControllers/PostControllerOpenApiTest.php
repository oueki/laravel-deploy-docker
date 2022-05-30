<?php

namespace Tests\Feature\Http\JsonControllers;

use App\Http\Controllers\OpenApi\PostController;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostControllerOpenApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index()
    {
        Category::factory()->count(1)->create();
        User::factory()->count(5)->create();
        Post::factory()->count(5)->create([
            'category_id' => 1
        ]);

        $this->get(action([PostController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('data', 5)
                    ->where('meta.totalCount', 5)
                    ->has('data.0', function (AssertableJson $json) {
                        $json
                            ->has('id')
                            ->has('category_id')
                            ->has('title')
                            ->has('slug')
                            ->has('excerpt')
                            ->etc();
                    })
                ;
            });
    }

    /** @test */
    public function show()
    {
        Category::factory()->count(1)->create();
        User::factory()->count(5)->create();
        $post = Post::factory()->create([
            'category_id' => 1
        ]);

        $this->get(action([PostController::class, 'show'], $post->id))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('data', function (AssertableJson $json) {
                        $json
                            ->has('id')
                            ->has('category_id')
                            ->has('title')
                            ->has('slug')
                            ->has('excerpt')
                            ->etc();
                    })
                ;
            });
    }

    /** @test */
    public function store()
    {
        Category::factory()->count(1)->create();

        $this
            ->post(action([PostController::class, 'store']), [
                'title' => 'example post name',
                'category'  => 1,
                'slug' => 'new-custom-slug-post',
                'excerpt'  => 'asdasd asd asd as d',
                'content' => 'fdg fdg fdg fd gfd fd fd',
            ])
            ->assertSuccessful()
            ->assertStatus(Response::HTTP_CREATED);


        $this->get(action([PostController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->where('meta.totalCount', 1)
                    ->has('data.0', function (AssertableJson $json) {
                        $json
                            ->has('id')
                            ->has('category_id')
                            ->has('title')
                            ->has('slug')
                            ->has('excerpt')
                            ->etc();
                    })
                ;
            });
    }

    /** @test */
    public function update()
    {
        User::factory()->count(1)->create();
        Category::factory()->count(1)->create();
        $post = Post::factory()->create([
            'category_id' => 1
        ]);


        $this
            ->put(action([PostController::class, 'update'], $post->id), [
                'title' => 'post title has been updated',
            ])
            ->assertSuccessful()
            ->assertStatus(Response::HTTP_OK);

        $this->get(action([PostController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->where('meta.totalCount', 1)
                    ->where('data.0.title', 'post title has been updated')
                ;
            });
    }

    /** @test */
    public function delete_post()
    {
        User::factory()->count(1)->create();
        Category::factory()->count(1)->create();
        $post = Post::factory()->create([
            'category_id' => 1
        ]);

        $this
            ->delete(action([PostController::class, 'delete'], $post->id))
            ->assertSuccessful()
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->get(action([PostController::class, 'index']))
            ->assertSuccessful()
            ->assertJson(function (AssertableJson $json) {
                $json
                    ->has('data', 0)
                ;
            });
    }
}
