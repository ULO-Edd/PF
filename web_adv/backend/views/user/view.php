<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $modelUpdate backend\models\UpdateUserForm */
// /* @var $modelPessoa common\models\Pessoa */

$this->title = "Utilizador: " . $model->pessoa->name;

?>
<div class="user-view" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= 'Role: ' . $role ?>
    </p>

    <div style="display: flex">
        <?php
        if(Yii::$app->user->can('editUser') && $model->id != Yii::$app->user->id){ ?>
            <p>
                <?= Html::button("Alterar Role", ['class' => 'btn btn-primary', 'style' => 'background: #03A9F4; border-color: #0094d7', 'type' => 'button', 'onclick' => "updateRole()"]) ?>
            </p>
        <?php } ?>
    <p>
        <?php
        if($model->id != Yii::$app->user->id){
            if($model->status != 9){
        echo Html::a('Desativar', ['deactivate', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que pretende desativar este utilizador?',
                'method' => 'post',
            ],
        ]);
        }else{
            echo Html::a('Reativar', ['reactivate', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => 'Tem a certeza que pretende ativar este utilizador?',
                    'method' => 'post',
                ],
            ]);
        }} ?>
    </p>
    </div>

    <div id="update-form" style="display: none; margin-bottom: 10px">
        <?php $form = ActiveForm::begin(['action' => 'update?id=' . $model->id]); ?>

        <?= $form->field($modelUpdate, 'role')->dropDownList(array('client' => 'cliente', 'manager' => 'manager', 'admin' => 'admin'))->label('Role')?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success', 'style' => 'background: #03A9F4; border-color: #0094d7']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <script>
        function updateRole() {
            var div = document.getElementById("update-form");
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            ['attribute' => 'pessoa.name','label' => 'Nome'],
            ['attribute' => 'pessoa.lastname','label' => 'Apelido'],
            'email:email',
            ['attribute' => 'pessoa.telephone', 'label' => 'Telemóvel'],
        ],
    ]) ?>
</div>
<div style="margin-top: 50px; margin-left: 100px; margin-right: 100px">
    <h1><?= Html::encode('Bilhetes de ' . $model->pessoa->name) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => 'Sem Bilhetes',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'data_de_compra', 'label' => 'Data de compra'],
            ['attribute' => 'data_de_uso', 'label' => 'Data de uso'],
            ['attribute' => 'preco', 'label' => 'Preço'],

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                    'view' => function($url, $model, $key){
                        return Html::a('Ver Bilhete &raquo;', ['ticket/view', 'id' => $model->id], ['class' => 'btn btn-outline-secondary']);
                    },
                    'update' => function($url, $model, $key){
                        return '';
                    },
                    'delete' => function($url, $model, $key){
                        return '';
                    },
                ]
            ],
        ],
    ]); ?>
</div>

