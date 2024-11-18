<?php

namespace App\Repositories\Interfaces;

use App\Models\PatientCondition;
use App\Models\User;

interface UserAuthRepositoryInterface
{
    public function register(array $data): User;

    public function login(array $credentials);


}
