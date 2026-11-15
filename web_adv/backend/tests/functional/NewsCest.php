<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class NewsCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkNews(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Novidades');
        $I->click('Ver Novidades');
        $I->see('Novidades', 'h1');
        $I->seeInCurrentUrl('/news/index');
        $I->see('Novas Atividades');
        $I->see('Verifique as ultimas atividades que abriram recentemente no nosso parque');
    }

    public function createNews(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('BRISA PARK');
        $I->click('Novidades');
        $I->click('Criar Novidades');
        $I->seeInCurrentUrl('/news/create');
        $I->fillField('News[titulo]', 'NovidadeTeste');
        $I->fillField('News[descricao]', 'DescricaoTeste');
        $I->fillField('News[date_expire]', '2023-12-31');
        $I->click('Salvar');
        $I->seeInCurrentUrl('/news/view?id=2');
        $I->see('NovidadeTeste');
        $I->see('DescricaoTeste');
        $I->see('2023-12-31');
        $I->seeInDatabase('news',
            ['titulo' =>'NovidadeTeste',
            'descricao' =>'DescricaoTeste',
            'date_expire' =>'2023-12-31']);
    }
}
