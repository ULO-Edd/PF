<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use Codeception\Util\Locator;

class UserCest
{
    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function createUser(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('#login-form', $this->formParams('UserAdmin', 'adminadmin'));
        $I->seeInCurrentUrl(\Yii::$app->homeUrl);
        $I->see('UserAdmin');
        $I->click('Utilizadores');
        $I->seeInCurrentUrl('/user/index');
        $I->see('Utilizadores', 'h1');
        $I->click('Criar Utilizador');
        $I->seeInCurrentUrl('/user/createuser');
        $I->fillField('CreateUserForm[username]', 'UserManagerTeste');
        $I->fillField('CreateUserForm[name]', 'ManagerNome');
        $I->fillField('CreateUserForm[lastname]', 'ManagerApelido');
        $I->fillField('CreateUserForm[birthday_date]', '2000-12-06');
        $I->fillField('CreateUserForm[telephone]', '+351911222333');
        $I->fillField('CreateUserForm[email]', 'managerteste@gmail.com');
        $I->fillField('CreateUserForm[password]', 'managermanager');
        $I->selectOption('CreateUserForm[role]', 'manager');
        $I->click('Salvar');
        $I->seeInDatabase('user',
            ['username' =>'UserManagerTeste',
            'email' =>'managerteste@gmail.com']);
        $I->seeInDatabase('pessoa',
            ['name' =>'ManagerNome',
            'lastname' =>'ManagerApelido',
            'birthday_date' =>'2000-12-06',
            'telephone' =>'911222333']);
    }
}
