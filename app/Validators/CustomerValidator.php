<?php

namespace App\Validators;

use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\CustomerExceptions;
use Illuminate\Support\Facades\Validator;

class CustomerValidator
{
    public function __construct()
    {
    }

    public function validateUserFromEntity(User $entity)
    {
        if(!Gate::allows('manage-customer') && auth()->user()->id === $entity->getId()) {
            return true;
        }

        if (Gate::allows('manage-customer')) {
            return true;
        }

        if (auth()->user()?->id !== $entity->getId()) {
            throw CustomerExceptions::differentUserRequestingData();
        }
    }
}
