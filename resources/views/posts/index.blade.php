@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between">
      <div>
        <!--Menampilkan Nama Category saat link kategori di klik -->
        @isset($category)
          <h4>Category : {{ $category->name }}</h4>
        @endisset

        @isset($tag)
          <h4>Tag: {{ $tag->name }}</h4>
        @endisset

        @if (!isset($tag) && !isset($category))
          <h4>All Post</h4>
        @endif 
        <hr>
      </div>
      <div>
        @if (Auth::check())
          <a href="{{ route('posts.create') }}" class="btn btn-primary">New Post</a>    
        @else 
          <a href="{{ route('login') }}" class="btn btn-primary">Login to create new post</a>    
        @endif
      </div>
    </div>

    <div class="row">
      @if ($posts->count())
          @foreach ($posts as $post)
              <div class="col-md-4">
                <div class="card mb-4">

                  @if ($post->thumbnail)
                    <img style="height: 270px; object-fit: cover; object-position: center;" 
                      class="card-img-top" src="{{ asset($post->takeImage) }}">
                  @endif

                  <div class="card-body">
                    <div class="card-title">
                      {{ $post->title }}
                    </div> 
                    <div>
                      <!-- Limit panjang karakter yang ingin ditampilkan -->
                      {{ Str::limit($post->body, 100, '') }} 
                    </div>

                    <a href="/posts/{{ $post->slug }}">Read more</a>
                  </div>

                  <div class="card-footer d-flex justify-content-between">
                    Published On {{ $post->created_at->diffForHumans() }}
                    <!-- Memberikan policy pada tombol edit -->
                    @can('update', $post)
                      <a href="/posts/{{ $post->slug }}/edit" class="btn btn-sm btn-success">Edit</a>
                    @endcan
                  </div>
                </div> 
              </div> 
          @endforeach
      @else 
        <div class="alert alert-info">
          There are no posts.
        </div>
      @endif  
    </div>

    <div class="d-flex justify-content-center">
      <div>
          {{ $posts->links() }}
      </div>
    </div>
</div>
@endsection