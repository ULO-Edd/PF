<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($dataProvider->totalCount == 0){
    $this->title = 'Sem Novidades';
}else{
    $this->title = 'Novidades';
}

?>
<div class="news-index">

    <div class="background-image" style="background-image: url('../imgs/park-news.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Novidades</h1>
    </div>

    <div class="list-page" style="min-height: 65vh">
        <div class="list">
    <h1><?= Html::encode($this->title) ?></h1>
            <hr>

    <?php
    if($dataProvider->totalCount != 0) {

        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'itemView' => function ($model) {
                return $this->render('list_news', ['model' => $model]);
            },
        ]);
    }
    ?>
        </div>
        </div>
</div>
