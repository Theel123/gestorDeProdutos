<?php

namespace Tests\Api\Customer;

use Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class CustomerStoreCest
{
    private $url = 'http://localhost:9011/api/v1/customer/store';

    public function _before(ApiTester $I)
    {
    }

    // tests
    public function successfully(ApiTester $I)
    {
        $I->wantTo('Test Successfully');

        $chr = bin2hex(openssl_random_pseudo_bytes(5));

        $I->sendPOST(
            $this->url,
            [
                'name' => 'testeName',
                'email' => "$chr@hotmail.com",
                'password' => 'password',
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function withWrongEmail(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Email');

        $I->sendPost(
            $this->url,
            [
                'name' => 'testeName',
                'password' => '123456',
                'email' => 'emailPorEscrito'
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongName(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Name');

        $chr = bin2hex(openssl_random_pseudo_bytes(256));

        $I->sendPost(
            $this->url,
            [
                'name' => $chr,
                'email' => "teste2@email.com",
                'password' => '123456',
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }

    public function withWrongPassword(ApiTester $I)
    {
        $I->wantTo('Test With Wrong Password');

        $I->sendPost(
            $this->url,
            [
                'name' => 'testeName2',
                'email' => "@email.com",
                'password' => '12345',
            ]
        );

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
    }
}
