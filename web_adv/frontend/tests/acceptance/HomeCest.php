<?php

namespace frontend\tests\acceptance;

use frontend\tests\AcceptanceTester;
use yii\helpers\Url;

class HomeCest
{

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

        public function clientSimulation(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(3);
        $I->click('Registar');
        $I->seeInCurrentUrl('/site/signup');
        $I->fillField("SignupForm[username]", 'UserTeste');
        $I->fillField("SignupForm[name]", 'User');
        $I->fillField("SignupForm[lastname]", 'Teste');
        $I->fillField("SignupForm[birthday_date]", '2001-11-10');
        $I->fillField("SignupForm[telephone]", '919919917');
        $I->fillField("SignupForm[email]", 'userteste@gmail.com');
        $I->fillField("SignupForm[password]", 'useruser');
        $I->wait(3);
        $I->click('signup-button');
        $I->wait(3);
        $I->click('Login');
        $I->wait(3);
        $I->seeInCurrentUrl('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserTeste', 'useruser'));
        $I->wait(3);
        $I->click('Atividades');
        $I->wait(3);
        $I->click('★');
        $I->wait(1);
        $I->see('Atividade adicionada aos favoritos');
        $I->click('Bilhetes');
        $I->wait(3);
        $I->seeInCurrentUrl('/ticket/index');
        $I->click('Comprar Bilhete');
        $I->wait(3);
        $I->click("Adicionar Atividades Favoritas ao Bilhete");
        $I->wait(3);
        $I->see("Atividades adicionadas ao Bilhete");
        $I->fillField("Ticket[data_de_uso]", '2023-02-15');
        $I->click('Comprar');
        $I->wait(1);
        $I->see("Bilhete comprado com sucesso");
        $I->click('Sugestões');
        $I->wait(3);
        $I->amOnPage('/reports/create');
        $I->see('Criar Sugestão', 'h1');
        $I->selectOption('Reports[id_topico]', '1');
        $I->fillField('Reports[descricao]', 'Mensagem de congratulação!');
        $I->wait(3);
        $I->click('Guardar');
        $I->wait(1);
        $I->see('Agradeçemos pela sua sugestão');
    }
}
