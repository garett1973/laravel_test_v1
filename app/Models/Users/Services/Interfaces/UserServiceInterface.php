<?php

namespace App\Models\Users\Services\Interfaces;

interface UserServiceInterface
{

    public function login(mixed $email, mixed $password, mixed $phone);

    public function register(array $array, bool $auth = false);
}
