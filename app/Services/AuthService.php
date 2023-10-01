<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use MongoDB\Exception\InvalidArgumentException;

class AuthService 
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function addUser($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $userId = $this->authRepository->create($data);
        return $userId;
    }

    public function authenticate($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $token = Auth::attempt($data);
        return $token;
    }

    public function infoUser()
    {
        $user = Auth::user();
        return $user;
    }

    public function logout()
    {
        $user = Auth::logout();
        return $user;
    }
}