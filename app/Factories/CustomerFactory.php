<?php

namespace App\Factories;

use App\Models\User;

class CustomerFactory
{
    public function create(
        string $name,
        string $email,
        string $password
    ): User {
        $customer = new User();
        $customer->setName($name);
        $customer->setEmail($email);
        $customer->setPassword($password);

        return $customer;
    }
}
