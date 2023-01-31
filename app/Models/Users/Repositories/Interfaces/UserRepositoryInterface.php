<?php

namespace App\Models\Users\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function createUser(array $data);

    public function getUserByEmail(mixed $email);
}
