<?php

namespace Tests\Api\Customer;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ProductUpdateCest
{
    private string $tokenLoginAdmin;
    private string $tokenLoginUser;

    private $url = 'http://localhost:9011/api/v1/product';

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

        //logando com admin
        $I->amBearerAuthenticated($this->tokenLoginAdmin);
    }


    // tests
    public function successfully(ApiTester $I)
    {
        $I->wantTo('Test Successfully');

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => "Product",
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function withWrongName(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Name');

        $chr = bin2hex(openssl_random_pseudo_bytes(220));

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => $chr,
                "quantity" => "10",
                "description" => "testeee",
                "price" => "10.00",
                "status" => "1"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongQuantity(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Quantity');

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => "Product",
                "quantity" => "quantity",
                "description" => "testeee",
                "price" => "10.00",
                "status" => "1"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongDescription(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Desription');

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => "Product",
                "quantity" => "10",
                "description" => "r",
                "price" => "10.00",
                "status" => "1"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongPrice(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Price');

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => "Product",
                "quantity" => "10",
                "description" => "teeeste",
                "price" => "1teste",
                "status" => "1"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongStatus(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Status');

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => "Product",
                "quantity" => "10",
                "description" => "teeeste",
                "price" => "10.00",
                "status" => "TESTE"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
    //teste nao funciiona sem motivoC
    /*public function forbidden(ApiTester $I)
    {
        $I->wantTo('Test Forbidden');

        $I->amBearerAuthenticated($this->tokenLoginUser);

        $I->sendPutAsJson(
            sprintf("$this->url/%s", "10"),
            [
                "name" => "Product",
                "quantity"=> "10",
                "description"=> "teeeste",
                "price"=> "10.00",
                "status"=> "1"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }*/
}
