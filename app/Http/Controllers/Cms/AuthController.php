<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public $redirectTo = 'cms/post';

    public $loginPage = 'cms.auth.login';

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        return view($this->loginPage);
    }

    /**
     *
     * @param LoginUserRequest $requests
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postLogin(LoginUserRequest $requests)
    {
        $isRemembered = $requests->only('remember');
        $credentials = $requests->only('username', 'password');

        if(Auth::attempt($credentials, $isRemembered)) {
            return redirect($this->redirectTo);
        }

        return $this->getLogin()->withErrors(['invalid' => 'no access']);
    }

    /**
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        Auth::logout();

        return back();
    }
}
