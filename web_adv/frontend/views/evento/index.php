<?php

use common\models\Evento;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

if($dataProvider->totalCount == 0){
    $this->title = 'Sem Eventos';
}else{
    $this->title = 'Eventos';
}

?>
<div class="evento-index">

    <div class="background-image" style="background-image: url('../imgs/park-events.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Eventos</h1>
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
                        return $this->render('list_eventos', ['model' => $model]);
                    },
                ]);
            }
            ?>

        </div>
    </div>
</div>
