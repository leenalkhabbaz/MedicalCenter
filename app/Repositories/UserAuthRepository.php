<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserAuthRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserAuthRepository implements UserAuthRepositoryInterface
{
    public function register(array $data): User
    {
        \DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            \DB::commit();
            return $user;
        } catch (\Illuminate\Database\QueryException $e) {
            \DB::rollBack();
            if ($e->getCode() == 23000) {
                // Customize the message to indicate user_name conflict
                throw new \Exception('The user_name has already been taken.');
            }
            \Log::error('Registration failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function login(array $credentials)
    {
        $user = User::where('user_name', $credentials['user_name'])->first();

        if (!$user) {
            throw new ModelNotFoundException("the account is not exist.");
        }

        if (Hash::check($credentials['password'], $user->password)) {
            return $user->createToken('authToken')->plainTextToken;
        }

        return false;
    }

}
