<?php
namespace api\modules\v1\controllers;

use backend\models\UpdateUserMobile;
use common\models\User;
use common\models\Atividade;
use common\models\Favorito;
use common\models\Pessoa;
use common\models\Ticket;
use frontend\models\SignupForm;
use Yii;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

class UserController extends  ActiveController
{
    public $modelClass = 'common\models\User';

    public function actionTickets($id)
    {
        $tickets = Ticket::findAll(['id_pessoa' => $id]);

        if ($tickets != null) {
            return [
                'id do user' => $id,
                'Ticket' => $tickets,
            ];
        }

        return ['id do user' => $id, 'Ticket' => "Não possui tickets"];

    }

    public function actionFavoritos($id)
    {
        $favoritos_user = Favorito::findAll(['id_user' => $id]);

        $favoritos = [];

        foreach ($favoritos_user as $favorito) {
            $favoritos[] = ['atividade' => Atividade::findOne(['id' => $favorito->id_atividade]), 'tipo_atividade' => Atividade::findOne(['id' => $favorito->id_atividade])->tipoAtividade->tipo];
        }

        if ($favoritos != null) {
            return [
                'id_user' => $id,
                'Favoritos' => $favoritos,
            ];
        }

        return ['id do user' => $id, 'Favorito' => "Não possui favoritos"];

    }

    public function actionModify($id)
    {
        $modify = new UpdateUserMobile();
        $modify->setAttributes(Yii::$app->request->post());
        $modify->id = $id;
        $modify->role = 'client';

        if ($modify->validate()) {
            $modify->update($id);
        } else {
            var_dump($modify->errors);
            die();
            throw new BadRequestHttpException('erro na validação');
        }
        return $modify;
    }

    public function actionGet($id)
    {
        $user = User::findOne(['id' => $id]);
        $pessoa = Pessoa::findOne(['id' => $id]);

        return ['user' => $user, 'pessoa' => $pessoa];
    }

    public function actionRegister()
    {
        $signup = new SignupForm();
        $signup->setAttributes(Yii::$app->request->post());

        if ($signup->validate()) {
            $signup->signup();
        } else {
            throw new BadRequestHttpException('erro na validação');
        }

        return $signup;
    }

    public function actionRemovefav($user_id, $atividade_id)
    {
        $favorito = Favorito::findOne(['id_user' => $user_id, 'id_atividade' => $atividade_id]);

        if ($favorito != null)
        {
            $favorito->delete();
            return ['response' => true] ;
        }
        return ['response' => false] ;
    }

    public function actionAddfav($user_id, $atividade_id)
    {
        $new_favorito = new Favorito();

        $new_favorito->id_user = $user_id;
        $new_favorito->id_atividade = $atividade_id;

        if ($new_favorito->validate()) {
            if ($new_favorito->save()) {
                return $new_favorito;
            }

        }
        return false;
    }


    /*
    public function actionParticipar($id_user, $id_atividade)
    {
        $new_Participacao = new  Participar();

        $new_Participacao->id_user = $id_user;
        $new_Participacao->id_atividade = $id_atividade;

        if ($new_Participacao->validate()) {
            $new_Participacao->save();
            return $new_Participacao;
        }
        return false;
    }

    public function actionDesparticipar($id_user, $id_atividade)
    {
        $participacao = Participar::findOne(['id_user' => $id_user, 'id_atividade' => $id_atividade]);

        if ($participacao != null)
        {
            $participacao->delete();
            return true;
        }
        return false;
    }*/
}