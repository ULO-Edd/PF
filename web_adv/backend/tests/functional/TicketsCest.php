<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class TicketsCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkTicket(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Bilhetes');
        $I->see('Bilhetes', 'h1');
        $I->seeInCurrentUrl('/ticket/index');
        $I->click('Ver Ticket »');
        $I->seeInCurrentUrl('/ticket/view?id=1');
        $I->see('user');
        $I->see('Recreio');
        $I->see('Montanha Russa');
    }

}
