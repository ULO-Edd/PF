<?php

namespace frontend\tests\unit\models;

use common\models\Atividade;
use common\models\Favorito;
use common\models\User;
use frontend\tests\UnitTester;

class FavoritoTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected UnitTester $tester;

    function testeCreateFavoriteWithSuccess()
    {
        $userfav = User::findOne(['username' => 'User1']);
        $atividadefav = Atividade::findOne(['designacao' => 'Ponte suspensa']);
        $favorito = new Favorito(['id_user' => $userfav->id, 'id_atividade' => $atividadefav->id]);
        $this->assertTrue($favorito->save(), 'Erro ao salvar na BD');
        $this->assertNotNull(Favorito::findOne(['id_user' => $userfav->id, 'id_atividade' => $atividadefav->id]));
        $this->tester->seeInDatabase('favorito', ['id_user' => $userfav->id, 'id_atividade' => $atividadefav->id]);
    }

    function testeFailCreateFavoriteWithSameIDs(){
        $userfav = User::findOne(['username' => 'User1']);
        $atividadefav = Atividade::findOne(['designacao' => 'Ponte suspensa']);
        $favorito = new Favorito(['id_user' => $userfav->id, 'id_atividade' => $atividadefav->id]);
        $this->assertTrue($favorito->save(), 'Erro ao salvar na BD');
        $this->tester->seeInDatabase('favorito', ['id_user' => $userfav->id, 'id_atividade' => $atividadefav->id]);

        $newFavorito = new Favorito(['id_user' => $userfav->id, 'id_atividade' => $atividadefav->id]);
        $this->expectException('yii\db\IntegrityException');
        $this->assertFalse($newFavorito->save(), 'Não existia um favorito com os mesmos IDs');
    }
}