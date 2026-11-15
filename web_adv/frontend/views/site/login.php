<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
?>
<div class="brisa-login">
    <div class="login-background-image" style="background-image: url('../imgs/park3.jpg')" id="login-image">


    </div>
    <div style="display: flex; justify-content: flex-end;height:100%">
        <div class="login-form">
            <h1 class="display-4" style="color: #0b58a2; font-size: 100px; margin-bottom: 20px"><?= Html::encode($this->title) ?></h1>
            <div class="login-form-inputs">
                <p>Preencha os seguintes campos:</p>
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Lembrar-me') ?>

                <div class="btn-styled">
                    <?= Html::submitButton('Login', ['id' => 'login', 'name' => 'login-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>