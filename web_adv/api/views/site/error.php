<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error" style="top:0; bottom: 0; left: 0; right: 0; margin: auto;">

    <div style=" display: flex; justify-content: center; align-items: center; position: absolute; top:0; bottom: 200px; left: 0; right: 0; margin: auto;">
    <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="alert alert-danger" style=" display: flex; justify-content: center; align-items: center; top:240px; bottom: 0; left: 0; right: 0; margin: auto;">
        <?= nl2br(Html::encode($message)) ?>
    </div>

</div>
