<?php

namespace App\Http\Controllers;

use App\Post;

class FrontController extends Controller
{
    public $postModel;

    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
    }

    public function home()
    {
        $posts = $this->postModel
            ->ofType(Post::TYPE_PUBLISHED)
            ->simplePaginate(10);

        return view('blog.home', compact('posts'));
    }

    public function post($slug)
    {
        $post = $this->postModel->withSlug($slug);

        return view('blog.post', compact('post'));
    }
}
