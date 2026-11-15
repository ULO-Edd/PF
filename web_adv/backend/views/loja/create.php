<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Loja $model */

$this->title = 'Criar Loja';
?>
<div class="loja-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
            'products' => $products,
            'model' => $model,
    ]) ?>

</div>
