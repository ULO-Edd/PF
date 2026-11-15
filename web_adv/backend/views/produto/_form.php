<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */
/** @var yii\widgets\ActiveForm $form */

?>

<div class="produto-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->id == null){ ?>
    <p>
        <?= Html::input('checkbox', 'addToStoreCheckbox', true) ?>
        <?= Html::label('Adicionar a loja') ?>
    </p>
    <?php } ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true])->label('Descrição') ?>

    <?= $form->field($model, 'quantidade')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'points')->textInput()->label('Pontos') ?>

    <?= $form->field($model, 'image')->fileInput()->label('Imagem') ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
