<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class CustomerGetTestCest
{
    private $url = "http://localhost:9011/api/v1/customer";
    private string $tokenLoginAdmin;
    private string $tokenLoginUser;

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

        $this->tokenLoginUser = $testHelper::login(
            [
                'email' => 'user@cellar.com',
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

    public function ifUserIsAdminAccessingOtherUsers(ApiTester $I)
    {
        $I->wantTo('Test If User Is Admin Accessing Other Users');

        $I->sendGet(sprintf("$this->url/%s", '1'));

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function ifUserComumAccessingAnotherUser(ApiTester $I)
    {
        $I->wantTo('Test User Comum Accessing Another User');

        $I->amBearerAuthenticated($this->tokenLoginUser);

        $I->sendGet(sprintf("$this->url/%s", '1'));

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
