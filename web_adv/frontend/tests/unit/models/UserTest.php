<?php

namespace unit\models;

use common\models\Atividade;
use common\models\Pessoa;
use common\models\User;
use Yii;
use common\fixtures\UserFixture;



class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */

    protected $tester;

    public function testevalidation(){

        $pessoa = new Pessoa();

        $pessoa->name='Nometeste';
        $this->assertTrue($pessoa->validate(['name']));

        $pessoa->name= null;
        $this->assertFalse($pessoa->validate(['name']));


        $pessoa->lastname='Apelidoteste';
        $this->assertTrue($pessoa->validate(['lastname']));

        $pessoa->lastname= null;
        $this->assertFalse($pessoa->validate(['lastname']));


        $pessoa->birthday_date='2001-11-22';
        $this->assertTrue($pessoa->validate(['birthday_date']));

        $pessoa->birthday_date= null;
        $this->assertFalse($pessoa->validate(['birthday_date']));


        $pessoa->telephone='919919919';
        $this->assertTrue($pessoa->validate(['telephone']));

        $pessoa->telephone='+351919919919';
        $this->assertTrue($pessoa->validate(['telephone']));

        $pessoa->telephone= null;
        $this->assertTrue($pessoa->validate(['telephone']));
    }
}