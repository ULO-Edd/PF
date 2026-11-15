<?php

namespace frontend\controllers;

use common\models\Atividade;
use common\models\Favorito;
use common\models\ActivitiesTicket;
use common\models\Ticket;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AtividadesTicketController implements the CRUD actions for ActivitiesTicket model.
 */
class AtividadesTicketController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['adicionar-all', 'remover'],
                            'allow' => true,
                            'roles' => ['client'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionAdicionarAll($idUser, $idTicket, $indexTicket)
    {
        $ticket = Ticket::findOne(['id' => $idTicket]);

        if ($indexTicket != 0) {
            switch ($ticket->addAllFavorites($idUser, $idTicket)){
                case -1:
                    Yii::$app->session->setFlash('error', 'Erro ao adicionar as atividades ao Bilhete');
                    return $this->redirect(['ticket/update', 'idt' => $idTicket, 'indexTicket' => $indexTicket]);
                case 0:
                    Yii::$app->session->setFlash('error', 'Não possui atividades favoritas');
                    return $this->redirect(['ticket/update', 'idt' => $idTicket, 'indexTicket' => $indexTicket]);
                case 1:
                    Yii::$app->session->setFlash('success', 'Atividades adicionadas ao Bilhete');
                    return $this->redirect(['ticket/update', 'idt' => $idTicket, 'indexTicket' => $indexTicket]);
            }
        }else{
            switch ($ticket->addAllFavorites($idUser, $idTicket)){
                case -1:
                    Yii::$app->session->setFlash('error', 'Erro ao adicionar as atividades ao Bilhete');
                    return $this->redirect(['ticket/create', 'idt' => $idTicket]);
                case 0:
                    Yii::$app->session->setFlash('error', 'Não possui atividades favoritas');
                    return $this->redirect(['ticket/create', 'idt' => $idTicket]);
                case 1:
                    Yii::$app->session->setFlash('success', 'Atividades adicionadas ao Bilhete');
                    return $this->redirect(['ticket/create', 'idt' => $idTicket]);
            }
        }
    }

    public function actionRemover($idTicket, $idActivity, $indexTicket){
        $activityTicket = ActivitiesTicket::findOne(['id_ticket' => $idTicket, 'id_activity' => $idActivity]);

        if($indexTicket != 0){
            if($activityTicket->delete()){
                Yii::$app->session->setFlash('success', 'Atividade removida do Bilhete');
                return $this->redirect(['ticket/update', 'idt' => $idTicket, 'indexTicket' => $indexTicket]);
            }
            Yii::$app->session->setFlash('error', 'Erro ao eliminar a atividade do Bilhete');
            return $this->redirect(['ticket/update', 'idt' => $idTicket, 'indexTicket' => $indexTicket]);
        }else{
            if($activityTicket->delete()){
                Yii::$app->session->setFlash('success', 'Atividade removida do Bilhete');
                return $this->redirect(['ticket/create','idt' => $idTicket]);
            }
            Yii::$app->session->setFlash('error', 'Erro ao eliminar a atividade do Bilhete');
            return $this->redirect(['ticket/create', 'idt' => $idTicket]);
        }
    }

    /**
     * Creates a new ActivitiesTicket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ActivitiesTicket();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_ticket' => $model->id_ticket, 'id_activity' => $model->id_activity]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the ActivitiesTicket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_ticket Id Ticket
     * @param int $id_activity Id Activity
     * @return ActivitiesTicket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_ticket, $id_activity)
    {
        if (($model = ActivitiesTicket::findOne(['id_ticket' => $id_ticket, 'id_activity' => $id_activity])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
