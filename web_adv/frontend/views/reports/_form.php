<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_topico')->dropDownList($topicoReport,['prompt'=>'Escolha o Tópico de Sugestão'])->label('Tópico de Sugestão'); ?>

    <?= $form->field($model, 'descricao')->textarea(['rows' => 6])->label('Descrição'); ?>

    <div class="btn-styled">
        <?= Html::submitButton('Guardar') ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
