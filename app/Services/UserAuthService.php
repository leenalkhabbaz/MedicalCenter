<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserAuthRepositoryInterface;

class UserAuthService
{
    private UserAuthRepositoryInterface $userAuthRepository;

    public function __construct(UserAuthRepositoryInterface $userAuthRepository)
    {
        $this->userAuthRepository = $userAuthRepository;
    }

    public function register(array $data): User
    {
        if (!isset($data['language'])) {
            $data['language'] = 'ar';
        }
        return $this->userAuthRepository->register($data);
    }
    public function login(array $credentials): bool|string
    {
        return $this->userAuthRepository->login($credentials);
    }


}
