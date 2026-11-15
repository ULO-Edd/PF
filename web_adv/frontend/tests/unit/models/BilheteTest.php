<?php

namespace frontend\tests\unit\models;

use common\models\ActivitiesTicket;
use common\models\Atividade;
use common\models\Ticket;
use DateTime;
use frontend\tests\UnitTester;

class BilheteTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected UnitTester $tester;

    function testeCreateBilheteWithNoActivities()
    {
        $date = new DateTime('tomorrow');

        $bilhete = new Ticket([
            'id_pessoa' => 1,
            'data_de_uso' => $date->format('Y-m-d'),
            'expirado' => 0,
            'anulado' => 0,
            'pre_compra' => 1,
            'numero_atividades' => 0,
        ]);
        $this->assertTrue($bilhete->save(), 'Erro ao salvar na BD');
        $this->assertNotNull(Ticket::findOne(['id_pessoa' => 1, 'data_de_uso' => $date->format('Y-m-d'), 'pre_compra' => 1]));
        $this->tester->seeInDatabase('ticket', ['id_pessoa' => 1, 'data_de_uso' => $date->format('Y-m-d'), 'pre_compra' => 1]);
    }

    function testeCreateBilheteWithActivities()
    {
        $date = new DateTime('tomorrow');

        $bilhete = new Ticket([
            'id_pessoa' => 1,
            'data_de_uso' => $date->format('Y-m-d'),
            'expirado' => 0,
            'anulado' => 0,
            'pre_compra' => 1,
            'numero_atividades' => 0,
        ]);
        $this->assertTrue($bilhete->save(), 'Erro ao salvar na BD');
        $this->assertNotNull(Ticket::findOne(['id_pessoa' => 1, 'data_de_uso' => $date->format('Y-m-d'), 'pre_compra' => 1]));
        $this->tester->seeInDatabase('ticket', ['id_pessoa' => 1, 'data_de_uso' => $date->format('Y-m-d'), 'pre_compra' => 1]);

        $newTicketActivity = new ActivitiesTicket(['id_ticket' => $bilhete->id, 'id_activity' => 1]);
        $this->assertTrue($newTicketActivity->save(), 'Erro ao salvar atividades no bilhete a BD');
        $this->tester->seeInDatabase('activities_ticket', ['id_ticket' => $bilhete->id, 'id_activity' => 1]);
    }
}