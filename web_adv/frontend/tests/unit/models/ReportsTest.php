<?php

namespace frontend\tests\unit\models;

use frontend\tests\UnitTester;
use common\models\Reports;



class ReportsTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */

    protected $tester;

    public function testFailReportWithTopicoBlank()
    {
        $model = new Reports([
            'descricao' => 'descricao teste descricao teste',
            'id_user' => 1,
        ]);

        expect('model não envia o report', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('id_topico'))->equals('É necessário inserir um tópico.');
        $this->assertEmpty('', '' . $model->id_topico);
    }

    public function testFailReportWithDescriptionBlank()
    {
        $model = new Reports([
            'id_topico' => 1,
            'descricao' => '',
        ]);

        expect('model não envia o report', $model->save())->false();
        expect('mensagem de erro é recebida', $model->getFirstError('descricao'))->equals('É necessário inserir uma descricão.');
        $this->assertEmpty('', $model->descricao);
        $this->tester->dontSeeInDatabase('reports', ['descricao' => '']);
    }

    public function testCreateReportWithSuccess()
    {
        $model = new Reports([
            'id_topico' => 1,
            'descricao' => 'descricao teste descricao teste',
            'id_user' => 1,
        ]);

        expect('model envia o report', $model->save())->true();
        expect('mensagem de erro não é recebida', $model->getFirstError('descricao'))->equals('');
        $this->tester->seeInDatabase('reports', ['id_topico' => 1, 'descricao' => 'descricao teste descricao teste']);

    }
}