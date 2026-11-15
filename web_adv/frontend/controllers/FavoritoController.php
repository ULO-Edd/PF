<?php

namespace frontend\controllers;

use common\models\Favorito;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FavoritoController extends Controller
{

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'adicionar', 'remover'],
                            'allow' => true,
                            'roles' => ['client'],
                        ]
                    ]
                ]
            ]
        );
    }

    public function actionAdicionar($idUser, $idAtividade){
        if(Favorito::findOne(['id_user' => $idUser, 'id_atividade' => $idAtividade]))
        {
            Yii::$app->session->setFlash('error', 'Atividade ja adicionada aos favoritos');
            return $this->goHome();
        }
        $newFavorito = new Favorito();

        $newFavorito->id_user = $idUser;
        $newFavorito->id_atividade = $idAtividade;

        if ($newFavorito->validate() && $newFavorito->save())
        {
            Yii::$app->session->setFlash('success', 'Atividade adicionada aos favoritos');
            return $this->redirect('../user/favoritos');
        }

        Yii::$app->session->setFlash('error', 'Erro ao adicionar aos favoritos');
        return $this->goBack();
    }

    public function actionRemover($idUser, $idAtividade){
        $atividadeFavorita = Favorito::findOne(['id_user' => $idUser, 'id_atividade' => $idAtividade]);

        $atividadeFavorita->delete();

        Yii::$app->session->setFlash('success', 'Atividade removida dos favoritos');
        return $this->redirect('../user/favoritos');
    }


    protected function findModel($idUser, $idAtividade)
    {
        if (($model = Favorito::findOne(['id_user' => $idUser, 'id_atividade' => $idAtividade])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
