<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class LojaCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkLoja(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Loja');
        $I->seeInCurrentUrl('/loja/view');
        $I->see('Loja de Lembranças', 'h1');
        $I->see('Camaleao');
    }

    public function editNomeLoja(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Loja');
        $I->seeInCurrentUrl('/loja/view');
        $I->see('Loja de Lembranças', 'h1');
        $I->fillField('Loja[designacao]', 'Nome Loja Editado');
        $I->click('Salvar');
        $I->see('Nome Loja Editado', 'h1');
        $I->seeInDatabase('loja', ['designacao' =>'Nome Loja Editado']);
    }

}
