<?php

namespace api\modules\v1\controllers;

use common\models\Pessoa;
use common\models\User;
use Yii;
use yii\web\response;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Controller;


class AuthController extends Controller
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                if ($user && $user->validatePassword($password) && Yii::$app->response->statusCode == 200) {
                    return $user;
                }
            },
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $user = User::findOne(['id' => Yii::$app->user->id]);
        $userPessoa = Pessoa::findOne(['id' => $user->id]);
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = ['user' => ['id' => $user->id, 'username' => $user->username, 'email' => $user->email], 'pessoa' => $userPessoa];

        return $response;



    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
    }

}