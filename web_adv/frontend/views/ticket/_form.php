<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(['id' => 'ticket-buy-form']); ?>


    <div class="btn-styled">
    <?php
    if($model->containsFavorites() == false) {
        echo Html::a('Adicionar Atividades Favoritas ao Bilhete', ['atividades-ticket/adicionar-all', 'idUser' => Yii::$app->user->getId(), 'idTicket' => $model->id, 'indexTicket' => 0]);
    }?>

    <?= Html::a('Adicionar uma Atividade ao Bilhete', ['atividade/index','idTicket' => $model->id]) ?>
    </div>

    <?= $form->field($model, 'data_de_uso')->widget(DatePicker::className(),[ 'dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['changeMonth' => true, 'yearRange' => '2021:2023', 'changeYear' => true]]) ?>

    <?php
    if (sizeof($model->activities) != 0) {
        $model->preco = (sizeof($model->activities) * 3)?>
            Preço:
        <p style="font-size: 20px; color: red"><?= $model->preco . '€' ?></p>
    <?php } ?>



    <div class="btn-styled">
        <?= Html::submitButton('Comprar') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
