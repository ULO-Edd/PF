<?php
use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;


$backend = BackendAsset::register($this);
?>
    <div style="margin-bottom: 20px">

    </div>

<div style="border-color: #0a0a0a; background-color: white; overflow: auto;  border-bottom-style: solid">

    <?php if ($model->image != null){ ?>
        <img src="<?= $backend->baseUrl . '/' . $model->image?>" style="float: right; margin: 10px 0 10px 0; width: 30%">
    <?php } ?>

    <h2 class="title">
        <?= Html::a(Html::encode("Atividade: " . $model->designacao)) ?>
    </h2>

    <div class="item-excerpt">

        <?php echo nl2br("Tipo de Atividade: " . $model->tipoAtividade->tipo . "\n"); ?>
        <?php echo nl2br("Descrição: " . $model->descricao . "\n"); ?>
    </div>
    <div style="margin-top: 200px">
    </div>
</div>
