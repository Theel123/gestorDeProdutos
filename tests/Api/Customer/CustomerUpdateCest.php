<?php

namespace Tests\Api;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class CustomerUpdateCest
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

        $I->sendPut(sprintf("$this->url/%s", "11"));

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function withWrongEmail(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Email');


        $I->sendPut(sprintf("$this->url/%s/%s", "11", '?email=emailPorEscrito'));

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongName(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Name');

        $chr = bin2hex(openssl_random_pseudo_bytes(255));
        $I->sendPut(sprintf("$this->url/%s/%s", "11", "?name=$chr"));

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongPassword(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Password');

        $I->sendPut(sprintf("$this->url/%s/%s", "11", "?password=12345"));

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function unhautorized(ApiTester $I)
    {
        $I->wantTo('Test Unhautorized');

        $I->deleteHeader('Authorization');

        $I->sendGet(sprintf("$this->url/%s", '11'));

        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function ifUserIsAdminAccessingOtherUsers(ApiTester $I)
    {
        $I->wantTo('Test If User Is Admin Accessing Other Users');

        $I->sendPut(sprintf("$this->url/%s/%s", "11", "?password=123465"));

        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function ifUserComumAccessingAnotherUser(ApiTester $I)
    {
        $I->wantTo('Test User Comum Accessing Another User');

        $I->amBearerAuthenticated($this->tokenLoginUser);

        $I->sendPut(sprintf("$this->url/%s/%s", "9", "?password=123"));

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
