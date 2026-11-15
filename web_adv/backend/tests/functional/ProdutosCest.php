<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class ProdutosCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function createProduto(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Produtos');
        $I->see('Produtos', 'h1');
        $I->seeInCurrentUrl('/produto/index');
        $I->click('Criar um Produto');
        $I->seeInCurrentUrl('/produto/create');
        $I->fillField('Produto[descricao]', 'NomeProduto');
        $I->fillField('Produto[quantidade]', '11');
        $I->fillField('Produto[points]', '13');
        $I->click('Salvar');
        $I->seeInCurrentUrl('/produto/index');
        $I->see('NomeProduto');
        $I->see('11');
        $I->see('13');
        $I->seeInDatabase('produto',
            ['descricao' =>'NomeProduto',
            'quantidade' =>'11',
            'points' =>'13']);
    }

}
