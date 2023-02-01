<?php

namespace App\Models\Users\Services;

use App\Http\Resources\UserResource;
use App\Jobs\SendWelcomeMessageJob;
use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Users\Services\Interfaces\UserServiceInterface;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * @method hashed(mixed $password)
 */
class UserService implements UserServiceInterface
{
    use HttpResponses;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(mixed $email, mixed $password,  mixed $phone): array|string
    {

        if (Auth::check()) {
            return $this->error('', 403, 'User already logged in!');
        }

        if (Auth::attempt(
                [
                    'email' => $email,
                    'password' => $password,
                ],
            ) || Auth::attempt(
                [
                    'phone' => $phone,
                    'password' => $password,
                ])) {

            return [
                'token' => Auth::user()->createToken('user-token')->plainTextToken
            ];
        }
        return $this->error('', 401, 'Invalid login details');
    }

    public function register(array $array, bool $auth = false): UserResource
    {

        $user = $this->userRepository->createUser([
            'name' => $array['name'],
            'email' => $array['email'],
            'phone' => $array['phone'],
            'password' => Hash::make($array['password']),
            'terms' => $array['terms'],
        ]);

        if ($user->email) {
            SendWelcomeMessageJob::dispatch($user)->delay(now()->addSeconds(2));
        }

            $user->token = $user->createToken('user-token')->plainTextToken;
        return new UserResource($user);
    }

    public function getLoggedUser(): array|UserResource
    {
        $user = \auth('sanctum')->user();

        if (!$user) {
            return [];
        }
        return new UserResource($user);
    }
}

