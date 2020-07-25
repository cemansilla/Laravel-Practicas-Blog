@extends('layouts.app')

@section('content')
  @if(Session::has('message'))
    <div class="container alert alert-success">
      {{ Session::get('message') }}
    </div>
  @endif

  @if($errors->any())
  <div class="container alert alert-danger">
    <ul>
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form method="post" action="{{ route('posts.update', ['post' => $post]) }}">
    @method('PUT')
    @csrf

    <div class="row justify-content-center">
      <div class="col-sm-7">
        <div class="form-group">
          <label for="title">Título</label>
          <input type="text" name="title" id="title" class="form-control" placeholder="Título" value="{{ $post->title }}">
        </div>

        <div class="form-group">
          <label for="content">Contenido</label>
          <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ $post->content }}</textarea>
        </div>
      </div>

      <div class="col-sm-7 text-center">
        <button class="btn btn-primary btn-block" type="submit">Enviar</button>
      </div>
    </div>
  </form>
@endsection