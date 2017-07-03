<?php

namespace App\Http\Controllers\Cms;

use \App\Http\Controllers\Controller;

use \App\Http\Controllers\Traits\UniqueSlug;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller {


    const TYPE_PUBLISHED = 'published';
    const TYPE_DRAFT = 'draft';
    const TYPE_DEFAULT = null;

    public $types = [
        self::TYPE_PUBLISHED => Post::TYPE_PUBLISHED,
        self::TYPE_DEFAULT => Post::TYPE_PUBLISHED,
        self::TYPE_DRAFT => Post::TYPE_DRAFT
    ];

    /**
     * Model for the controller.
     *
     * @var Post
     */
    public $model;

    /**
     * redirect url.
     *
     * @var string
     */
    public $redirectTo = 'cms/post';

    /**
     * Trait used for checking and creating unique slugs
     */
    use UniqueSlug;

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
     * Show post-editor using empty model as simplified null object pattern.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $data = $this->model;

        return view('cms.editor', compact('data'));
    }

    /**
     * Open post-editor with post bases on given id.
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
        $model = $this->model->findOrNew($request->get('id'));

        $postData = $request->except('_token');

        $model->fill($postData)->save();

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
     * TODO: remove ajax check and create separate (Api)Controller for this.
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