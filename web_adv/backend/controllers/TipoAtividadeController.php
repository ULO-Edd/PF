<?php

namespace backend\controllers;

use common\models\Atividade;
use common\models\Favorito;
use common\models\TipoAtividade;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipoAtividadeController implements the CRUD actions for TipoAtividade model.
 */
class TipoAtividadeController extends BaseController
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
     * Lists all TipoAtividade models.
     *
     * @return string
     */
    public function actionIndex($idta = null)
    {
        $model = new TipoAtividade();

        $dataProvider = new ActiveDataProvider([
            'query' => TipoAtividade::find(),

        ]);

        return $this->render('index', [
            'model' => $model,
            'idta' => $idta,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TipoAtividade model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $tipoAtividade = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $tipoAtividade->getAtividades(),
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

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TipoAtividade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new TipoAtividade();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('sucess', 'Tipo de Atividade criada com sucesso');
                    return $this->redirect(['index']);
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Erro ao criar Tipo de Atividade');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing TipoAtividade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('sucess', 'Tipo de Atividade editada com sucesso');
                return $this->redirect('index');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Erro ao editar Tipo de Atividade');
                return $this->redirect('index');
            }
        }
        return $this->redirect('index');
    }

    /**
     * Deletes an existing TipoAtividade model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $atividades = Atividade::findAll(['id_tipo_atividade' => $id]);
        foreach ($atividades as $atividade)
        {
            $favoritos = Favorito::findAll(['id_atividade' => $atividade->id]);
            foreach ($favoritos as $favorito)
            {
                $favorito->delete();
            }
            $atividade->delete();
        }

        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('sucess', 'Tipo de Atividade eliminado com sucesso');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Erro ao eliminar Tipo de Atividade');
        return $this->redirect(['index']);
    }

    /**
     * Finds the TipoAtividade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TipoAtividade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TipoAtividade::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
