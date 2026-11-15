<?php

use common\models\Favorito;
use common\models\Ticket;
use yii\helpers\Html;
use frontend\assets\BackendAsset;

$backend = BackendAsset::register($this);

/* @var $model \common\models\Atividade */

$contains = null;
$containsEvent = null;

if($idTicket != null){
    $ticket = Ticket::findOne(['id' => $idTicket]);

    foreach ($ticket->activities as $atividade){
        if($atividade->id == $model->id){
            $contains = true;
        }
    }
}

if($model->activitiesEventos != null){
    $containsEvent = true;
}

?>
<div class="list-element" style="height: unset">
    <div class="element-activity">
        <?php if ($model->image != null){ ?>
            <img src="<?= $backend->baseUrl . '/' . $model->image?>">
        <?php } ?>
        <h2>
            <?= Html::a(Html::encode($model->designacao)) ?>
        </h2>

        <div>
            <?php echo nl2br("Tipo de Atividade: " . $model->tipoAtividade->tipo . "\n"); ?>
            <?php echo nl2br("Lotaçao: " . $model->lotacao ."\n"); ?>
            <p></p>
            <?= "\n". "Descrição: " . $model->descricao?>
        </div>

        <?php
        if ($idTicket != null){
            if($contains != true){ ?>
                <div class="btn-styled">
                    <?=
                    Html::a('Adicionar esta Atividade ao Bilhete', ['atividade/add-to-ticket', 'id_atividade' => $model->id,'id_ticket' => $idTicket, 'indexTicket' => $indexTicket]);
                    ?>
                </div>
                <?php
            }
        }else{ ?>
            <div style="display: flex">
            <?php $favorito = Favorito::findOne(['id_user' => Yii::$app->user->identity->getId(), 'id_atividade' => $model->id]);
            if($favorito == null){ ?>
                <div class="btn-styled">
                    <?=
                    Html::a('&#9733', ['favorito/adicionar', 'idUser' => Yii::$app->user->identity->getId(), 'idAtividade' => $model->id])
                    ?>
                </div>
            <?php } ?>
            <div class="btn-styled">
                <?=
                Html::a('Criar bilhete com esta atividade', ['ticket/create','ida' => $model->id]);
                ?>
            </div>
            </div>
        <?php } ?>
    </div>
    <?php if($containsEvent == true){ ?>
        <div class="btn-styled">
            <?= Html::button("Ver Eventos", ['type' => 'button', 'onclick' => "showEvents(". $model->id .")"]) ?>
        </div>
    <?php foreach ($model->activitiesEventos as $atividadeEvento){
    if($atividadeEvento->evento->data_conclusao > Yii::$app->formatter->asDate('now', 'yyyy-MM-dd')){?>
        <div class="show-events<?= $model->id ?>" style="display: none">

            <hr>
            <div class="list" style="width: 100%; display: flex">
                <div>
                    <h3>
                        <p><?= Html::a(Html::encode($atividadeEvento->evento->designacao)) ?> ( <span style="color: darkgreen"> <?= Yii::$app->formatter->asDate($atividadeEvento->evento->data_inicio, 'dd/MM/yyyy') ?></span> | <span style="color: darkred"><?= Yii::$app->formatter->asDate($atividadeEvento->evento->data_conclusao, 'dd/MM/yyyy')?></span> )</p>
                    </h3>

                    <p> Descrição <?= $atividadeEvento->evento->descricao ?> </p>

                    <div class="btn-styled">
                        <?=
                        Html::a('Ver Detalhes', ['evento/view','id' => $atividadeEvento->evento->id]);
                        ?>
                    </div>
                </div>
                <div style="flex: 1;">
                    <?php if ($model->image != null){ ?>
                        <img style="height: 20vh" src="<?= $backend->baseUrl . '/' . $atividadeEvento->evento->image?>">
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php }} ?>
        <script>
            function showEvents(id) {
                var x = document.getElementsByClassName("show-events" + id);
                for(let element of x){
                    if (element.style.display === "none") {
                        element.style.display = "block";
                    } else {
                        element.style.display = "none";
                    }
                }
            }
        </script>
    <?php } ?>
</div>
