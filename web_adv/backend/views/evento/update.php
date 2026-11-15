<?php

use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Evento $model */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Editar Evento: ' . $model->designacao;
?>
<div class="evento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
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
                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{delete}',
                            'buttons' => [
                                'delete' => function ($url, $model, $key) {
                                    $idEvento = Yii::$app->request->get('id');
                                    return Html::a('<i class="fa fa-trash"></i>', ['activities-evento/remover', 'idEvento' => $idEvento, 'idActivity' => $model->id], [
                                        'data' => [
                                            'confirm' => 'Deseja mesmo remover esta atividade do evento?',
                                            'method' => 'post',
                                        ],
                                        'id' => 'danger',
                                        'style' => 'font-size: 20px'
                                    ]);
                                }
                            ],
                        ],
                    ]]); ?>
            </div>
        <?php } ?>
    </div>
</div>
