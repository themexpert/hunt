<?php

namespace Hunt\Http\Controllers\Api\Auth;

use Auth;
use Hunt\User;
use Socialite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/refresh';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // determine email activation
        $user = User::whereEmail($request->input('email'))->first();

        if(!is_null($user) and ($user->is_active == 0)) {
            if($request->wantsJson()) {
                return response()->json([
                    'message' => 'Confirm your email address'
                ], 403);
            }

            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->with(['message' => 'Confirm your email address']);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return response()->json([
                '_token' => csrf_token(),
                'message' => 'Success'
            ]);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if($request->wantsJson()) {
            return response()->json([
                'message' => 'Email or password does not match'
            ], 403);
        }
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $providerUser = Socialite::driver('google')->user();

        $user = User::whereEmail($providerUser->getEmail())->first();

        if(is_null($user)) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'is_active' => 1,
                'token' => ''
            ]);
        }

        Auth::login($user);

        //return redirect()->intended($this->redirectPath());
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('refresh');
    }
}
