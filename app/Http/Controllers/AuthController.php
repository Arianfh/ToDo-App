<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'password'
        ]);

        $result = ['status' => 201];

        try {
            $result['data'] = $this->authService->addUser($data);
        } catch (Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only([
            'email',
            'password'
        ]);

        $token = $this->authService->authenticate($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token_access' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() *60,
        ]);
    }

    public function info()
    {
        return response()->json($this->authService->infoUser());
    }

    public function logout()
    {
        $this->authService->logout();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully logged out'
        ], 200);
    }
}
