@extends('layouts/main')

@section('title', 'blog-title')

@section('content')
    <div class="container">

        <header class="header-home text-center">
            <h1>D.<span class="welcome-text">
                Just a blog to play with php and other stuff...
            </span>
            </h1>
        </header>

        @foreach($posts as $post)
            <article class="article-home">
                <a href="post/{{ $post->slug }}"><h1>{{ $post->title }}</h1></a>
                <span>{{$post->published_at}}</span>
                <div class="editor-content text-left"> {!! $post->excerpt() !!}</div>
                <a class="read-more-btn" href="post/{{ $post->slug }}">Read More</a>
            </article>
        @endforeach

        {{ $posts->render() }}
    </div>
@stop