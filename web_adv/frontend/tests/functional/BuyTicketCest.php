<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class BuyTicketCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkBuyNewTicketWithFavoriteActivities(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('login');
        $I->click('Login');
        $I->seeInCurrentUrl('/site/login');
        $I->submitForm('#login-form', $this->formParams('User1', 'useruser'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('Logout');
        $I->click('Bilhetes');
        $I->seeInCurrentUrl('/ticket/index');
        $I->click('Comprar Bilhete');
        $I->see("Adicionar Atividades Favoritas ao Bilhete", 'a');
        $I->click("Adicionar Atividades Favoritas ao Bilhete");
        $I->submitForm('#ticket-buy-form', ['Ticket' => ['data_de_uso' => '2023-02-15']]);
        $I->see("Bilhete comprado com sucesso");
        $I->seeInDatabase('ticket', ['data_de_uso' =>'2023-02-15']);
    }
}