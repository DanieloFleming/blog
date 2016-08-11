<?php

namespace App\Http\Controllers\Cms;

use \App\Http\Controllers\Controller;

use \App\Http\Controllers\Traits\UniqueSlug;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller {

    use UniqueSlug;

    const TYPE_PUBLISHED = 'published';
    const TYPE_DRAFT = 'draft';
    const TYPE_DEFAULT = null;

    public $types = [
        self::TYPE_PUBLISHED => Post::TYPE_PUBLISHED,
        self::TYPE_DEFAULT => Post::TYPE_PUBLISHED,
        self::TYPE_DRAFT => Post::TYPE_DRAFT
    ];

    public $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        $postType = $this->types[$request->get('type')];

        $data = $this->model->ofType($postType)->paginate(10);

        return view('cms.list', compact('data', 'itemCounts'));
    }

    public function create()
    {
        $data = $this->model;

        return view('cms.editor', compact('data'));
    }

    public function edit($id) {
        $data = $this->model->findOrNew($id);

        return view('cms.editor', compact('data'));
    }

    public function store(Request $request)
    {
        $postData = $request->except('_token');

        $model = $this->model->findOrNew($request->get('id'));

        $model->fill($postData);

        $model->save();

        return $this->handleResponse($request, $model);
    }

    public function destroy(Request $request, $id = null) {
        $this->model->destroy($id);

        return $this->handleResponse($request, $id);
    }

    protected function handleResponse($request, $response)
    {
        return ($request->ajax())
            ? response()->json($response)
            : redirect($this->redirectTo);
    }
}