<?php

namespace App\Http\Controllers\Api;

use App\Helpers\KHolderHelpers;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Utils\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $credentials = $request->all();
        if (App::environment('local')) {
            $user = $this->userRepository->findByEmail($credentials['email']);
            if ($user) {
                Log::info('co thong tin');
                Auth::login($user, $credentials['rememberMe']);
                return response()->json([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                Log::info('chua co thong tin');
                $userInformation = [
                    "email" => $credentials['email'],
                    "domain_id" => 1
                ];
                Log::info('userInformation:',['userInformation' => $userInformation]);
                $user = $this->userRepository->create($userInformation);
                Auth::login($user, $credentials['rememberMe']);
                return response()->json([
                    'success' => true,
                    'data' => $user
                ]);
            }
        }
        $response = json_decode((new \App\Helpers\KHolderHelpers)->sendLoginRequest($credentials));
        if ($response->message === 'failed') {
            Log::info('incorrect password');
            return response()->json($response);
        } else {
            if ($response->message === 'success') {
                $user = $this->userRepository->findByEmail($credentials['email']);
                if ($user) {
                    Log::info('co thong tin');
                    Auth::login($user, $credentials['rememberMe']);
                    return response()->json([
                        'success' => true,
                        'data' => $user
                    ]);
                } else {
                    Log::info('chua co thong tin');
                    $token = $response->access_token;
                    $response = json_decode((new \App\Helpers\KHolderHelpers)->getUserInformation($token));
                    $userInformation = [
                        "name" => $response->user->name,
                        "email" => $credentials['email'],
                        "access_token" => $token
                    ];
                    $user = $this->userRepository->create($userInformation);
                    Auth::login($user, $credentials['rememberMe']);
                    return response()->json([
                        'success' => true,
                        'data' => $user
                    ]);
                }
            }
        }
    }

    public function user(Request $request)
    {
        Log::info('co thong tin user');
        return response()->json(new JsonResponse(Auth::user()), Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return response()->json((new JsonResponse())->success([]), Response::HTTP_OK);
    }
}
