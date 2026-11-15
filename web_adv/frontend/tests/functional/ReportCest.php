<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class ReportCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkReportSubmission(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Login');
        $I->click('Login');
        $I->seeInCurrentUrl('/site/login');
        $I->submitForm('#login-form', $this->formParams('User1', 'useruser'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('Logout');
        $I->click('Sugestões');
        $I->amOnPage('/reports/create');
        $I->see('Criar Sugestão', 'h1');
        $I->selectOption('Reports[id_topico]', '1');
        $I->fillField('Reports[descricao]', 'Mensagem de congratulacao!');
        $I->click('Guardar');
        $I->see('Agradeçemos pela sua sugestão');
        $I->seeInDatabase('reports', ['descricao' =>'Mensagem de congratulacao!']);
    }
}