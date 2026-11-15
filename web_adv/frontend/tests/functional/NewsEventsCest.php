<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class NewsEventsCest
{
    public function checkNewsAndEvents(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Login');
        $I->click('Novidades');
        $I->amOnPage('/news/index');
        $I->see('Novidades', 'h1');
        $I->see('Novas Atividades');
        $I->see('Descrição: Verifique as ultimas atividades que abriram recentemente no nosso parque');
        $I->see('Data Limite: 2023-01-01');
        $I->click('Eventos');
        $I->amOnPage('/evento/index');
        $I->see('Eventos', 'h1');
    }
}