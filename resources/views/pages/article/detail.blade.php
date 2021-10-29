@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <small class="mb-4">
                <a href="{{ route('articles.all') }}">Articles</a>
            </small>

            <h4 class="mt-4">{{ $article->title }}</h4>

            <img src="{{ $article->thumbnail_image }}" alt="thumbnail">

            <div class="mt-4">
                {!! $article->content !!}
            </div>

            <div class="mt-2">
                Like: {{ $article->like->count() }}
                <a href="{{ route('articles.like.store', ['slug' => $article->slug]) }}">
                    <button class="btn btn-primary btn-sm">Like</button>
                </a>
            </div>

            <div class="mt-5 mb-5">
                <h5>Comments</h5>
            </div>

        </div>
    </div>
</div>
@endsection
