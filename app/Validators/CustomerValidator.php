<?php

namespace App\Validators;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Exceptions\CustomerExceptions;
use Illuminate\Support\Facades\Validator;

class CustomerValidator
{
    public function validateUserFromEntity(User $entity)
    {
        if(!Gate::allows('manage-customer')
            && auth()->user()->id === $entity->getId()
        ) {
            return true;
        }

        if (Gate::allows('manage-customer')) {
            return true;
        }

        if (auth()->user()?->id !== $entity->getId()) {
            throw CustomerExceptions::differentUserRequestingData();
        }
    }

    public function validateStoreUpdateRequest(array $request, string $method = '')
    {
        $method === 'store' ? 'store' : 'update';
        $typeRequired = $method === 'store' ? 'required' : 'nullable';

        $validator = Validator::make($request, [
            'name' => [$typeRequired, 'string', 'min:3', 'max:255'],
            'email' => [$typeRequired, 'email', 'unique:users'],
            'password' => [$typeRequired, 'min:6', 'max:15'],
        ]);

        return $validator->fails() === true ? throw new Exception($validator->errors()) : false;
    }
}
