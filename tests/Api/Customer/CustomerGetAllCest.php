<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class CustomerGetAllCest
{
    private $url = "http://localhost:9011/api/v1/customers/";
    private string $tokenLoginAdmin;
    private string $tokenLoginUser;

    public function _before(ApiTester $I)
    {
        /**
         * @var DatabaseHelper
         */
        $testHelper = app("Tests\TestHelper");

        $this->tokenLoginAdmin = $testHelper::login(
            [
                'email' => 'admin@cellar.com',
                'password' => 'password',
            ],
            $I
        );


        $this->tokenLoginUser = $testHelper::login(
            [
                'email' => 'user@cellar.com',
                'password' => 'password',
            ],
            $I
        );
    }

    public function successfully(ApiTester $I)
    {
        $I->wantTo('Test Successfully');

        $I->amBearerAuthenticated($this->tokenLoginAdmin);

        $I->sendGet($this->url);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function unhautorized(ApiTester $I)
    {
        $I->wantTo('Test Unhautorized');

        $I->deleteHeader('Authorization');

        $I->sendGet($this->url);

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function forbidden(ApiTester $I)
    {
        $I->wantTo('Test Forbidden');

        $I->amBearerAuthenticated($this->tokenLoginUser);

        $I->sendGet($this->url);

        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
