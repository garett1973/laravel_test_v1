<?php

namespace App\Models\Users\Repositories;

use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Users\User;

class UserRepository implements UserRepositoryInterface
{
    public $user = User::class;

    /**
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data)
    {
        return $this->user::create($data);
    }

    /**
     * @param mixed $email
     * @return mixed
     */
    public function getUserByEmail(mixed $email)
    {
        return $this->user::where('email', $email)->first();
    }

    /**
     * @param mixed $phone
     * @return mixed
     */
    public function getUserByPhone(mixed $phone)
    {
        return $this->user::where('phone', $phone)->first();
    }
}
