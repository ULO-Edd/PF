<?php

namespace backend\tests\unit\models;

use common\models\Evento;
use common\models\News;
use common\models\Reports;
use common\models\TopicoReport;
use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class EventoTest extends \Codeception\Test\Unit
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
        $model = new Evento([
            'designacao' => '',
            'descricao' => 'descricao',
            'data_inicio' => '2023-1-1',
            'data_conclusao' => '2023-3-1',
            'pontos_participacao' => '10',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('designacao'))->equals('É necessário inserir uma designação.');
        $this->tester->dontSeeInDatabase('evento', ['designacao' => '']);
    }

    public function testCreateBlankDescricao()
    {
        $model = new Evento([
            'designacao' => 'designacao',
            'descricao' => '',
            'data_inicio' => '2023-1-1',
            'data_conclusao' => '2023-3-1',
            'pontos_participacao' => '10',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('descricao'))->equals('É necessário inserir uma descrição.');
        $this->tester->dontSeeInDatabase('evento', ['designacao' => '']);
    }

    public function testCreateBlankDataInicio()
    {
        $model = new Evento([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'data_inicio' => '',
            'data_conclusao' => '2023-3-1',
            'pontos_participacao' => '10',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('data_inicio'))->equals('É necessário inserir uma data de início.');
        $this->tester->dontSeeInDatabase('evento', ['data_inicio' => '']);
    }

    public function testCreateBlankDataConclusao()
    {
        $model = new Evento([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'data_inicio' => '2023-1-1',
            'data_conclusao' => '',
            'pontos_participacao' => '10',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('data_conclusao'))->equals('É necessário inserir uma data de conclusão.');
        $this->tester->dontSeeInDatabase('evento', ['data_conclusao' => '']);
    }

    public function testCreateBlankPontos()
    {
        $model = new Evento([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'data_inicio' => '2023-1-1',
            'data_conclusao' => '2023-3-1',
            'pontos_participacao' => '',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('pontos_participacao'))->equals('É necessário inserir os pontos de participação.');
        $this->tester->dontSeeInDatabase('evento', ['pontos_participacao' => '']);
    }

    public function testCreateValidEvento()
    {
        $model = new Evento([
            'designacao' => 'designacao',
            'descricao' => 'descricao',
            'data_inicio' => '2023-1-1',
            'data_conclusao' => '2023-3-1',
            'pontos_participacao' => '10',
            'image' => '',
        ]);

        expect('model envia a novidade', $model->save())->true();
        expect('mensagem de erro não é recebida', $model->getErrors())->isEmpty();
        $this->tester->seeInDatabase('evento',
            ['designacao' => 'designacao',
                'descricao' => 'descricao',
                'data_inicio' => '2023-1-1',
                'data_conclusao' => '2023-3-1',
                'pontos_participacao' => '10'],
        );
    }


}
