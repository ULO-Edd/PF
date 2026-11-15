<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = 'Novidade: '.$model->titulo;
?>
<div class="news-view" style="margin-left: 100px; margin-right: 100px">

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

            'titulo',
            'descricao',
            'date_expire',

        ],
    ]) ?>

</div>
