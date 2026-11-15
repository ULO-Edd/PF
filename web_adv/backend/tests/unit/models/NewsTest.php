<?php

namespace backend\tests\unit\models;

use common\models\News;
use common\models\Reports;
use common\models\TopicoReport;
use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class NewsTest extends \Codeception\Test\Unit
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

    public function testCreateBlankTitulo()
    {
        $model = new News([
            'titulo' => '',
            'descricao' => 'descricao',
            'date_expire' => '2023-12-31',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('titulo'))->equals('É necessário inserir um título.');
        $this->tester->dontSeeInDatabase('news', ['titulo' => '']);
    }

    public function testCreateBlankDescricao()
    {
        $model = new News([
            'titulo' => 'titulo',
            'descricao' => '',
            'date_expire' => '2023-12-31',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('descricao'))->equals('É necessário inserir uma descrição.');
        $this->tester->dontSeeInDatabase('news', ['descricao' => '']);
    }

    public function testCreateBlankData()
    {
        $model = new News([
            'titulo' => 'titulo',
            'descricao' => 'descricao',
            'date_expire' => '',
            'image' => '',
        ]);

        expect('model não envia a novidade', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('date_expire'))->equals('É necessário inserir uma data de validade.');
        $this->tester->dontSeeInDatabase('news', ['date_expire' => '']);
    }

    public function testCreateValidNovidade()
    {
        $model = new News([
            'titulo' => 'titulo',
            'descricao' => 'descricao',
            'date_expire' => '2023-12-31',
            'image' => '',
        ]);

        expect('model envia a novidade', $model->save())->true();
        expect('mensagem de erro não é recebida', $model->getErrors())->isEmpty();
        $this->tester->seeInDatabase('news',
            ['titulo' => 'titulo',
                'descricao' => 'descricao',
                'date_expire' => '2023-12-31']);
    }

}
