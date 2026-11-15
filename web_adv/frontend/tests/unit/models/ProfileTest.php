<?php

namespace frontend\tests\unit\models;

use common\models\User;
use frontend\models\UpdateUserForm;
use frontend\tests\UnitTester;



class ProfileTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */

    protected $tester;

    public function testFailUpdateProfileWithBlankAttributes()
    {
        $user = User::findOne(['id' => 1]);

        $model = new UpdateUserForm([
            'username' => '',
            'email' => '',
            'telephone' => '',
            'name' => '',
            'lastname' => '',
        ]);

        expect('model to fail update', $model->update($user->id))->false();
        $this->tester->dontSeeInDatabase('pessoa', ['name' => '', 'lastname' => '', 'telephone' => '']);
        $this->tester->dontSeeInDatabase('user', ['username' => '', 'email' => '']);
    }

    public function testUpdateProfileWithSuccess()
    {
        $user = User::findOne(['id' => 1]);

        $model = new UpdateUserForm([
            'username' => 'usertest',
            'email' => 'usertest@gmail.com',
            'telephone' => '912345671',
            'name' => 'test',
            'lastname' => 'user',
        ]);

        expect('model to update', $model->update($user->id))->true();
        $this->tester->SeeInDatabase('pessoa', ['name' => 'test', 'lastname' => 'user', 'telephone' => '912345671']);
        $this->tester->SeeInDatabase('user', ['username' => 'usertest', 'email' => 'usertest@gmail.com']);
    }
}