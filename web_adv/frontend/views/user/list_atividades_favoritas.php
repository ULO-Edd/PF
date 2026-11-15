<?php
// _list_item.php
use frontend\assets\BackendAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$backend = BackendAsset::register($this);
?>

<div class="list-element">

    <?php if ($model->image != null){ ?>
        <img src="<?= $backend->baseUrl . '/' . $model->image?>" style="height: 75%">
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

    <div class="btn-styled">
    <?= Html::a('Eliminar dos Favoritos', ['favorito/remover', 'idUser' => Yii::$app->user->getId(),'idAtividade' => $model->id], [
        'data' => [
            'confirm' => 'Deseja mesmo remover esta atividade dos seus Favoritos?',
            'method' => 'post',
        ],
        'id' => 'danger',]) ?>
    </div>
</div>
