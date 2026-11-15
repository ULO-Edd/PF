<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\UpdateUserForm */


$this->title = 'Perfil';
?>
<div class="user-update">

    <h1 style="color: black"><?= $this->title?></h1>

    <?php if($pessoa->image != null){ ?>
        <?= Html::img('../imgs/'. $pessoa->image, ['style' => 'max-width: 100px; max-height:100px']); ?>
    <?php } ?>

    <?= $this->render('_form_profile', [
        'model' => $model,
    ]) ?>

</div>
