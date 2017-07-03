<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Pagination\Paginator;

class FrontController extends Controller
{
    /**
     * Model containing posts
     * TODO: refactor to model maybe?
     *
     * @var Post
     */
    public $postModel;

    /**
     * FrontController constructor.
     *
     * @param Post $postModel
     */
    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
    }

    /**
     * show homepage or index page of blog
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $posts = $this->postModel
            ->ofType(Post::TYPE_PUBLISHED)
            ->simplePaginate(10);

        return view('blog.home', compact('posts'));
    }

    /**
     * Show page with post content based on slug result.
     *
     * @param $slug
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function post($slug)
    {
        $post = $this->postModel->withSlug($slug);

        return view('blog.post', compact('post'));
    }
}
