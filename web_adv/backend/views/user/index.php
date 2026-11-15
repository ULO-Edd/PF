<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Utilizadores';
?>
<div style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar Utilizador', ['user/createuser'], ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'pessoa.name',
            'pessoa.lastname',

            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 10%'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        if ($model->id != Yii::$app->user->id) {
                            return Html::a('Ver User &raquo;', ['user/view', 'id' => $model->id], ['class' => 'btn btn-info']);
                        } else {
                            return Html::a('Ver User &raquo;', ['user/profile'], ['class' => 'btn btn-info']);
                        }
                    },
                    'update' => function ($url, $model, $key) {
                        return '';
                    },
                    'delete' => function ($url, $model, $key) {
                        return '';
                    },
                ]
            ],
        ],
    ]); ?>


</div>
