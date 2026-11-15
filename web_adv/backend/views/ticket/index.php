<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bilhetes';
?>
<div class="ticket-index" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'pessoa.user.username',
            'data_de_compra',
            'data_de_uso',
            'preco',

            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'view' => function($url, $model, $key){
                    return Html::a('Ver Ticket &raquo;', ['ticket/view', 'id' => $model->id], ['class' => 'btn btn-outline-secondary']);
                },
                'update' => function($url, $model, $key){
                    return '';
                },
                'delete' => function($url, $model, $key){
                    return '';
                },
            ]],
        ],
    ]); ?>


</div>
