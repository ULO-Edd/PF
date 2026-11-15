<?php

namespace backend\tests\unit\models;

use common\models\Reports;
use common\models\TopicoReport;
use Yii;
use common\models\LoginForm;
use common\fixtures\UserFixture;

/**
 * Login form test
 */
class TopicReportTest extends \Codeception\Test\Unit
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

    public function testCreateInvalidTopic()
    {
        $model = new TopicoReport([
            'topico' => '1234',
        ]);

        expect('model não envia o topico', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('topico'))->equals('O seu tópico não deverá ter menos de 5 caracteres.');
    }

    public function testCreateBlankTopic()
    {
        $model = new TopicoReport([
            'topico' => '',
        ]);

        expect('model não envia o topico', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('topico'))->equals('É necessário inserir um tópico.');
        $this->tester->dontSeeInDatabase('topico_report', ['topico' => '']);
    }

    public function testCreateValidTopic()
    {
        $model = new TopicoReport([
            'topico' => 'topico correto',
        ]);

        expect('model envia o topico', $model->save())->true();
        expect('mensagem de erro não é recebida', $model->getFirstError('topico'))->equals('');
        $this->tester->seeInDatabase('topico_report', ['topico' => 'topico correto']);
    }


}
