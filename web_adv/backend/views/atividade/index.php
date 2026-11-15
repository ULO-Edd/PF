<?php

use common\models\Evento;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Atividades';
?>
<div class="atividade-index" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'html',
                'label' => 'Images',
                'value' => function ($data) {
                    return Html::img('../imgs/'. $data['image'],
                        ['width' => '100px']);
                },
            ],
            [
                'label' => 'Tipo de Atividade',
                'value' => 'tipoAtividade.tipo',
            ],
            'designacao',
            'lotacao',
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {addToEvento}',
                'options' => ['style' => 'width: 7%'],
                'buttons'=>[
                    'addToEvento' => function ($url, $model, $key) {
                        $idEvento = Yii::$app->request->get('ide');
                        if($idEvento != null){
                            $evento = Evento::findOne(['id' => $idEvento]);

                            $contains = null;

                            foreach ($evento->atividades as $atividade){
                                if($atividade->id == $model->id){
                                    $contains = true;
                                }
                            }
                            if($contains != true) {
                                return Html::a('<i class="fa fa-check-square"></i>', ['atividade/add-to-event', 'id_atividade' => $model->id, 'id_evento' => $idEvento], ['style' => 'font-size: 20px']);
                            }
                        }
                        return null;


                    }
                ],
            ],
        ]]); ?>
</div>
