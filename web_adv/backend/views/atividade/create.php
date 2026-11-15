<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Atividade */

$this->title = 'Criar Atividade';
?>
<div class="atividade-create" style="margin-left: 100px; margin-right: 100px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'novidade' => $novidade,
        'tipoAtividade' => $tipoAtividade,
    ]) ?>

</div>
