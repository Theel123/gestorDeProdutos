<?php

namespace Tests;

use App\Models\User;
use Tests\Support\ApiTester;

class TestHelper
{
    public const TEST_ADMIN_USER = [
        'email' => 'admin@cellar.com',
        'password' => 'password',
    ];

    public const TEST_USER = [
        'email' => 'user@cellar.com',
        'password' => 'password',
    ];

    /**
     * @var \ApiTester
     */
    protected $tester;


    public static function generateUserTestData(string $userEmail): User
    {
        $user = new User();

        $user->setEmail($userEmail);
        $user->setPassword('password');
        $user->setIsAdmin('Yes');

        $user->markEmailAsVerified();
        $user->save();

        return $user;
    }

    public static function login(array $credentials, ApiTester $I): string
    {
        $token = $I->grabDataFromResponseByJsonPath(
            '$.item',
            $I->sendPOST(
                'http://localhost:9011/api/v1/login',
                [
                    'email' => $credentials['email'],
                    'password' => $credentials['password'],
                ]
            )
        );

        return (string) $token[0];
    }
}
