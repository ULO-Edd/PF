<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Ticket */


$this->title = 'Comprar Bilhete';

$backend = BackendAsset::register($this);
?>
<div class="ticket-create">
    <div class="background-image" style="background-image: url('../imgs/park-tickets.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Bilhetes</h1>
    </div>



    <div class="form-page" style="min-height: 65vh">
        <div id="form">

            <h1><?= Html::encode($this->title) ?></h1>

            <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
        </div>
    </div>
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

                        <div class="btn-styled">
                            <?= Html::a('Remover do Bilhete', ['atividades-ticket/remover', 'idTicket' => $model->id, 'idActivity' => $atividade->id, 'indexTicket' => 0], [
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
