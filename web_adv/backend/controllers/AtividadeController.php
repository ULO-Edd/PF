<?php

namespace backend\controllers;

use common\models\ActivitiesEvento;
use common\models\Atividade;
use common\models\Favorito;
use common\models\News;
use common\models\TipoAtividade;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AtividadeController implements the CRUD actions for Atividade model.
 */
class AtividadeController extends BaseController
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

    /**
     * Lists all Atividade models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Atividade::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Atividade model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Atividade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Atividade();
        $tipoAtividade = ArrayHelper::map(TipoAtividade::find()->all(), 'id', 'tipo');

        $novidade = new News();

        $novidade->titulo = "Nova Atividade";
        $novidade->descricao = "Foi aberta uma nova atividade no nosso parque, venha experimentar!";
        $novidade->date_expire = Yii::$app->formatter->asDate('tomorrow','yyyy-MM-dd');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $imageFile = UploadedFile::getInstance($model, 'image');
                if (isset($imageFile->size)){
                    $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                    $model->image = $imageFile->baseName.'.'.$imageFile->extension;
                }
            }
            if ($this->request->post('novidadeCheckbox') == '1') {
                if($novidade->load($this->request->post())){
                    $imageFile = UploadedFile::getInstance($novidade, 'image');
                    if (isset($imageFile->size)){
                        $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                        $novidade->image = $imageFile->baseName.'.'.$imageFile->extension;
                    }
                    if($model->save() && $novidade->save()){
                        Yii::$app->session->setFlash('success', 'Atividade criada com sucesso');
                        return $this->redirect(['index']);
                    }
                }
            }else{
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Atividade criada com sucesso');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'novidade' => $novidade,
            'tipoAtividade' => $tipoAtividade,
        ]);
    }

    /**
     * Updates an existing Atividade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imageModel = $model->image;
        $tipoAtividade = ArrayHelper::map(TipoAtividade::find()->all(), 'id', 'tipo');

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $imageFile = UploadedFile::getInstance($model, 'image');
                if (isset($imageFile->size)){
                    $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                    $model->image = $imageFile->baseName.'.'.$imageFile->extension;
                }
                if($imageFile == null){
                    $model->image = $imageModel;
                }
                if ($model->save()) {
                    Yii::$app->session->setFlash('sucess', 'Atividade editada com sucesso');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                Yii::$app->session->setFlash('error', 'Erro ao editar Atividade');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'tipoAtividade' => $tipoAtividade,
        ]);
    }

    /**
     * Deletes an existing Atividade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $favoritos = Favorito::findAll(['id_atividade' => $id]);
        foreach ($favoritos as $favorito)
        {
            $favorito->delete();
        }


        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('sucess', 'Atividade eliminado com sucesso');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Erro ao eliminar a Atividade');
        return $this->redirect(['index']);
    }

    public function actionAddToEvent($id_atividade, $id_evento)
    {
        $activityEvent = new ActivitiesEvento();
        $activityEvent->id_atividade = $id_atividade;
        $activityEvent->id_evento = $id_evento;

        if ($activityEvent->save()) {
            Yii::$app->session->setFlash('success', 'Atividade adicionada ao Bilhete com sucesso');
            return $this->redirect(['evento/create', 'ide' => $id_evento]);
        }
        Yii::$app->session->setFlash('error', 'Erro ao adicionar atividade ao Bilhete');
        return $this->redirect(['evento/create', 'idt' => $id_evento]);
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
