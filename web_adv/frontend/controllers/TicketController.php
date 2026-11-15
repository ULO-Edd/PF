<?php

namespace frontend\controllers;

use common\models\Historico;
use common\models\Pessoa;
use common\models\ActivitiesTicket;
use common\models\Ticket;
use frontend\models\FilterForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * TicketController implements the CRUD actions for Ticket model.
 */
class TicketController extends Controller
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
                            'actions' => ['index', 'view', 'create', 'update', 'delete', 'filter-form'],
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
     * Lists all Ticket models.
     *
     * @return string
     */

    public function actionFilterForm(){
        $model = new FilterForm();
        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {

            if($this->request->post('FilterForm')){
                $model->filter = $this->request->post('FilterForm')['filter'];
                return $this->redirect(['index', 'filter' => $model->filter]);
            }
        }
        Yii::$app->session->setFlash('error', 'Erro ao filtrar');
        return $this->redirect('index');
    }

    public function actionIndex($filter = null)
    {
        $model = new FilterForm();
        $pessoa = Pessoa::findOne(['id' => Yii::$app->user->getId()]);
        if ($filter != null) {
            switch ($filter){
                case '2':
                    $dataProvider = new ActiveDataProvider(['query' => Ticket::find()->where(['id_pessoa' => $pessoa->id, 'anulado' => 1])]);

                    return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'pessoa' => $pessoa,
                        'filter' => $model,
                    ]);
                case '3':
                    $dataProvider = new ActiveDataProvider([
                        'query' => Ticket::find()->where(['id_pessoa' => $pessoa->id, 'expirado' => 1])]);

                    return $this->render('index', [
                        'dataProvider' => $dataProvider,
                        'pessoa' => $pessoa,
                        'filter' => $model,
                    ]);
            }
        }
        $tickets = Ticket::findAll(['id_pessoa' => Yii::$app->user->getId()]);
        foreach ($tickets as $ticket) {
            if ($ticket->data_de_uso < Yii::$app->formatter->asDate('now', 'yyyy-MM-dd') && $ticket->expirado != 1 && $ticket->anulado != 1 && $ticket->pre_compra != 1) {
                $ticket->expirado = 1;
                $ticket->save();
            }
            if ($ticket->pre_compra == 1) {
                $activityTikets = ActivitiesTicket::findAll(['id_ticket' => $ticket->id]);
                if($activityTikets != null){
                    foreach ($activityTikets as $activity){
                        $activity->delete();
                    }
                }
                $ticket->delete();
            }
        }
        return $this->render('index', [
            'pessoa' => $pessoa,
            'filter' => $model,
        ]);

    }

    /**
     * Displays a single Ticket model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $indexTicket = 0)
    {
        $ticket = $this->findModel($id);

        if ($ticket->pessoa->id != Yii::$app->user->id) {
            return $this->goHome();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $ticket->getActivities(),
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'indexTicket' => $indexTicket,
        ]);
    }

    /**
     * Creates a new Ticket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($idt = null, $ida = null)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if($idt == null){
            $model = new Ticket();
            $model->id_pessoa = Yii::$app->user->getId();
            $model->expirado = 0;
            $model->anulado = 0;
            $model->pre_compra = 1;
            $model->data_de_uso = Yii::$app->formatter->asDate('tomorrow','yyyy-MM-dd');
            $model->numero_atividades = 0;
            $model->save();
            if($ida != null){
                return $this->redirect(['atividade/add-to-ticket', 'id_atividade' => $ida, 'id_ticket' => $model->id]);
            }
        }else{
            $model = $this->findModel($idt);
        }

        if ($this->request->isPost) {
            $atividadesTicket = ActivitiesTicket::findAll(['id_ticket' => $model->id]);
            if(sizeof($atividadesTicket) == 0){
                Yii::$app->session->setFlash('error', 'Tem que adicionar pelo menos uma atividade');
                return $this->redirect(['create', 'idt' => $model->id]);
            }
            // por cada atividade é aumentado 3€ ao bilhete
            $model->preco = (sizeof($atividadesTicket) * 3);
            $model->data_de_compra = Yii::$app->formatter->asDate('now','yyyy-MM-dd');
            $model->data_de_uso = null;
            $model->numero_atividades = sizeof($atividadesTicket);
            $model->pre_compra = 0;
            if ($model->load($this->request->post()) && $model->save()) {
                $historico = new Historico();
                $historico->id_user = $model->id_pessoa;
                $historico->data = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                $historico->titulo = 'Compra de Bilhete';
                $historico->descricao = 'Foi efetuada a compra de um bilhete';
                $historico->pontos = 7;
                $historico->acumulou = 1;
                $historico->save();
                $pessoa = $model->pessoa;
                $pessoa->points += 7;
                $pessoa->save();
                Yii::$app->session->setFlash('info', 'Accumulou 7 pontos ao seu perfil');
                Yii::$app->session->setFlash('success', 'Bilhete comprado com sucesso');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        if ($model->pre_compra == 1){
            $model->data_de_uso = null;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ticket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idt, $indexTicket)
    {
        $model = $this->findModel($idt);

        if ($this->request->isPost) {
            $atividadesTicket = ActivitiesTicket::findAll(['id_ticket' => $model->id]);
            if(sizeof($atividadesTicket) == 0){
                Yii::$app->session->setFlash('error', 'Tem que adicionar pelo menos uma atividade');
                return $this->redirect(['update', 'idt' => $model->id, 'indexTicket' => $indexTicket]);
            }
            if($model->expirado == 1){
                $model->data_de_compra = Yii::$app->formatter->asDate('today','yyyy-MM-dd');
                $model->preco = (sizeof($atividadesTicket) * 3);
            }
            $model->numero_atividades = sizeof($model->activities);
            if ($model->load($this->request->post()) && $model->save()) {
                if($model->expirado == 1){
                    $historico = new Historico();
                    $historico->id_user = $model->id_pessoa;
                    $historico->data = Yii::$app->formatter->asDatetime('now', 'php:Y-m-d H:i:s');
                    $historico->titulo = 'Renovação de Bilhete';
                    $historico->descricao = 'Foi efetuada a renovação de um bilhete';
                    $historico->pontos = 7;
                    $historico->acumulou = 1;
                    $historico->save();
                    $pessoa = $model->pessoa;
                    $pessoa->points += 7;
                    $pessoa->save();
                    Yii::$app->session->setFlash('info', 'Accumulou 7 pontos ao seu perfil');
                    Yii::$app->session->setFlash('success', 'Bilhete renovado com sucesso');
                }else if($model->anulado == 1){
                    Yii::$app->session->setFlash('success', 'Bilhete editado com sucesso');
                }
                $model->expirado = 0;
                $model->anulado = 0;
                $model->save();
                return $this->redirect(['view', 'id' => $model->id, 'indexTicket' => $indexTicket]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'indexTicket' => $indexTicket,
        ]);
    }




    /**
     * Deletes an existing Ticket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $activitiesTicket = ActivitiesTicket::findAll(['id_ticket' => $id]);

        foreach ($activitiesTicket as $activity)
        {
            $activity->delete();
        }

        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Bilhete eliminado com sucesso');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Erro ao eliminar bilhete');
        return $this->goBack();
    }

    /**
     * Finds the Ticket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ticket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ticket::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
