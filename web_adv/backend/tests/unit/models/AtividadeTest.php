<?php

namespace backend\tests\unit\models;

use common\models\Atividade;
use common\models\Evento;
use common\models\News;
use common\models\Reports;
use common\models\TopicoReport;
use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;
use yii\db\StaleObjectException;

/**
 * Login form test
 */
class AtividadeTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testCreateBlankDesignacao()
    {
        $model = new Atividade([
            'designacao' => '',
            'descricao' => 'descricao',
            'lotacao' => '50',
            'id_tipo_atividade' => '1',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('designacao'))->equals('É necessário inserir uma designação.');
        $this->tester->dontSeeInDatabase('atividade', ['designacao' => '']);
    }

    public function testCreateBlankDescricao()
    {
        $model = new Atividade([
            'designacao' => 'designacao',
            'descricao' => '',
            'lotacao' => '50',
            'id_tipo_atividade' => '1',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('descricao'))->equals('É necessário inserir uma descrição.');
        $this->tester->dontSeeInDatabase('atividade', ['descricao' => '']);
    }

    public function testCreateBlankDataInicio()
    {
        $model = new Atividade([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'lotacao' => '',
            'id_tipo_atividade' => '1',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('lotacao'))->equals('É necessário inserir uma lotação.');
        $this->tester->dontSeeInDatabase('atividade', ['lotacao' => '']);
    }

    public function testCreateBlankDataConclusao()
    {
        $model = new Atividade([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'lotacao' => '50',
            'id_tipo_atividade' => '',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('id_tipo_atividade'))->equals('É necessário inserir um tipo de atividade.');
        $this->tester->dontSeeInDatabase('atividade', ['id_tipo_atividade' => '']);
    }


    public function testCreateValidAtividade()
    {
        $model = new Atividade([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'lotacao' => '50',
            'id_tipo_atividade' => '1',
            'image' => '',
        ]);

        expect('model envia a novidade', $model->save())->true();
        expect('mensagem de erro não é recebida', $model->getErrors())->isEmpty();
        $this->tester->seeInDatabase('atividade',
            ['designacao' => 'designacao',
                'descricao' => 'descricao',
                'lotacao' => '50',
                'id_tipo_atividade' => '1']);
    }

    public function testDeleteAtividade()
    {
        $model = new Atividade([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'lotacao' => '50',
            'id_tipo_atividade' => '1',
            'image' => '',
        ]);

        expect('criar atividade com sucesso', $model->save())->true();
        $this->tester->seeInDatabase('atividade',
            ['designacao' => 'designacao',
                'descricao' => 'descricao',
                'lotacao' => '50',
                'id_tipo_atividade' => '1']);

        expect('eliminar a atividade com sucesso', $model->delete())->equals(1);

        $this->tester->dontSeeInDatabase('atividade',
            ['designacao' => 'designacao',
                'descricao' => 'descricao',
                'lotacao' => '50',
                'id_tipo_atividade' => '1']);
    }
}
