<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ProductGetTestCest
{
    private $url = "http://localhost:9011/api/v1/product";
    private string $tokenLoginAdmin;

    // tests

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

        $I->amBearerAuthenticated($this->tokenLoginAdmin);
    }

    public function successfully(ApiTester $I)
    {
        $I->wantTo('Test Successfully');

        $I->sendGet(sprintf("$this->url/%s", '1'));

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function unhautorized(ApiTester $I)
    {
        $I->wantTo('Test Unhautorized');

        $I->deleteHeader('Authorization');

        $I->sendGet(sprintf("$this->url/%s", '1'));

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }
}
