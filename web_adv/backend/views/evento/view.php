<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Evento $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $model->designacao;
?>
<div class="evento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?php if ($model->image != null){ ?>
        <div style="margin-bottom: 10px">
            <img src="../imgs/<?=$model->image?>"  style=" width: 275px">
        </div>
    <?php } ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'designacao',
            'descricao',
            'data_inicio',
            'data_conclusao',
        ],
    ]) ?>

    <div>
        <?php
        if($dataProvider != null && $dataProvider->totalCount != 0) {?>
            <h1>Atividades</h1>
            <div style="border-top-style: solid; border-width: 1px;">
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],

                        [
                            'attribute' => 'image',
                            'format' => 'html',
                            'label' => 'Images',
                            'value' => function ($data) {
                                return Html::img('../imgs/' . $data['image'],
                                    ['width' => '100px']);
                            },
                        ],
                        [
                            'label' => 'Designação',
                            'value' => 'designacao',
                        ],
                        [
                            'label' => 'Descrição',
                            'options' => ['style' => 'width: 30%'],
                            'value' => 'descricao',
                        ],
                        'lotacao',
                    ]]); ?>
            </div>
        <?php } ?>
    </div>

</div>
