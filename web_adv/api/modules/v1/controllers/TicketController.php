<?php
namespace api\modules\v1\controllers;

use common\models\ActivitiesTicket;
use common\models\Atividade;
use common\models\Ticket;
use yii\rest\ActiveController;

class TicketController extends  ActiveController
{
    public $modelClass = 'common\models\Ticket';


    public function actionAtividades($id) {
        $atividadesTickets = ActivitiesTicket::findAll(['id_ticket' => $id]);

        $atividades = [];

        foreach ($atividadesTickets as $atividadeTicket)
        {
            $atividades[] = ['atividade' => Atividade::findOne(['id' => $atividadeTicket->id_activity]), 'tipo_atividade' => Atividade::findOne(['id' => $atividadeTicket->id_activity])->tipoAtividade->tipo];
        }

        if ($atividades != null)
        {
            return [
                'Ticket' => $id,
                'Atividades' => $atividades,
            ];
        }

        return ['id do Ticket' => $id, 'Atividades' => "O ticket nao possui atividades"];

    }

    /*
    public function actionRemove($id) {

        $ticket = Ticket::findOne(['id' => $id]);

        if ($ticket != null){
        $seccoesTickets = ActivitiesTicket::findAll(['id_ticket' => $id]);

        foreach ($seccoesTickets as $seccaoTicket)
        {
            $seccaoTicket->delete();
        }


            $ticket->delete();

        return \Yii::$app->response->statusCode = 200;
        }

        throw new \yii\web\NotFoundHttpException;
    }*/
}