<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Atividade */

$this->title = 'Atividade: '.$model->designacao;
?>
<div class="atividade-view" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja mesmo eliminar esta atividade?',
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
            [
                'label' => 'Tipo de Atividade',
                'attribute' => 'tipoAtividade.tipo'
            ],
            [
                'label' => 'Designação',
                'attribute' => 'designacao'
            ],
            [
                'label' => 'Descrição',
                'attribute' => 'descricao'
            ],
            [
                'label' => 'Lotação',
                'attribute' => 'lotacao'
            ],
        ],
    ]) ?>

</div>
