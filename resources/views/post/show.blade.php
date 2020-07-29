@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-header d-flex justify-content-end">
            <p>Views {{ $counter }}</p>
          </div>
          <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->content }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection