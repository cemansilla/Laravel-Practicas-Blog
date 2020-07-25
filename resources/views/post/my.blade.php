@extends('layouts.app')

@section('content')
  <div class="container">
    @foreach($posts as $post)
      <div class="card mb-4">
        <div class="card-body">
          <h5 class="card-title">{{ $post->title }}</h5>
          <p class="card-text">{{ $post->content }}</p>

          <div class="d-flex justify-content-end ml-2">
            <a href="{{ route('posts.show', ['post' => $post]) }}" class="btn btn-primary">Read more</a>
            <a href="{{ route('posts.edit', ['post' => $post]) }}" class="btn btn-primary ml-2">Edit</a>

            <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="post">
              @method('DELETE')
              @csrf
              <button class="btn btn-danger ml-2">Delete</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach

    {{ $posts->links() }}
  </div>
@endsection