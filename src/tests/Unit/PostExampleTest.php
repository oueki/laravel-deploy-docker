<?php

namespace Tests\Unit;

use App\Exceptions\BusinessException;
use App\Services\PostExample;
use Tests\TestCase;

class PostExampleTest extends TestCase
{
    public function test_successful_create()
    {
        $post = new PostExample('post title example', '');

        $this->assertEquals('post title example', $post->title);
    }

    public function test_empty_title()
    {
        $this->expectException(\InvalidArgumentException::class);

        new PostExample('', '');
    }

    public function test_successful_publish()
    {
        $post = new PostExample('post title example', 'Lorem ipsum dolor sit amet');

        $post->publish();

        $this->assertTrue($post->published);
    }

    public function test_publish_empty_body()
    {
        $post = new PostExample('post title example', '');

        $this->expectException(BusinessException::class);

        $post->publish();
    }

    public function test_post_auto_except()
    {
        $post = new PostExample('post title example', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');
        $post->fillExcept(100);


        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labo...', $post->except);
    }
}
