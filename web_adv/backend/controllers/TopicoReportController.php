<?php

namespace backend\controllers;

use common\models\Reports;
use common\models\TopicoReport;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TopicoReportController implements the CRUD actions for TopicoReport model.
 */
class TopicoReportController extends BaseController
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
     * Lists all TopicoReport models.
     * @return mixed
     */
    public function actionIndex($idtr = null)
    {
        $model = new TopicoReport();

        $dataProvider = new ActiveDataProvider([
            'query' => TopicoReport::find(),

        ]);

        return $this->render('index', [
            'model' => $model,
            'idtr' => $idtr,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new TopicoReport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TopicoReport();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('sucess', 'Topico criado com sucesso');
                    return $this->redirect(['index']);
                }
                else
                {
                    Yii::$app->session->setFlash('error', 'Erro ao criar Topico');
                    return $this->redirect(['index']);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->redirect(['index']);
    }

    /**
     * Updates an existing TopicoReport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('sucess', 'Topico editado com sucesso');
                return $this->redirect('index');
            }
            else
            {
                Yii::$app->session->setFlash('error', 'Erro ao editar Topico');
                return $this->redirect('index');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing TopicoReport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $reports = Reports::findAll(['id_topico' => $id]);
        foreach ($reports as $report)
        {
            $report->delete();
        }


        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('sucess', 'Topico eliminado com sucesso');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Erro ao eliminar o Topico');
        return $this->redirect(['index']);
    }

    /**
     * Finds the TopicoReport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return TopicoReport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TopicoReport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
