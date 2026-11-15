<?php

namespace backend\tests\unit\models;

use common\models\Reports;
use common\models\TipoAtividade;
use common\models\TopicoReport;
use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class TipoAtividadeTest extends \Codeception\Test\Unit
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

    public function testCreateInvalidTipoAtividade()
    {
        $model = new TipoAtividade([
            'tipo' => 'Texto demasiado longo Texto demasiado longo Texto demasiado longo Texto demasiado longo Texto demasiado longo Texto demasiado longo Texto demasiado longo Texto demasiado longo Texto demasiado longo ',
        ]);

        expect('model não envia o tipo de atividade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('tipo'))->equals('O seu tipo de atividade não deverá ter mais de 45 caracteres');
    }

    public function testCreateBlankTipoAtividade()
    {
        $model = new TipoAtividade([
            'tipo' => '',
        ]);

        expect('model não envia o tipo de atividade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('tipo'))->equals('É necessário inserir um tipo de atividade.');
        $this->tester->dontSeeInDatabase('tipo_atividade', ['tipo' => '']);
    }

    public function testCreateValidTipoAtividade()
    {
        $model = new TipoAtividade([
            'tipo' => 'Tipo Correto',
        ]);

        expect('model envia o tipo de atividade', $model->save())->true();
        expect('mensagem de erro não é recebida', $model->getFirstError('tipo'))->equals('');
        $this->tester->seeInDatabase('tipo_atividade', ['tipo' => 'Tipo Correto']);
    }


}
