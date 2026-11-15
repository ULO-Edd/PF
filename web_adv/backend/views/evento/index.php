<?php

use common\models\Evento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Eventos';
?>
<div class="evento-index" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => 'Não existem eventos',
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

            'designacao',
            [
                'attribute' => 'descricao',
                'label' => 'Descrição',
                'options' => ['style' => 'width: 50%'],
            ],
            'data_inicio',
            'data_conclusao',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Evento $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
