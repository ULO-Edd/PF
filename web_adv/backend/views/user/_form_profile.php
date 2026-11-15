<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\UpdateUserForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="row" >
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'name')->textInput()->label('Nome') ?>

        <?= $form->field($model, 'lastname')->textInput()->label('Apelido') ?>

        <?= $form->field($model, 'telephone')->widget(PhoneInput::className(), ['jsOptions' => ['onlyCountries' => ['PT'], 'defaultCountry' => ['PT']]])->label('Telefone') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'image')->fileInput()->label('Imagem') ?>

    <div class="btn-styled">
        <?= Html::submitButton('Guardar') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
