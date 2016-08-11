@extends('layouts/main')

@section('title', 'blog-title')

@section('content')
    <article>
        <header class="header-post content-centered text-center">
            <figure class="full-background" style="background-image:url(https://d13yacurqjgara.cloudfront.net/users/288987/screenshots/2154354/attachments/395973/elephant-1080p.jpg)"></figure>
            <h1>{{$post->title}}</h1>
        </header>
        <div class="container">
            <content class="editor-content"> {!! $post->content !!}</content>
        </div>
    </article>


@stop