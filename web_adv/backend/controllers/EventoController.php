<?php

namespace backend\controllers;

use common\models\ActivitiesEvento;
use common\models\Evento;
use common\models\News;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EventoController implements the CRUD actions for Evento model.
 */
class EventoController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    /**
     * Lists all Evento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $eventos = Evento::find()->all();
        foreach ($eventos as $evento) {
            if ($evento->data_conclusao < Yii::$app->formatter->asDate('now', 'yyyy-MM-dd')) {
                $evento->ativo = 0;
                $evento->save();
            }
            if ($evento->ativo == 0) {
                $eventActivities = ActivitiesEvento::findAll(['id_evento' => $evento->id]);
                if($eventActivities != null){
                    foreach ($eventActivities as $activity){
                        $activity->delete();
                    }
                }
                $evento->delete();
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Evento::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Evento model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $evento = $this->findModel($id);

        $dataProvider = new ActiveDataProvider([
            'query' => $evento->getAtividades(),
        ]);

        return $this->render('view', [
            'model' => $evento,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Evento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($ide = null)
    {
        $dataProvider = null;
        $novidade = new News();

        $novidade->titulo = "Novo Evento";
        $novidade->descricao = "Venha a este maravilho evento!";
        $novidade->date_expire = Yii::$app->formatter->asDate('tomorrow','yyyy-MM-dd');

        if($ide == null){
            $model = new Evento();
            $model->designacao = "null";
            $model->descricao = "null";
            $model->ativo = 0;
            $model->pontos_participacao = 0;
            $model->data_inicio = Yii::$app->formatter->asDate('today','yyyy-MM-dd');
            $model->data_conclusao = Yii::$app->formatter->asDate('tomorrow','yyyy-MM-dd');
            $model->save();
        }else{
            $model = $this->findModel($ide);

            $dataProvider = new ActiveDataProvider([
                'query' => $model->getAtividades(),
            ]);
        }

        if ($this->request->isPost) {
            if($model->load($this->request->post())){
                $imageFile = UploadedFile::getInstance($model, 'image');
                if (isset($imageFile->size)){
                    $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                    $model->image = $imageFile->baseName.'.'.$imageFile->extension;
                }
                $model->ativo = 1;
            }
            if ($this->request->post('novidadeCheckbox') == '1') {
                if($novidade->load($this->request->post())){
                    $imageFile = UploadedFile::getInstance($novidade, 'image');
                    if (isset($imageFile->size)){
                        $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                        $novidade->image = $imageFile->baseName.'.'.$imageFile->extension;
                    }
                    if($model->save() && $novidade->save()){
                        Yii::$app->session->setFlash('success', 'Evento criado com sucesso');
                        return $this->redirect(['index']);
                    }
                }
            }else{
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Evento criado com sucesso');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        if($model->ativo == 0){
            $model->designacao = null;
            $model->descricao = null;
            $model->data_inicio = null;
            $model->data_conclusao = null;
            $model->pontos_participacao = null;

        }

        return $this->render('create', [
            'model' => $model,
            'novidade' => $novidade,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Evento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imageModel = $model->image;

        $dataProvider = new ActiveDataProvider([
            'query' => $model->getAtividades(),
        ]);

        if ($this->request->isPost && $model->load($this->request->post())){
            $imageFile = UploadedFile::getInstance($model, 'image');
            if (isset($imageFile->size)){
                $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                $model->image = $imageFile->baseName.'.'.$imageFile->extension;
            }
            if($imageFile == null){
                $model->image = $imageModel;
            }
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Evento editado com sucesso');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Evento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $evento = $this->findModel($id);

        $eventActivities = ActivitiesEvento::findAll(['id_evento' => $evento->id]);
        if($eventActivities != null){
            foreach ($eventActivities as $activity){
                $activity->delete();
            }
        }
        $evento->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Evento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Evento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Evento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
