<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ProductDestroyCest
{
    private $url = "http://localhost:9011/api/v1/product/";
    private string $tokenLoginUser;
    private object $userTest;

    public function _before(ApiTester $I)
    {
        /**
         * @var DatabaseHelper
         */
        $testHelper = app("Tests\TestHelper");

        $this->userTest = $testHelper::generateUserTestData('testUser@email.com');

        $this->tokenLoginUser = $testHelper::login(
            [
                'email' => $this->userTest->email,
                'password' => 'password',
            ],
            $I
        );
    }
    /*
        public function successfully(ApiTester $I)
        {
            $I->wantTo('Test Successfully');

            $I->amBearerAuthenticated($this->tokenLoginUser);

            $I->sendDelete($this->url);

            $I->seeResponseIsJson();
            $I->seeResponseCodeIs(HttpCode::OK);
        }

        public function unhautorized(ApiTester $I)
        {
            $I->wantTo('Test Unhautorized');

            $I->deleteHeader('Authorization');

            $I->sendDelete($this->url);
            $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
         }
            */
}
