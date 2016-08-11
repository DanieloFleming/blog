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

    /**
     * PostController constructor.
     *
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Show index page with post bases on "type" parameter.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $postType = $this->types[$request->get('type')];

        $data = $this->model->ofType($postType)->paginate(10);

        return view('cms.list', compact('data', 'itemCounts'));
    }

    /**
     * Show create post editor.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = $this->model;

        return view('cms.editor', compact('data'));
    }

    /**
     * Open post editor with post bases on given id.
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $data = $this->model->findOrNew($id);

        return view('cms.editor', compact('data'));
    }

    /**
     * handle saving the post into the database.
     * TODO : create PostCreateRequest for field validations.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $postData = $request->except('_token');

        $model = $this->model->findOrNew($request->get('id'));

        $model->fill($postData);

        $model->save();

        return $this->handleResponse($request, $model);
    }

    /**
     * Handle removing the post from the database
     *
     * @param Request $request
     * @param null $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request, $id = null) {
        $this->model->destroy($id);

        return $this->handleResponse($request, $id);
    }

    /**
     * Return response based on $request->type
     * TODO: remove ajax check and create seperate Controller for this.
     *
     * @param $request
     * @param $response
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function handleResponse($request, $response)
    {
        return ($request->ajax())
            ? response()->json($response)
            : redirect($this->redirectTo);
    }
}