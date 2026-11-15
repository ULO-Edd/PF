<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\News */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$backend = BackendAsset::register($this);
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if ($model->image != null){ ?>

        <img src="<?= $backend->baseUrl . '/' . $model->image?>" style="height: 300px">

    <?php } ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'descricao',
            'date_expire',
        ],
    ]) ?>

</div>
