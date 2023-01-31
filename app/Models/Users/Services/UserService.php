<?php

namespace App\Models\Users\Services;

use App\Http\Resources\UserResource;
use App\Jobs\SendWelcomeNotificationJob;
use App\Models\Users\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\Users\Services\Interfaces\UserServiceInterface;
use App\Traits\HttpResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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

    public function login(mixed $email, mixed $password, mixed $phone)
    {
        if ($this->getLoggedUser()) {
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
            $token = Auth::user()->createToken('user-token');
            return [
                'token' => $token->plainTextToken
            ];
        }
        return $this->error('', 401, 'Invalid login details');
    }

    public function register(array $array, bool $auth = false): array|UserResource
    {

        $user = $this->userRepository->createUser([
            'name' => $array['name'],
            'email' => $array['email'],
            'phone' => $array['phone'],
            'password' => Hash::make($array['password']),
            'terms' => $array['terms'],
        ]);

        if ($user->email) {
//            event(new Registered($user));
            SendWelcomeNotificationJob::dispatch($user)->delay(now()->addSeconds(20));
        }

        if ($auth && $user) {
            $token = $user->createToken('user-token');
            return [
                'user_id' => $user->id,
                'token' => $token->plainTextToken
            ];
        }
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
