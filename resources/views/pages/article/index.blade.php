@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col px-0">
            <div class="grid-wrapper">

                @forelse ($articles as $article)
                    <div class="m-3">
                        <a href="{{ route('articles.detail', ['slug' => $article->slug]) }}">
                            <div class="card shadow-sm m-0" style="min-height: 470px; min-width: 261px;">
                                <div class="d-flex align-items-center justify-content-center">
                                    <img class="card-img-top" src="{{ $article->thumbnail_image }}" alt="thumbnail-image" width="50%">
                                </div>
                                <div class="card-body">
                                    <h6 class="card-title"><b>{{ $article->title }}</b></h6>
                                    <div class="row mt-4" style="font-size: 14px">
                                        <div class="col text-center">
                                            <button class="btn btn-outline-primary btn-block ">Read More</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <h4>Belum ada Artikel</h4>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
