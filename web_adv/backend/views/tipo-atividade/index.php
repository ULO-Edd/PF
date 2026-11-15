<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/** @var common\models\TipoAtividade $model */

$this->title = 'Tipo de Atividades';

if(is_null($idta) == false){
    $modelUpdate = \common\models\TipoAtividade::findOne(['id' => $idta]);
}
?>
<div class="tipo-atividade-index" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Criar Tipo de Atividade', ['class' => 'btn btn-primary', 'style' => 'background: #03A9F4; border-color: #0094d7', 'type' => 'button', 'onclick' => "createForm()"]) ?>
    </p>

    <div id="create-form" style="display: none">
        <?php $form = ActiveForm::begin(['action' => 'create']); ?>

        <?= $form->field($model, 'tipo')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <script>
        function createForm() {
            var div = document.getElementById("create-form");
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tipo',

            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 10%'],
                'buttons' => [
                'view' => function($url, $model, $key){
                    return '';
                },
                'update' => function($url, $model, $key){
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['tipo-atividade/index', 'idta' => $model->id]  );
                },],
            ]
        ]
    ]); ?>

    <?php if(is_null($idta) == false){ ?>
        <div id="update-form">
            <?php $form = ActiveForm::begin(['action' => 'update?id=' . $idta]); ?>

            <?= $form->field($modelUpdate, 'tipo')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php } ?>

</div>
