<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Atividade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atividade-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_tipo_atividade')->dropDownList($tipoAtividade,['prompt'=>'Escolha Tipo de Atividade'])->label('Tipo de Atividade'); ?>

    <?= $form->field($model, 'designacao')->textInput(['maxlength' => true])->label('Designação') ?>

    <?= $form->field($model, 'descricao')->textArea(['maxlength' => true])->label('Descrição') ?>

    <?= $form->field($model, 'lotacao')->textInput()->label('Lotação') ?>

    <?= $form->field($model, 'image')->fileInput()->label('Imagem') ?>

    <?php if($model->id == null){ ?>
        <p>
            <?= Html::input('checkbox', 'novidadeCheckbox', true, ['id' => 'novidadeCheckbox', 'onclick' => 'handleChange()']) ?>
            <?= Html::label('Criar Novidade apos criação de evento') ?>
        </p>

        <div id="novidade-form" style="display: none; width: 80%">
            <?= $form->field($novidade, 'titulo')->textInput(['maxlength' => true]) ?>

            <?= $form->field($novidade, 'descricao')->textInput(['maxlength' => true]) ?>

            <?= $form->field($novidade, 'date_expire')->widget(DatePicker::classname(),['dateFormat' => 'yyyy-MM-dd'])->label('Data de validade')?>

            <?= $form->field($novidade, 'image')->fileInput()->label('Imagem') ?>
        </div>
    <?php } ?>

    <script>
        function handleChange() {
            var checkBox = document.getElementById("novidadeCheckbox")
            var div = document.getElementById("novidade-form");
            if (checkBox.checked === true) {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
