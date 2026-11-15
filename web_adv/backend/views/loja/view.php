<?php

use common\models\Produto;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\Loja $model */

$this->title = $model->designacao;
$storeID = $model->id;
?>
<div class="loja-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button("Alterar o nome da loja", ['class' => 'btn btn-primary', 'type' => 'button', 'onclick' => "updateForm()"]) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'De certeza que pretende eliminar esta loja?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div id="update-form" style="display: none">
        <?php $form = ActiveForm::begin(['action' => 'update?id=' . $model->id]); ?>

        <?= $form->field($model, 'designacao')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <script>
        function updateForm() {
            var div = document.getElementById("update-form");
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
        }
    </script>

    <div style="margin-top: 20px" id="loja-produtos">
    <h1>Produtos</h1>
        <p>
            <?= Html::a('Adicionar mais produtos', ['produto/index', 'idl' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => 'Não possui produtos',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'image',
                'format' => 'html',
                'label' => 'Images',
                'value' => function ($data) {
                    return Html::img('../imgs/'. $data['image'],
                        ['width' => '100px']);
                },
            ],
            'descricao',
            'quantidade',
            'points',
            [
                'class' => ActionColumn::className(),
                'template'=>'{deleteFromStore}',
                'options' => ['style' => 'width: 5%'],
                'buttons'=>[
                    'deleteFromStore' => function ($url, $model, $key) use ($storeID) {
                        return Html::a('<i class="fa fa-trash"></i>', ['produto/del-from-store', 'id_produto' => $model->id, 'id_loja' => $storeID], ['style' => 'font-size: 20px']);
                    }
                ],
            ],
        ],
    ]); ?>
    </div>
</div>
