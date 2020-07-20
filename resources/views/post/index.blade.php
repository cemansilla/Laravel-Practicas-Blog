@extends('layouts._main')

@section('content')
  @foreach($posts as $post)
    <p><a href="{{ URL::route('posts.show', $post->id) }}">{{ $post->title }}</a></p>
  @endforeach
@endsection