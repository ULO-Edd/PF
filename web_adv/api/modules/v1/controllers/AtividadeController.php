<?php
namespace api\modules\v1\controllers;

use common\models\Atividade;
use yii\rest\ActiveController;

class AtividadeController extends  ActiveController
{
    public $modelClass = 'common\models\Atividade';

    public function actionGetall()
    {
        $atividades = Atividade::find()->all();
        $allAtividades = [];

        foreach ($atividades as $atividade)
        {
            $allAtividades[] = ['atividade' => $atividade, 'tipo_atividade' => $atividade->tipoAtividade->tipo];
        }

        if ($allAtividades != null)
        {
            return [
                'Atividades' => $allAtividades,
            ];
        }

        return ['Atividades' => "Sem atividades"];
    }
}