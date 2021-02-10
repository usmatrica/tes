<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function test()
    {
        $posts = Post::whereHas('category', function($query){
            $query->where('name', 'like', '%Frame%');
        })->get();
        dd($posts[0]);
        return view('posts.index', ['posts' => $posts]);
    }

    public function index()
    {
        /* Membuat pagination */
        $posts = Post::latest()->paginate(6);
        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Post $post)
    {

        /* Beberapa Cara Menampilan 404 not found jika data kosong / tidak ada
        if (is_null($post)) {
            abort(404);
        }

        if (!post) {
            abort(404);
        }

        $post = \App\Post::where('slug', $slug)->firstOrFail();
        */

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create', [
            'post' => new Post(),
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function store(PostRequest $request)
    {
        /* Insert data to table database
        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'body' => $request->body,
        ]);
        */
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        $attr = $request->all();

        $slug = Str::slug(request('title'));
        $attr['slug'] = $slug;
        $thumbnail = request()->file('thumbnail') ? request()->file('thumbnail')->store("images/posts") : null;

        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;

        //Create new post
        $post = auth()->user()->posts()->create($attr);

        $post->tags()->attach(request('tags'));

        //Create Session
        session()->flash('success', 'The post was created');
        //session()->flash('error', 'The post was error');

        //Return back to file you want
        return redirect()->to('posts');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => Category::get(),
            'tags' => Tag::get(),
        ]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);

        //Memberikan Policy
        $this->authorize('update', $post);

        if (request()->file('thumbnail')) {
            \Storage::delete($post->thumbnail);
            $thumbnail = request()->file('thumbnail')->store("images/posts");
        } else {
            $thumbnail = $post->thumbnail;
        }

        //Proses update
        $attr = $request->all();
        $attr['category_id'] = request('category');
        $attr['thumbnail'] = $thumbnail;
        $post->update($attr);
        $post->tags()->sync(request('tags'));

        session()->flash('success', 'The post was updated');

        return redirect()->to('posts');
    }

    public function destroy(Post $post)
    {
        \Storage::delete($post->thumbnail);

        //Menggunakan Authorized
        $this->authorize('delete', $post);
        session()->flash('success', 'The Post Was Deleted');
        return redirect('posts');

        //Dapat juga menggunakan kondisi if
        /*if (auth()->user()->is($post->author)) {
            $post->tags()->detach();
            $post->delete();
            session()->flash('success', 'The Post Was Destroyed');
            return redirect('posts');
        } else {
            session()->flash('error', "It wasn't your post");
            return redirect('posts');
        } */
    }
}
