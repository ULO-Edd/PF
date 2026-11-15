<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Loja $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="loja-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'designacao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
    </div>

    <div style="display: flex; justify-content: center; text-align: center">
        <div style="width: 75%">
    <?= GridView::widget([
        'dataProvider' => $products,
        'summary' => '',
        'emptyText' => 'Não existe produtos',
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
                'template'=>'{select}',
                'options' => ['style' => 'width: 5%'],
                'buttons'=>[
                    'select' => function ($url, $model, $key) {
                        return Html::checkbox('checkbox' . $model->id, false);
                    }
                ],
            ],
        ],
    ]); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
