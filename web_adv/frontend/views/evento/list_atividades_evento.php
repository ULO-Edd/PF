<?php

use common\models\Favorito;
use common\models\Ticket;
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
        <?= Html::a(Html::encode($model->designacao)) ?>
    </h2>

    <div>
        <?php echo nl2br("Tipo de Atividade: " . $model->tipoAtividade->tipo . "\n"); ?>
        <?php echo nl2br("Lotaçao: " . $model->lotacao ."\n"); ?>
        <?php echo nl2br("Descrição: " . $model->descricao ."\n"); ?>
    </div>



    <?php if(Yii::$app->user->id != null){ ?>
    <div style="display: flex">
        <?php
        $favorito = Favorito::findOne(['id_user' => Yii::$app->user->identity->getId(), 'id_atividade' => $model->id]);
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
