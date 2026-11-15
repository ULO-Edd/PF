<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="error-page" style="z-index: -1">
    <div class="error-content">
        <div style=" display: flex; justify-content: center; align-items: center; position: absolute; top:60px; bottom: 60px; left: 0; right: 0; margin: auto;">
            <i style="color: red; font-size: 70px" class="glyphicon glyphicon-remove"></i>
        <h1 style="font-size: 70px"><?= Html::encode($name) ?></h1>
        </div>

        <div style=" display: flex; justify-content: center; align-items: center; position: absolute; top:120px; bottom: 0; left: 0; right: 0; margin: auto;">

        <p style="font-size: 20px;">
            <?= nl2br(Html::encode($message)) ?>
        </p>
        </div>
    </div>
</div>

