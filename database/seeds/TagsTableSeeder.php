<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = collect(['Laravel', 'Help', 'Bug', 'Slim']);
        $tags->each(function ($c) {
            \App\Tag::create([
                'name' => $c,
                'slug' => Str::slug($c),
            ]);
        });
    }
}
