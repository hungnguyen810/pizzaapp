<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\User\Controller;
use ApiResponse;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client as PassportClient;
use League\Flysystem\Exception;

class TokenController extends Controller
{
    protected $oauthRoute;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {

    }

    public function setOathRoute() {
        $this->oauthRoute = [
            'authorize' => '/oauth/authorize'
        ];
    }

    /**
     * Grant token from Password
     *
     * @param \GuzzleHttp\Client $http
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function grantPassword(HttpClient $http, Request $request) {

        $passportClient = PassportClient::where('password_client', true)
                                        ->where('revoked', false)
                                        ->first();

        if (!$passportClient) return ApiResponse::errorInternal('response.no_oauth_client', 500);

        $response = $http->post(env('APP_URL') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $passportClient->id,//env('OAUTH_CLIENT_ID'),
                'client_secret' => $passportClient->secret,//env('OAUTH_CLIENT_SECRET'),
                'username' => $request->username, // User email
                'password' => $request->password, //Clear password
                'scope' => '*',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * TODO: Remove hard code
     *
     * @return string
     */
    public function personalToken() {
        $user = \App\Models\User::find(1);

        // Creating a token without scopes...
        $token = $user->createToken('Token Name')->accessToken;

        return response()->json(['token' => $token]);

    }

}
