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
        <p><?= Html::a(Html::encode($model->designacao)) ?> ( <span style="color: darkgreen"> <?= Yii::$app->formatter->asDate($model->data_inicio, 'dd/MM/yyyy') ?></span> | <span style="color: darkred"><?= Yii::$app->formatter->asDate($model->data_conclusao, 'dd/MM/yyyy')?></span> )</p>
    </h2>

    <div>
        <p>        <?= "\n". "Descrição: " . $model->descricao?></p>
    </div>

    <div class="btn-styled">
        <?=
        Html::a('Ver Evento', ['evento/view','id' => $model->id]);
        ?>
    </div>
</div>
