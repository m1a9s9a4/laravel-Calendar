<?php

namespace App\Http\Controllers;

use App\Services\Google;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class LoginController extends Controller
{
    public function index()
    {

    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->scopes(["https://www.googleapis.com/auth/calendar"])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     */
    public function handleProviderCallback(Google $google, Request $request)
    {
        if ($request->has("code")) {
            $accessToken = $google->fetchAccessTokenWithCode($request->get("code"));
            session(['accessToken' => $accessToken]);
            return redirect('/');
        }
        return $this->redirectToProvider();
    }
}
