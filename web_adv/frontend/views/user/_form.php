<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model backend\models\UpdateUserForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row" >
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Nome de Utilizador') ?>

        <?= $form->field($model, 'name')->textInput()->label('Nome') ?>

        <?= $form->field($model, 'lastname')->textInput()->label('Apelido') ?>

        <?= $form->field($model, 'telephone')->widget(PhoneInput::className(), ['jsOptions' => ['onlyCountries' => ['pt']]])->label('Telefone') ?>

        <?= $form->field($model, 'email') ?>

    <div class="btn-styled">
        <?= Html::submitButton('Guardar') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
