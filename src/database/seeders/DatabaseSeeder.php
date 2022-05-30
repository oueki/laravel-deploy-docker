<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(3)->create();

        \App\Models\Category::factory(4)->has( \App\Models\Post::factory()->count(20)->has(\App\Models\Comment::factory()->count(10)) )->create();

        \App\Models\Author::factory(10)->has(\App\Models\Book::factory()->count(3))->create();
    }
}
