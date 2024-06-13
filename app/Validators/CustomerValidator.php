<?php

namespace App\Validators;

use App\Exceptions\CustomerExceptions;
use App\Models\User;

class CustomerValidator
{
    public function __construct()
    {
    }

    public function validateUserFromEntity(User $entity): void
    {
        if ($entity instanceof User && auth()->user()?->id !== $entity->getId()) {
            throw CustomerExceptions::differentUserRequestingData();
        }
    }
}
