<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkNewsButtonMainPage(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Login');
        $I->see('Novidades', 'h2');
        $I->seeLink('Ver Novidades »');
        $I->click('Ver Novidades »');
        $I->seeInCurrentUrl('/news/index');
        $I->see('Novas Atividades');
    }

    public function checkNewsLinkMainPageHeader(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Login');
        $I->seeLink('Novidades');
        $I->click('Novidades');
        $I->seeInCurrentUrl('/news/index');
        $I->see('Novas Atividades');
    }

    public function checkEventsButtonMainPage(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Login');
        $I->see('Eventos', 'h2');
        $I->seeLink('Ver Eventos »');
        $I->click('Ver Eventos »');
        $I->seeInCurrentUrl('/evento/index');
        $I->see('Evento de Natal');
    }

    public function checkEventsLinkMainPageHeader(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Login');
        $I->seeLink('Eventos');
        $I->click('Eventos');
        $I->seeInCurrentUrl('/evento/index');
        $I->see('Evento de Natal');
    }
}