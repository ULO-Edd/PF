<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Evento $model */
/** @var common\models\News $novidade */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="evento-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'designacao')->textInput(['maxlength' => true])->label('Designação') ?>

    <?= $form->field($model, 'descricao')->textArea(['maxlength' => true])->label('Descrição') ?>

    <?= $form->field($model, 'data_inicio')->widget(DatePicker::className(),[ 'dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['changeMonth' => true, 'yearRange' => '2021:2023', 'changeYear' => true]]) ?>

    <?= $form->field($model, 'data_conclusao')->widget(DatePicker::className(),[ 'dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['changeMonth' => true, 'yearRange' => '2021:2023', 'changeYear' => true]]) ?>

    <?= $form->field($model, 'pontos_participacao')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'image')->fileInput()->label('Imagem') ?>

    <p>
        <?= Html::a('Adicionar uma Atividade ao Evento', ['atividade/index','ide' => $model->id], ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
    </p>

    <?php if($model->ativo == 0){ ?>
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
