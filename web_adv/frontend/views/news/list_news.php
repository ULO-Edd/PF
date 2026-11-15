<?php
// _list_item.php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\BackendAsset;

$backend = BackendAsset::register($this);
?>

<div class="list-element">
    <?php if ($model->image != null){ ?>
        <img src="<?= $backend->baseUrl . '/' . $model->image?>">
    <?php } ?>
    <h2>
        <?= Html::a(Html::encode($model->titulo)) ?>
    </h2>

    <div>
        <?php echo nl2br("Descrição: " . $model->descricao . "\n"); ?>
        <?php echo nl2br("Data Limite: " . $model->date_expire . "\n"); ?>
    </div>
</div>
