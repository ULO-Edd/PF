<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TopicoReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="topico-report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'topico')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
