<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class SugestionsCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkSugestions(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Sugestões');
        $I->click('Ver Sugestões');
        $I->see('Sugestões', 'h1');
        $I->seeInCurrentUrl('/report/index');
        //$I->see('Congratulação');
        $I->see('Mensagem de congratulação');
    }

    public function createTopicoSugestion(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Sugestões');
        $I->click('Tópicos de Sugestões');
        $I->see('Tópico de Sugestões', 'h1');
        $I->seeInCurrentUrl('/topico-report/index');
        $I->fillField('TopicoReport[topico]', 'TipoTopicoTeste');
        $I->click('Salvar');
        $I->see('TipoTopicoTeste');
        $I->seeInDatabase('topico_report', ['topico' =>'TipoTopicoTeste']);
    }
}
