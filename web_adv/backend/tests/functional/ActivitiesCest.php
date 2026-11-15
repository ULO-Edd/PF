<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class ActivitiesCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkActivity(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('UserAdmin');
        $I->click('Atividades');
        $I->click('Ver Atividades');
        $I->see('Atividades', 'h1');
        $I->seeInCurrentUrl('/atividade/index');
        $I->see('Aventura');
        $I->see('Ponte Suspensa');
    }

    public function createActivity(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('UserAdmin');
        $I->click('Atividades');
        $I->click('Criar Atividade');
        $I->seeInCurrentUrl('/atividade/create');
        $I->see('Criar Atividade', 'h1');
        $I->selectOption('Atividade[id_tipo_atividade]', 'Aventura');
        $I->fillField('Atividade[descricao]', 'DescricaoAtividadeTeste');
        $I->fillField('Atividade[designacao]', 'DesignacaoTeste');
        $I->fillField('Atividade[lotacao]', '51');
        $I->click('Salvar');
        $I->seeInCurrentUrl('/atividade/index');
        $I->see('DesignacaoTeste');
        $I->seeInDatabase('atividade',
            ['descricao' =>'DescricaoAtividadeTeste'],
            ['designacao' =>'DesignacaoTeste'],
            ['lotacao' =>'51']);
    }

    public function createTipoActivity(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('UserAdmin');
        $I->click('Atividades');
        $I->click('Tipo Atividades');
        //$I->click('Criar Tipo de Atividade');
        $I->fillField('TipoAtividade[tipo]', 'TipoAtividadeTeste');
        $I->click('Salvar');
        $I->see('TipoAtividadeTeste');
        $I->seeInDatabase('tipo_atividade', ['tipo' =>'TipoAtividadeTeste']);
    }

    public function editTipoActivity(FunctionalTester $I)
    {

        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->amOnPage('tipo-atividade/index?idta=3');
        $I->fillField('TipoAtividade[tipo]', 'TipoAtividadeEditada');
        $I->click('Salvar');
        $I->seeInCurrentUrl('/tipo-atividade/index');
        $I->see('TipoAtividadeEditada');
        $I->seeInDatabase('tipo_atividade', ['tipo' =>'TipoAtividadeEditada']);
    }

    public function editActivity(FunctionalTester $I)
    {

        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->amOnPage('/atividade/update?id=3');
        $I->selectOption('Atividade[id_tipo_atividade]', 'Radical');
        $I->fillField('Atividade[descricao]', 'DescricaoAtividadeEditada');
        $I->fillField('Atividade[designacao]', 'DesignacaoAtividadeEditada');
        $I->fillField('Atividade[lotacao]', '52');
        $I->click('Salvar');
        $I->seeInCurrentUrl('/atividade/view?id=3');
        $I->see('Radical');
        $I->see('DescricaoAtividadeEditada');
        $I->see('DesignacaoAtividadeEditada');
        $I->see('52');
        $I->seeInDatabase('atividade',
            ['descricao' =>'DescricaoAtividadeEditada',
            'designacao' =>'DesignacaoAtividadeEditada',
            'lotacao' =>'52']);
    }

}
