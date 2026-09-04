<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserClients implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isClient = User::where('id', $value)->where('role', User::ROLE_CLIENT)->exists();

        if (!$isClient) {
            $fail('User is not a client');
        }
    }
}
