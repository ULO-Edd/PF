<?php
namespace api\modules\v1\controllers;

use common\models\Evento;
use yii\rest\ActiveController;

class EventoController extends  ActiveController
{
    public $modelClass = 'common\models\Evento';

    public function actionAtividades($id)
    {
        $atividades_evento = Evento::findOne(['id' => $id])->atividades;

        $atividades = [];

        foreach ($atividades_evento as $atividade) {
            $atividades[] = ['atividade' => $atividade, 'tipo_atividade' => $atividade->tipoAtividade->tipo];
        }

        if ($atividades != null) {
            return [
                'Atividades' => $atividades,
            ];
        }

        return ['Atividades' => "Não possui atividades"];

    }

    public function actionLatest()
    {
        return ['Evento' => Evento::find()->orderBy(['id' => SORT_DESC])->one()];
    }
}