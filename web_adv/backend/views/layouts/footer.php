<?php

use yii\bootstrap4\Html;

?>

<footer class="footer mt-auto py-3 text-muted" style="background-color: #3b3b3b; display: block">
    <div class="container">
        <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
        <p class="float-right"><?= Yii::powered() ?></p>
    </div>
</footer>