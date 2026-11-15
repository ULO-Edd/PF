<?php
namespace api\modules\v1\controllers;

use common\models\Loja;
use yii\rest\ActiveController;

class LojaController extends  ActiveController
{
    public $modelClass = 'common\models\Loja';

    public function actionProdutos()
    {
        $loja = Loja::find()->one();

        $produtos = [];

        foreach ($loja->produtos as $produto) {
            $produtos[] = ['produto' => $produto];
        }

        if ($produtos != null) {
            return [
                'Loja' => $loja,
                'Produtos' => $produtos,
            ];
        }

        return ['Produtos' => "Não possui produtos"];

    }
}