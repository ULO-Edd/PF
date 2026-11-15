<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($dataProvider->totalCount == 0){
    $this->title = 'Sem Atividades Favoritas';
}else{
    $this->title = 'Atividades Favoritas';
}

?>
<div class="user-update">
<div class="background-image" style="background-image: url('../imgs/park-profile.jpg')" id="report-image"></div>

<div class="headline-page">
    <h1 id="headline" class="display-4">Perfil</h1>
</div>

<div class="form-page" style="min-height: 65vh">
    <div id="form">
        <hr>
        <h1 style="font-size: 20px"><?='Pontos: ' . $pessoa->points ?></h1>
        <hr>

        <div class="list-page" style="min-height: 65vh">
            <div class="list" style="width: 100%">
                <h1><?= Html::encode($this->title) ?></h1>
                <hr>
                <?php
                echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => '',
                    'emptyText' => 'Sem Atividades Favoritas',
                    'itemView' => function ($model) {
                        return $this->render('list_atividades_favoritas',[
                            'model' => $model,
                        ]);
                    },
                ]);
                ?>
        </div>
    </div>
</div>
</div>
</div>