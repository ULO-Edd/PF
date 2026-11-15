<?php

namespace frontend\tests\unit\models;

use common\models\User;



class SignupTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */

    protected $tester;

    function testSavingUser()
    {
        $user = new User();
        $user->username = 'UserSignup';
        $user->email = 'UserSignup@gmail.com';
        $user->generateAuthKey();
        $user->setPassword('useruser');
        $user->save();
        $this->assertEquals('UserSignup', $user->username);
        $this->assertEquals('UserSignup@gmail.com', $user->email);
        $this->tester->seeInDatabase('user', ['username' => 'UserSignup', 'email' => 'UserSignup@gmail.com']);
    }
}