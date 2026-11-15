<?php

namespace frontend\controllers;


use common\models\Atividade;
use common\models\Cupoes;
use common\models\Historico;
use frontend\models\UpdateUserForm;
use common\models\User;
use common\models\Pessoa;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update', 'history', 'favoritos'],
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
            ];
    }



    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model =  new UpdateUserForm();
        $model->findUserPessoa(Yii::$app->user->getId());

        $pessoa = Pessoa::findOne(['id' => Yii::$app->user->getId()]);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->update(Yii::$app->user->getId())) {
            Yii::$app->session->setFlash('success', 'Perfil editado com sucesso');
            return $this->goHome();
        }

        $model->telephone= '+351' . $model->telephone;

        return $this->render('/user/update', [
            'model' => $model,
            'pessoa' => $pessoa,
        ]);
    }

    public function actionHistory()
    {
        $pessoa = Pessoa::findOne(['id' => Yii::$app->user->getId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => Historico::find()->where(['id_user' => $pessoa->id]),
            'sort' => [
                'defaultOrder' => [
                    'data' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('history', [
            'pessoa' => $pessoa,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFavoritos()
    {
        $user = User::findOne(Yii::$app->user->getId());
        $pessoa = Pessoa::findOne(['id' => $user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $user->getAtividades(),
        ]);

        return $this->render('favoritos', [
            'pessoa' => $pessoa,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*
    public function actionDelete($id)
    {
        $pessoa = Pessoa::findOne(['id' => $id]);

        $tickets = Ticket::findAll(['id_pessoa' => $pessoa->id]);
        foreach ($tickets as $ticket)
        {
            $atividadesTicket = ActivitiesTicket::findAll(['id_ticket' => $ticket->id]);
            foreach ($atividadesTicket as $atividade)
            {
                $atividade->delete();
            }
            $ticket->delete();
        }

        $pessoa->delete();

        $favoritos = Favorito::findAll(['id_user' => $id]);
        foreach ($favoritos as $favorito)
        {
            $favorito->delete();
        }


        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('sucess', 'User eliminado com sucesso');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Erro ao eliminar o user');
        return $this->redirect(['index']);
    }
*/

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /*
    protected function findModelPessoa($id)
    {
        $sql = (new \yii\db\Query())  // SELECT * FROM pessoa WHERE id_user = $id;
            ->select('*')
            ->from('pessoa')
            ->where('id_user=:id', [':id' => $id])
            ->all();


        if (($model = Pessoa::findall($sql)) !== null){
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    */
}
