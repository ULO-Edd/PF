<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Evento $model */
/* @var $dataProvider yii\data\ActiveDataProvider */

$backend = BackendAsset::register($this);

$this->title = $model->designacao;
?>
<div class="evento-view">

    <div class="background-image" style="background-image: url('../imgs/park-events.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Eventos</h1>
    </div>

    <div class="list-page" style="min-height: 65vh">
        <div class="list">

            <h1><?= Html::encode($this->title) ?></h1>
            <hr>

            <div style="height: 30vh; display: flex">

                <div>
                    <h4>Data de Inicio:   <span style="color: darkgreen"><?= $model->data_inicio ?></span></h4>
                    <h4>Data de Finalização:  <span style="color: darkred"><?=$model->data_conclusao ?></span></h4>
                    <p></p>
                    <?= "\n". "Descrição: " . $model->descricao?>
                </div>


                <div style="flex: 1; text-align: right">
                <?php if ($model->image != null){ ?>
                    <img  src="<?= $backend->baseUrl . '/' . $model->image?>">
                <?php } ?>
                </div>
            </div>
            <?php if($dataProvider->totalCount != 0){ ?>
            <hr>
            <div>
                <h2>Atividades relacionadas a este evento</h2>
                <p> Pontos a ganhar se participar nas atividades abaixo: <?= $model->pontos_participacao ?></p>
            </div>
            <div>
                <div class="list-container" style="display: flex; justify-content: center; align-content: center">
                    <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        'emptyText' => 'Este Evento não possui atividades',
                        'options' => ['style' => 'width: 75%'],
                        'itemView' => function ($model, $index) {
                            return $this->render('list_atividades_evento',['model' => $model, 'index' => $index]);
                        },
                    ]);
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>


