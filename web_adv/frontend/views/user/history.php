<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Historico';

if($dataProvider->totalCount == 0){
    $title2 = 'Ainda não possui qualquer Historico';
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
<?php
    if($dataProvider->totalCount != 0) { ?>
            <ul class="tilesWrap" style="text-align: -webkit-center;">
                <?php foreach($dataProvider->models as $historico){
                    $historyDate = new DateTime($historico->data)?>
                <li id="history-child">
                    <!-- A imagem tem que ser quadrada (ex. 150x150) -->
                    <h2>
                        <?php if(strpos($historico->titulo, 'Bilhete')){ ?>
                            <img src="../imgs/ticket-icon.png">
                        <?php } else if(strpos($historico->titulo, 'Produto')){ ?>
                            <img src="../imgs/product-icon.png">
                        <?php } else if(strpos($historico->titulo, 'Atividade')){ ?>
                            <img src="../imgs/participate-icon.jpg">
                        <?php } else if(strpos($historico->titulo, 'Evento')){?>
                            <img src="../imgs/event-icon.png">
                        <?php } ?>
                    </h2>
                    <h3>
                        <?= $historico->titulo ?>
                    </h3>

                    <p>
                        <?= nl2br("Data: " . $historyDate->format('d/m/Y') . "\n"); ?>
                        <?= nl2br("Hora: " . $historyDate->format('H:i:s') . "\n"); ?>
                        <?= nl2br("Descrição: " . $historico->descricao . "\n"); ?>
                    </p>

                    <?php if($historico->acumulou == 1){ ?>
                        <p style="color: #94ff78"><?= nl2br("Acumulou: " . $historico->pontos . " pontos" . "\n"); ?>  </p>
                    <?php }else if($historico->acumulou == 0){ ?>
                    <p style="color: #ff6c62"><?= nl2br("Gastou: " . $historico->pontos . " pontos" . "\n"); ?></p>
                    <?php } ?>

                </li>
                <?php } ?>
            </ul>
    <?php }else{ ?>
        <h1 style="font-size: 30px"><?= $title2 ?></h1>
    <?php }?>
        </div>
    </div>
</div>
