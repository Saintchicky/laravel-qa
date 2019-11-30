<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function getToken (Request $request)
    {
        // on renseigne 5 items: grant_type, client_id, client_secret, username, password
        // on retrouve ces infos en faisant : php artisan passport:install
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => '5VsvAzZ77ZqoKexQ5dHD5L0ECmLHugSQRFSUl1uB',
            'username' => $request->username,
            'password' => $request->password,
        ]);
       $requestToken = Request::create(env('APP_URL').'/oauth/token','post');
       // Permet avec la méthode dispatch de retourner un objet réponse qu'on pourra assigner
       $reponse = Route::dispatch($requestToken);
       return $reponse;

    }
}
