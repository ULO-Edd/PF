<?php

namespace frontend\controllers;

use common\models\ActivitiesTicket;
use common\models\Atividade;
use common\models\Favorito;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;

/**
 * AtividadeController implements the CRUD actions for Atividade model.
 */
class AtividadeController extends Controller
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
                            'actions' => ['index', 'view', 'add-to-ticket'],
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

    /**
     * Lists all Atividade models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $idTicket = Yii::$app->request->get('idTicket');
        $indexTicket = Yii::$app->request->get('indexTicket');

        $dataProvider = new ActiveDataProvider([
            'query' => Atividade::find(),
        ]);

        return $this->render('index', [
            'idTicket' => $idTicket,
            'indexTicket' => $indexTicket,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAddToTicket($id_atividade, $id_ticket = null, $indexTicket = null)
    {
            $activityTicket = new ActivitiesTicket();
            $activityTicket->id_activity = $id_atividade;
            $activityTicket->id_ticket = $id_ticket;

            if ($indexTicket != 0 || $indexTicket != null) {
                if ($activityTicket->validate() && $activityTicket->save()) {
                    Yii::$app->session->setFlash('success', 'Atividade adicionada ao Bilhete com sucesso');
                    return $this->redirect(['ticket/update', 'idt' => $id_ticket, 'indexTicket' => $indexTicket]);
                }
                Yii::$app->session->setFlash('error', 'Erro ao adicionar atividade ao Bilhete');
                return $this->redirect(['atividade/update', 'idt' => $id_ticket, 'indexTicket' => $indexTicket]);
            } else {
                if ($activityTicket->validate() && $activityTicket->save()) {
                    Yii::$app->session->setFlash('success', 'Atividade adicionada ao Bilhete com sucesso');
                    return $this->redirect(['ticket/create', 'idt' => $id_ticket]);
                }
                Yii::$app->session->setFlash('error', 'Erro ao adicionar atividade ao Bilhete');
                return $this->redirect(['ticket/create', 'idt' => $id_ticket]);
            }

    }


    /**
     * Finds the Atividade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Atividade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Atividade::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
