<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\widgets\ActiveForm */
/* @var $pessoa common\models\Pessoa */


$this->title = 'Bilhetes';

if($pessoa->tickets == null){
    $this->title = 'Sem Bilhetes';
}else if(isset($dataProvider)) {
    if ($dataProvider->totalCount == 0) {
        $this->title = 'Sem Bilhetes';
    }
}

$indexTicket = 0;

$selectOptions = [1 => 'Todos',2 => 'Anulados',3 => 'Expirados'];
?>
<div class="ticket-index">

    <div class="background-image" style="background-image: url('../imgs/park-tickets.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Bilhetes</h1>
    </div>

    <div class="list-page" style="min-height: 65vh; ">
        <div class="list">
            <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['action' => 'filter-form']); ?>
            <div class="sort-styled">
                <div>
                <?= $form->field($filter, 'filter')->dropDownList($selectOptions,['prompt'=>'Escolha o estado de bilhete'])->label('Filtrar'); ?>
                </div>
                <div class="btn-styled" style="margin-bottom: 0">
                    <?= Html::submitButton('Filtrar', ['style' => 'margin: 2px 10px 0 10px; padding: 6px 20px 6px 20px']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
            <hr>

            <div class="btn-styled">
                <?= Html::a('Comprar Bilhete', ['create']) ?>
            </div>




    <?php
    if($pessoa->tickets != null && !isset($dataProvider)) { ?>
            <ul class="tilesWrap">
                <?php foreach($pessoa->tickets as $ticket){
                    $indexTicket++?>
                <li id="ticket-child">
                    <h2>
                        <?= Html::a(Html::encode($indexTicket)) ?>
                    </h2>
                    <h3>
                        <?= Html::a(Html::encode("Bilhete")) ?>
                    </h3>

                    <?php if($ticket->expirado == true ){ ?>
                        <p style="color: red">Expirado</p>
                    <?php }else if($ticket->anulado == true){?>
                        <p style="font-weight: bold;">Anulado</p>
                    <?php } ?>

                    <p>
                        <?php echo nl2br("Data de Compra: " . $ticket->data_de_compra . "\n"); ?>
                        <?php echo nl2br("Data de Uso: " . $ticket->data_de_uso . "\n"); ?>
                        <?php echo nl2br("Preço: " . $ticket->preco . "€\n"); ?>
                    </p>

                    <button>
                        <?= Html::a('Ver Bilhete', ['view','id' => $ticket->id, 'indexTicket' => $indexTicket]) ?>
                    </button>

                </li>
                <?php } ?>
            </ul>
    <?php }else if(isset($dataProvider) && $dataProvider->totalCount != 0){ ?>
        <ul class="tilesWrap">
            <?php foreach($dataProvider->models as $ticket){
                $indexTicket++?>
                <li id="ticket-child">
                    <h2>
                        <?= Html::a(Html::encode($indexTicket)) ?>
                    </h2>
                    <h3>
                        <?= Html::a(Html::encode("Bilhete")) ?>
                    </h3>

                    <?php if($ticket->expirado == true ){ ?>
                        <p style="color: red">Expirado</p>
                    <?php }else if($ticket->anulado == true){?>
                        <p style="font-weight: bold;">Anulado</p>
                    <?php } ?>

                    <p>
                        <?php echo nl2br("Data de Compra: " . $ticket->data_de_compra . "\n"); ?>
                        <?php echo nl2br("Data de Uso: " . $ticket->data_de_uso . "\n"); ?>
                        <?php echo nl2br("Preço: " . $ticket->preco . "€\n"); ?>
                    </p>

                    <button>
                        <?= Html::a('Ver Bilhete', ['view','id' => $ticket->id, 'indexTicket' => $indexTicket]) ?>
                    </button>

                </li>
            <?php } ?>
        </ul>
    <?php } ?>
        </div>
    </div>
</div>
