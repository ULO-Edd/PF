<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reports */

$this->title = 'Criar Sugestão';
?>
<div class="reports-create">
    <div class="background-image" style="background-image: url('../imgs/park-reports.png')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Sugestões</h1>
    </div>

    <div class="form-page" style="min-height: 65vh">
        <div id="form">
    <h1><?= Html::encode($this->title) ?></h1>
            <hr>


    <?= $this->render('_form', [
        'model' => $model,
        'topicoReport' => $topicoReport,
    ]) ?>
        </div>
    </div>
</div>
