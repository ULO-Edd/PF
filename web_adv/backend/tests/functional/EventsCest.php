<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class EventsCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEvents(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Eventos');
        $I->click('Ver Eventos');
        $I->see('Eventos', 'h1');
        $I->seeInCurrentUrl('/evento/index');
        $I->see('Evento de Natal');
        $I->see('Lorem ipsum dolor sit amet');
    }

    public function createEvents(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Eventos');
        $I->click('Criar Eventos');
        $I->seeInCurrentUrl('/evento/create');
        $I->fillField('Evento[designacao]', 'EventoTeste');
        $I->fillField('Evento[descricao]', 'DescricaoTeste');
        $I->fillField('Evento[data_inicio]', '2023-01-01');
        $I->fillField('Evento[data_conclusao]', '2023-03-01');
        $I->fillField('Evento[pontos_participacao]', '123');
        $I->click('Salvar');
        $I->seeInCurrentUrl('/evento/index');
        $I->see('EventoTeste');
        $I->see('DescricaoTeste');
        $I->see('2023-01-01');
        $I->see('2023-03-01');
        $I->seeInDatabase('evento',
            ['designacao' =>'EventoTeste',
            'descricao' =>'DescricaoTeste',
            'data_inicio' =>'2023-01-01',
            'data_conclusao' =>'2023-03-01',
            'pontos_participacao' =>'123']);
    }
}
