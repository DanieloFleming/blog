<?php
use \Illuminate\Database\Eloquent\Model;
use \App\Http\Requests\Request;
class People extends Model {

    public static  $validation_rules = [
        'username'  => 'string|max:45|unique',
        'email'     => 'email',
        'password'  => 'min:8'
    ];

    public function beforeSave($postWaarde)
    {
        $result = $this->validate($postWaarde, self::$validation_rules);

        if($result->fails()) {
            return $result;
        }

        $id = $this->attributes['password'];
    }
}


class PeopleController extends \App\Http\Controllers\Controller
{

    public function create(Request $request)
    {
        $result = $this->validate($request, People::$validation_rules);

        if(!$result->fails()) {
            People::create($request->except('_token'));
        }

        $result = People::create($request->except('_token'));

        if($result !== true) {
            //doe iets
        }
    }
}