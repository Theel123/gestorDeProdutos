<?php

namespace Tests\Api\Customer;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class ProductStoreCest
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

        $I->sendPOST(
            $this->url,
            [
                "name" => "Product",
                "quantity" => "10",
                "description" => "testeee",
                "price" => "10.00",
                "status" => "1"
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function withWrongName(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Name');

        $I->sendPost(
            $this->url,
            [
                "name" => '',
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

        $I->sendPost(
            $this->url,
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

        $I->sendPost(
            $this->url,
            [
                "name" => "Product",
                "quantity" => "10",
                "description" => "",
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

        $I->sendPost(
            $this->url,
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

        $I->sendPost(
            $this->url,
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
}
