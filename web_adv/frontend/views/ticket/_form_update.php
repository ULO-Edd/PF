<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */
/* @var $form yii\widgets\ActiveForm */

$result = $model->containsFavorites();

$preco = 0;
?>

<div class="ticket-form">

    <?php $form = ActiveForm::begin(); ?>


    <div class="btn-styled">
    <?php
    if($model->anulado == 1 && $model->numero_atividades > sizeof($model->activities)) {
        if ($result == false) {
            echo Html::a('Adicionar Atividades Favoritas ao Bilhete', ['atividades-ticket/adicionar-all', 'idUser' => Yii::$app->user->getId(), 'idTicket' => $model->id, 'indexTicket' => $indexTicket]);
        } ?>
        <?= Html::a('Adicionar uma Atividade ao Bilhete', ['atividade/index','idTicket' => $model->id, 'indexTicket' => $indexTicket]) ?>
    <?php }else if($model->expirado == 1){
        if ($result == false) {
            echo Html::a('Adicionar Atividades Favoritas ao Bilhete', ['atividades-ticket/adicionar-all', 'idUser' => Yii::$app->user->getId(), 'idTicket' => $model->id, 'indexTicket' => $indexTicket]);
        }?>
        <?= Html::a('Adicionar uma Atividade ao Bilhete', ['atividade/index','idTicket' => $model->id, 'indexTicket' => $indexTicket]) ?>
    <?php }?>

    </div>

    <?= $form->field($model, 'data_de_uso')->widget(DatePicker::className(),[ 'dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['changeMonth' => true, 'yearRange' => '2021:2023', 'changeYear' => true]]) ?>

    <?php
    if($model->expirado == 1){
    if (sizeof($model->activities) != 0) {
        $preco = (sizeof($model->activities) * 3)?>
            Preço:
        <p style="font-size: 20px; color: red"><?= $preco . '€' ?></p>
    <?php }} ?>



    <div class="btn-styled">
        <?php if($model->expirado == 1){ ?>
            <?= Html::submitButton('Renovar') ?>
        <?php }else if($model->anulado == 1){ ?>
            <?= Html::submitButton('Editar') ?>
        <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
