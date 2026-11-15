<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UpdateUserForm */


$this->title = 'Perfil';
?>
<div class="user-update">
    <div class="background-image" style="background-image: url('../imgs/park-profile.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Perfil</h1>
    </div>

    <div class="form-page" style="min-height: 65vh">
        <div id="form">
            <hr>
            <h2 style="font-size: 20px"> Pontos: <?= $pessoa->points ?></h2>
            <hr>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


</div>
