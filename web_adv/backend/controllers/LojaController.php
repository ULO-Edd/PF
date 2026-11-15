<?php

namespace backend\controllers;

use Codeception\Test\Loader;
use common\models\Loja;
use common\models\Produto;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LojaController implements the CRUD actions for Loja model.
 */
class LojaController extends BaseController
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
     * Displays a single Loja model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $loja = Loja::find()->one();

        if($loja != null){
            $dataProvider = new ActiveDataProvider([
                'query' => $loja->getProdutos(),
            ]);
            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'model' => $loja,
            ]);
        }

        return $this->redirect(['create']);
    }

    /**
     * Creates a new Loja model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $loja = Loja::find()->one();

        if($loja == null){
            $model = new Loja();
            $products = new ActiveDataProvider([
                'query' => Produto::find(),
            ]);

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    foreach($this->request->post() as $key => $value){
                        if(is_string($key) && str_contains($key, 'checkbox')){
                            $productId = substr($key, 8);
                            $produto = Produto::findOne(['id' => $productId]);
                            $produto->id_loja = $model->id;
                            $produto->save();
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'products' => $products,
                'model' => $model,
            ]);
        }
        return $this->redirect(['view']);
    }

    /**
     * Updates an existing Loja model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $loja = Loja::find()->one();
        if($loja != null) {
            if ($this->request->isPost && $loja->load($this->request->post()) && $loja->save()) {
                return $this->redirect(['view', 'id' => $loja->id]);
            }

            return $this->render('view', [
                'model' => $loja,
            ]);
        }
        $this->redirect(['create']);
    }

    public function actionAddProducts(){
        $loja = Loja::find()->one();

        if($loja != null){
            if ($this->request->isPost) {
                foreach($this->request->post() as $key => $value){
                    if(is_string($key) && str_contains($key, 'checkbox')){
                        $productId = substr($key, 8);
                        $produto = Produto::findOne(['id' => $productId]);
                        $produto->id_loja = $loja->id;
                        $produto->save();
                    }
                }
                return $this->redirect(['view', 'id' => $loja->id]);
            }

            return $this->render('view', [
                'model' => $loja,
            ]);
        }
        $this->redirect(['create']);
    }

    /**
     * Deletes an existing Loja model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        $loja = Loja::find()->one();
        if($loja != null) {
            foreach($loja->produtos as $produto){
                $produto->id_loja = null;
                $produto->save();
            }
            $loja->delete();
        }
        return $this->redirect(['create']);
    }

    /**
     * Finds the Loja model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Loja the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Loja::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
