<?php

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
        //$users = factory(\App\User::class, 10)->create();
        #//factory(\App\User::class, 10)->create()->each(function($user){
        #//    $user->posts()->saveMany(factory(\App\Post::class,10)->make(['user_id'=>$user->id]));
        #//});

        factory(\App\Category::class,10)->create();

        $users = factory(\App\User::class, 10)->create();
        foreach ($users as $user)
        {
            $category = \App\Category::inRandomOrder()->first();
            $posts = factory(\App\Post::class, 10)->make(['user_id'=>$user->id,'category_id'=>$category]);
            $user->posts()->saveMany($posts);
            $ads = factory(\App\Ad::class,50)->create(['user_id'=>$user->id]);
        }

        $tags = factory(\App\Tag::class, 20)->create();

        foreach (\App\Post::all() as $post)
        {
            // 3..5 categories apply to post
            $tags = \App\Tag::inRandomOrder()->take(rand(3,5))->pluck('id');
            $post->tags()->attach($tags);
        }
    }
}
