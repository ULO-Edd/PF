<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($dataProvider->totalCount == 0){
    $this->title = 'Sem Atividades';
}else{
    $this->title = 'Atividades';
}

?>
<div class="atividade-index">
    <div class="background-image" style="background-image: url('../imgs/park-activities.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Atividades</h1>
    </div>

    <div class="list-page" style="min-height: 65vh">
        <div class="list">
    <h1><?= Html::encode($this->title) ?></h1>
            <hr>


    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'itemView' => 'list_atividades',
        'viewParams' => ['idTicket' => $idTicket, 'indexTicket' => $indexTicket],
    ]);

    ?>


</div>
