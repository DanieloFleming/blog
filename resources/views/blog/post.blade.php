@extends('layouts/main')

@section('title', 'blog-title')

@section('content')
    <article>
        <header class="header-post content-centered text-center">
            <figure class="full-background" style="background-image:url(https://static.pexels.com/photos/9574/pexels-photo.jpeg)"></figure>
            <h1>{{$post->title}}</h1>
        </header>
        <div class="container">
            <content class="editor-content"> {!! $post->content !!}</content>
        </div>
    </article>

    <ul class="post-pager">
        <li class="previous">
            @if($post->previous())
                <span>↜ previous post</span>
                <a href="/post/{{$post->previous()->slug}}">{{$post->previous()->title}}</a>
            @endif
        </li>
        <li class="divider">

        </li>
        <li class="next">
            @if($post->next())
                <span>next post ↝</span>
                <a href="/post/{{$post->next()->slug}}">{{$post->next()->title}}</a>
            @endif
        </li>
    </ul>
@stop