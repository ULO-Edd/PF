<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$this->title = 'Bilhete de '.$model->pessoa->user->username;
?>
<div class="ticket-view" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if($model->anulado == 1){ ?>
        <p style="font-weight: bold">ANULADO</p>
    <?php }else if($model->expirado == 1){ ?>
        <p style="font-weight: bold">EXPIRADO</p>
    <?php } ?>


    <p>
        <?php if(Yii::$app->user->can('seeUser')) {
        echo Html::a('Ver Utilizador', ['user/view', 'id' => $model->pessoa->id], ['class' => 'btn btn-primary']);
        } ?>
        <?php if ($model->anulado == 0 && $model->expirado == 0) {
            echo Html::a('Anular', ['anular', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Tem a certeza que pretende anular este Bilhete?',
                    'method' => 'post',
                ],
            ]);
        }?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'pessoa.name', 'label' => 'Nome'],
            ['attribute' => 'data_de_compra', 'label' => 'Data de compra'],
            ['attribute' => 'data_de_uso', 'label' => 'Data de uso'],
            ['value' => $model->preco . " €", 'label' => 'Preço'],
    ]
    ]) ?>
<div style="margin-top: 80px;  border-bottom-style: solid; margin-bottom: 30px ">
    <h1>Atividades do Bilhete</h1>
</div>
    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => 'Não existe atividades ligadas a este bilhete',
        'summary' => '',
        'itemView' => function ($model, $key, $index, $widget){
            return $this->render('list_section_tickets',['model' => $model]);
        },
    ]);
    ?>

</div>
