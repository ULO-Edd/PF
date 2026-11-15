<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sugestões';
?>
<div class="reports-index" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Tópico de Sugestão',
                'value' => 'topico.topico',
            ],
            [
                'label' => 'Descrição',
                'value' => 'descricao',
                'options' => ['style' => 'width: 70%'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 10%'],
                'buttons' => [
                    'view' => function($url, $model, $key){
                        return '';
                    },
                    'update' => function($url, $model, $key){
                        return '';
                    },
                    'delete' => function($url, $model, $key){
                        return Html::a('Eliminar Sugestão', ['report/delete', 'id' => $model->id], ['class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Tem mesmo a certeza que pretende eliminar esta sugestão?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                ]],
        ],
        'emptyText' => 'Sem Sugestões',
    ]); ?>


</div>
