<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

$modelTicket = $model->id;

$this->title = 'Bilhete nº ' . $indexTicket;

if($dataProvider->totalCount == 0) {
    $nullActivitiesText = "Não existe atividades relacionadas a este bilhete";
}
?>

<div class="ticket-view">

    <div class="background-image" style="background-image: url('../imgs/park-tickets.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Bilhetes</h1>
    </div>

    <div class="list-page" style="min-height: 65vh">
        <div class="list">

    <h1><?= Html::encode($this->title) ?></h1>

            <?php if($model->expirado == true ){ ?>
                <p style="color: red">Expirado</p>
            <?php }else if($model->anulado == true){?>
                <p style="font-weight: bold;">Anulado</p>
            <?php } ?>
            <hr>


            <div class="btn-styled">
                <?php
                if($model->expirado == true){
                    echo Html::a('Renovar Bilhete', ['ticket/update', 'idt' => $model->id, 'indexTicket' => $indexTicket]);
                }else if($model->anulado == true){
                    echo Html::a('Editar Bilhete', ['ticket/update', 'idt' => $model->id, 'indexTicket' => $indexTicket]);}?>

                <?= Html::a('Remover Bilhete', ['ticket/delete', 'id' => $model->id], [
                        'data' => [
                            'confirm' => 'Deseja mesmo remover este bilhete?',
                            'method' => 'post',
                        ],
                        'id' => 'danger',

                    ]) ?>
            </div>


    <div>
        <div>
                <h4>Data de Compra: <?= $model->data_de_compra ?></h4>
                <h4>Data de Uso:  <?=$model->data_de_uso ?></h4>
                <h4>Preço: <?=$model->preco?>€</h4>
        </div>

        <div class="list-container">
        <?php
        if($dataProvider->totalCount != 0) {
            echo ListView::widget([
                'dataProvider' => $dataProvider,
                'summary' => '',
                'itemView' => function ($model, $key, $widget) use ($modelTicket, $indexTicket) {
                    return $this->render('list_activity_tickets', ['model' => $model, 'id_ticket' => $modelTicket, 'indexTicket' => $indexTicket]);
                },
            ]);
        }else{ ?>
            <h2>
                <?= $nullActivitiesText ?>
            </h2>
            <hr>
        <?php }
        ?>
        </div>
        </div>
        </div>
    </div>
</div>
