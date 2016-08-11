<?php
/**
 * Created by PhpStorm.
 * User: fleming
 * Date: 8/11/16
 * Time: 1:09 PM
 */

namespace App\Http\Controllers\Traits;


use Illuminate\Http\Request;

trait UniqueSlug
{
    /**
     * Check if Class container Slug has required field before doing anything
     * TODO: implement Exceptions.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function slug(Request $request)
    {
        if(property_exists($this, 'model')) {
            $slug = $this->checkSlug($request->get('slug'));
            return $this->handleResponse($request, $slug);
        }
    }

    /**
     * Recursive check if the slug is unique and make unique if not.
     *
     * @param $slug
     * @param int $increment
     * @return mixed
     */
    private function checkSlug($slug, $increment = 0)
    {
        $result = $this->model->where('slug', $slug);

        if($result->exists()) {
            return $this->checkSlug($slug.'-'.$increment, $increment++);
        }

        return $slug;
    }
}