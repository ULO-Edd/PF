<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\jui\DatePicker;
use borales\extensions\phoneInput\PhoneInput;


$this->title = 'Registar';

?>
<div class="site-signup">
    <div class="background-image" style="background-image: url('../imgs/park-signup.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Registo</h1>
    </div>

    <div class="form-page">
        <div id="form">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Preencha os seguintes campos:</p>


            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Nome') ?>

                <?= $form->field($model, 'lastname')->textInput(['autofocus' => true])->label('Apelido') ?>

                <?= $form->field($model, 'birthday_date')->widget(DatePicker::classname(),['dateFormat' => 'yyyy-MM-dd'])->label('Data de Nascimento') ?>

                <?= $form->field($model, 'telephone')->widget(PhoneInput::className(), ['jsOptions' => ['onlyCountries' => ['pt']]])->label('Telefone') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="btn-styled">
                    <?= Html::submitButton('Registar', ['name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
