<?php

namespace backend\controllers;

use common\models\ActivitiesEvento;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AtividadesTicketController implements the CRUD actions for ActivitiesTicket model.
 */
class ActivitiesEventoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionRemover($idEvento, $idActivity){
        $activityEvento = ActivitiesEvento::findOne(['id_evento' => $idEvento, 'id_atividade' => $idActivity]);

        if($activityEvento->delete()){
            Yii::$app->session->setFlash('success', 'Atividade removida do Evento');
            return $this->redirect(['evento/create','ide' => $idEvento]);
        }
        Yii::$app->session->setFlash('error', 'Erro ao eliminar a atividade do Evento');
        return $this->redirect(['evento/create', 'ide' => $idEvento]);
    }


    /**
     * Finds the ActivitiesTicket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_ticket Id Ticket
     * @param int $id_activity Id Activity
     * @return ActivitiesEvento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_evento, $id_activity)
    {
        if (($model = ActivitiesEvento::findOne(['id_evento' => $id_evento, 'id_activity' => $id_activity])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
