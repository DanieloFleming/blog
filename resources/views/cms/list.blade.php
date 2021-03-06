@extends('cms.layouts.main')
@section('content')
    <?php
        $route = app('request')->input('type');
            $routeParam = (empty($route)) ? 'request' : $route;
    ?>
    <ul class="list-horizontal action-list">
        <li>
            <a href="/cms/post?type=published" class="action-link action-publish">
                show published
            </a>
        </li>
        <li>
            <a href="/cms/post?type=draft" class="action-link action-draft">
                show drafts
            </a>
        </li>
    </ul>
    <div class="container" style="margin-top: 40px">

        @foreach($data as $post)
            <article style="width: 100%; margin:10px;padding:20px;border-bottom: 1px solid lightgrey; position: relative;">
                <a href="/cms/post/edit/{{$post->id}}"><h3>{{ $post->title }}</h3></a>
                <span style="font-size: 12px; margin-top:5px;"><i>{{$post->published()}}</i></span>
                <ul class="list-horizontal" style="text-align: right; font-size:14px; position: absolute; top:50%; right:10px; transform: translateY(-50%)">
                    <li><a href="/cms/post/edit/{{$post->id}}">edit</a> | </li>
                    <li><a href="/cms/post/delete/{{$post->id}}">delete</a></li>
                </ul>
            </article>
        @endforeach
    </div>
@stop