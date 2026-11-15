<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Novidades';
?>
<div class="news-index" style="margin-left: 100px; margin-right: 100px">

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
            'titulo',
            'descricao',
            'date_expire',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
