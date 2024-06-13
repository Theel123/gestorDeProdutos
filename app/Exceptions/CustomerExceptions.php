<?php

namespace App\Exceptions;

class CustomerExceptions extends \Exception
{
    public static function emailAlreadyRegistered(): self
    {
        return new self('Email já cadastrado !');
    }

    public static function missingFields(): self
    {
        return new self('É necessário login e senha para realizar o login !');
    }

    public static function unauthorized(): self
    {
        return new self('Login ou senha incorretos !');
    }
    public static function customerHasVerifiedEmail(): self
    {
        return new self('Usuario já possui email verificado');
    }

    public static function differentUserRequestingData(): self
    {
        return new self('O usuário logado não é o mesmo usuário necessário para completar a requisição.', 401);
    }

    public static function userNotFound(): self
    {
        return new self('O usuário informado não foi encontrado.', 400);
    }

    public static function userIsAlreadyActive(): self
    {
        return new self('Usuário já encontra-se ativo !', 400);
    }
}
