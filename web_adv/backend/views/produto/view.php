<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Produto $model */

$this->title = $model->descricao;
?>
<div class="produto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Tem a certeza que pretende eliminar este produto?',
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
            'quantidade',
            'points',
        ],
    ]) ?>

</div>
