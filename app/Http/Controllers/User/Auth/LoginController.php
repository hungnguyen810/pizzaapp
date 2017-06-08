<?php

namespace App\Http\Controllers\User\Auth;

use ApiResponse;
use App\Http\Controllers\User\Controller;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use GuzzleHttp\Client as HttpClient;
use Lang;
use Laravel\Passport\Client as PassportClient;

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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request, HttpClient $http) {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->credentials($request);

        if ($this->guard()->attempt($credentials, $request->has('remember'))) {

            // Procceed the login if request from an API call
            if ($request->ajax() || $request->wantsJson()) {
                $passportClient = PassportClient::where('password_client', true)
                                                ->where('revoked', false)
                                                ->first();

                if (!$passportClient) return ApiResponse::errorInternal('response.no_oauth_client', 500);

                $response = $http->post(env('APP_URL') . '/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => $passportClient->id,
                        'client_secret' => $passportClient->secret,
                        'username' => $request->email,
                        'password' => $request->password,
                        'scope' => '*',
                    ],
                ]);

                $tokenInfo = json_decode($response->getBody());

                // Remove this after verify that
                // refreshing token function works
                return ApiResponse::success('Verified identity', [
                    'token_type' => $tokenInfo->token_type,
                    'expires_in' => $tokenInfo->expires_in,
                    'access_token' => $tokenInfo->access_token
                ]);

            }

            return $this->sendLoginResponse($request);
        }

        if (! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendFailedLoginResponse(Request $request) {

        if ($request->ajax() || $request->wantsJson())
            return ApiResponse::error(Lang::get('auth.failed'), [], 401);

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('user');
    }
}
