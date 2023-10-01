<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create($data)
    {
        $addUser = new $this->user;

        $addUser->name = $data['name'];
        $addUser->email = $data['email'];
        $addUser->password = bcrypt($data['password']);

        $addUser->save();
        return $addUser->fresh();
    }
}