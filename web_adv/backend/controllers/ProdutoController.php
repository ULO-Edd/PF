<?php

namespace backend\controllers;

use common\models\Loja;
use common\models\Produto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProdutoController implements the CRUD actions for Produto model.
 */
class ProdutoController extends BaseController
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
     * Lists all Produto models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Produto::find(),
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
     * Displays a single Produto model.
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
     * Creates a new Produto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Produto();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $imageFile = UploadedFile::getInstance($model, 'image');
                if (isset($imageFile->size)){
                    $imageFile->saveAs('imgs/'.$imageFile->baseName.'.'.$imageFile->extension);
                    $model->image = $imageFile->baseName.'.'.$imageFile->extension;
                }
            }
            if ($this->request->post('addToStoreCheckbox') == '1') {
                $model->id_loja = Loja::find()->one()->id;
            }
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Produto criado com sucesso');
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Produto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imageModel = $model->image;

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
                    Yii::$app->session->setFlash('sucess', 'Produto editado com sucesso');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                Yii::$app->session->setFlash('error', 'Erro ao editar Produto');
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Produto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDelFromStore($id_produto, $id_loja)
    {
        $product = $this->findModel($id_produto);

        $product->id_loja = null;
        $product->save();

        return $this->redirect(['loja/view', 'id' => $id_loja]);
    }

    /**
     * Finds the Produto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Produto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Produto::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
