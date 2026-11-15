<?php

use common\models\Atividade;
use frontend\assets\BackendAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */

if($model->anulado == 1){
    $this->title = 'Editar bilhete: ' . $indexTicket;
}else if($model->expirado == 1){
    $this->title = 'Renovar bilhete: ' . $indexTicket;
}

$backend = BackendAsset::register($this);
?>
<div class="ticket-update">

    <div class="background-image" style="background-image: url('../imgs/park-tickets.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Bilhetes</h1>
    </div>

    <div class="form-page" style="min-height: 65vh">
        <div id="form">

            <h1><?= Html::encode($this->title) ?></h1>

            <hr>

    <?= $this->render('_form_update', [
        'model' => $model,
        'indexTicket' => $indexTicket,
    ]) ?>
        </div>
    </div>
    <?php if($model->anulado == 1){ ?>
            <div style=" width: 100%; display: flex; justify-content: center; align-items: center">
                <div style="width: 50%">
                    Numero limite de atividades:
                    <p style="font-size: 25px"><?= $model->numero_atividades ?></p>
                </div>
            </div>
    <?php } ?>
    <div class="list-page">
        <div style="border-top-style: solid; border-width: 1px; width: 50%">
            <?php
            if(sizeof($model->activities) != 0) {
                foreach($model->activities as $atividade) {?>
                    <div class="list-element">

                        <?php if ($atividade->image != null){ ?>
                            <img src="<?= $backend->baseUrl . '/' . $atividade->image?>">
                        <?php } ?>

                        <h2>
                            <?= Html::a(Html::encode($atividade->designacao)) ?>
                        </h2>

                        <div>
                            <?= "\n". "Descrição: " . $atividade->descricao?>
                        </div>

                        <div class="btn-styled">
                            <?= Html::a('Remover do Bilhete', ['atividades-ticket/remover', 'idTicket' => $model->id, 'idActivity' => $atividade->id, 'indexTicket' => $indexTicket], [
                                'data' => [
                                    'confirm' => 'Deseja mesmo remover esta atividade do seu bilhete?',
                                    'method' => 'post',
                                ],
                                'id' => 'danger'
                            ]); ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
