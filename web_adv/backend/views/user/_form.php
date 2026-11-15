<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model backend\models\UpdateUserForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row" >
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'telephone')->widget(PhoneInput::className(), ['jsOptions' => ['onlyCountries' => ['pt']]]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'role')->dropDownList(array('client' => 'cliente', 'manager' => 'manager', 'admin' => 'admin'))->label('roles')?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
