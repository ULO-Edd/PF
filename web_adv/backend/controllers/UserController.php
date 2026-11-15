<?php

namespace backend\controllers;

use backend\models\CreateUserForm;
use backend\models\UpdateUserForm;
use common\models\ActivitiesTicket;
use common\models\Favorito;
use common\models\Ticket;
use common\models\User;
use common\models\Pessoa;
use Yii;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\rbac\Role;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['profile'],
                    'allow' => true,
                    'roles' => ['manager']
                ],
                [
                    'allow' => true,
                    'roles' => ['admin']
                ],
            ],
        ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }



    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('/user/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
            $user = $this->findModel($id);
            $modelUpdate = new UpdateUserForm();
            $auth = Yii::$app->authManager;
            $userCargo = $auth->getRolesByUser($id);
            $cargo = null;


            foreach ($userCargo as $role){
                $cargo = $role->name;
            }


            $dataProvider = new ActiveDataProvider([
                'query' => $user->pessoa->getTickets(),
            ]);

            return $this->render('view', [
                'model' => $this->findModel($id),
                'modelUpdate' => $modelUpdate,
                'role' => $cargo,
                'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreateuser()
    {
        $model = new CreateUserForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', 'Utilizador registado');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model =  new UpdateUserForm();;


        if ($this->request->isPost && $model->load($this->request->post()) && $model->update($id)) {
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->redirect('index');
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
        if($pessoa != null) {
            $tickets = Ticket::findAll(['id_pessoa' => $pessoa->id]);
            foreach ($tickets as $ticket) {
                $atividadesTicket = ActivitiesTicket::findAll(['id_ticket' => $ticket->id]);
                foreach ($atividadesTicket as $atividade) {
                    $atividade->delete();
                }
                $ticket->delete();
            }

            $pessoa->delete();

            $favoritos = Favorito::findAll(['id_user' => $id]);
            foreach ($favoritos as $favorito) {
                $favorito->delete();
            }
        }


        if ($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('sucess', 'User eliminado com sucesso');
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'Erro ao eliminar o user');
        return $this->redirect(['index']);
    }
    */

    public function actionDeactivate($id)
    {
        $user = $this->findModel($id);
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($id);
        $isAdmin = false;

        foreach ($roles as $role){
            if($role->name == "admin"){
                $isAdmin = true;
            }
        }

        if ($isAdmin == false) {
            $user->status = 9;

            if ($user->save()) {
                $tickets = Ticket::findAll(['id_pessoa' => $id]);
                foreach ($tickets as $ticket) {
                    $ticket->expirado = 0;
                    $ticket->anulado = 1;
                    $ticket->save();
                }
                Yii::$app->session->setFlash('success', 'Utilizador desativado com sucesso');
                return $this->redirect(['index']);
            }
        }
        Yii::$app->session->setFlash('error', 'Erro ao desativar o user');
        return $this->redirect(['index']);
    }

    public function actionReactivate($id)
    {
        $user = $this->findModel($id);
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($id);
        $isAdmin = false;

        foreach ($roles as $role){
            if($role->name == "admin"){
                $isAdmin = true;
            }
        }

        if ($isAdmin == false) {
            $user->status = 10;

            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Utilizador ativado com sucesso');
                return $this->redirect(['index']);
            }

        }
        Yii::$app->session->setFlash('error', 'Erro ao desativar o user');
        return $this->redirect(['index']);
    }

    public function actionProfile()
    {
        $model =  new \frontend\models\UpdateUserForm();
        $model->findUserPessoa(Yii::$app->user->getId());

        $pessoa = Pessoa::findOne(['id' => Yii::$app->user->getId()]);

        if ($this->request->isPost && $model->load($this->request->post())){
            $imageFile = UploadedFile::getInstance($model, 'image');
            if (isset($imageFile->size)) {
                $imageFile->saveAs('imgs/' . $imageFile->baseName . '.' . $imageFile->extension);
                $model->image = $imageFile->baseName . '.' . $imageFile->extension;
            }
            if ($model->update(Yii::$app->user->getId())) {
                Yii::$app->session->setFlash('success', 'Perfil editado com sucesso');
                return $this->goHome();
            }
        }

        $model->telephone= '+351' . $model->telephone;

        return $this->render('/user/profile', [
            'model' => $model,
            'pessoa' => $pessoa,
        ]);
    }

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
