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
    public function slug(Request $request)
    {
        if(property_exists($this, 'model')) {
            $slug = $this->checkSlug($request->get('slug'));
            return $this->handleResponse($request, $slug);
        }
    }

    private function checkSlug($slug, $increment = 0)
    {
        $result = $this->model->where('slug', $slug);

        if($result->exists()) {
            return $this->checkSlug($slug.'-'.$increment, $increment++);
        }

        return $slug;
    }
}