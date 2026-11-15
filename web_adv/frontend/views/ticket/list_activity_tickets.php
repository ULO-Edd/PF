<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;


$backend = BackendAsset::register($this);
?>
<div class="list-element">

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

    <?php if(!str_contains(Url::current(), 'view')){ ?>
    <div class="btn-styled">
    <?= Html::a('Remover do Bilhete', ['atividades-ticket/remover', 'idTicket' => $id_ticket, 'idActivity' => $model->id, 'indexTicket' => $indexTicket], [
        'data' => [
            'confirm' => 'Deseja mesmo remover esta atividade do seu bilhete?',
            'method' => 'post',
        ],
        'id' => 'danger',

    ]) ?>
    </div>
    <?php } ?>

