<?php

namespace Tests\Unit\Models;

use App\Exceptions\BusinessException;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_category_is_default()
    {
        $category = Category::factory()->create([
            'default' => true
        ]);

        $this->assertTrue($category->default);
    }

    /** @test */
    public function test_override_category_default()
    {
        $category = Category::factory()->create([
            'default' => true
        ]);
        $category2 = Category::factory()->create([
            'default' => false
        ]);
        $category2->makeDefault();

        $this->assertFalse($category->refresh()->default);
        $this->assertTrue($category2->refresh()->default);

    }

    /** @test */
    public function an_exception_when_already_default()
    {
        $category = Category::factory()->create([
            'default' => true
        ]);

        $this->expectException(BusinessException::class);

        $category->makeDefault();

    }
}
