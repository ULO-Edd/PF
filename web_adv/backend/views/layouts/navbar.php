<?php

use yii\helpers\Html;

?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">

        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?=\yii\helpers\Url::home()?>" class="nav-link">Home</a>
        </li>
        <!--
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Menu Principal</a>

            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="#" class="dropdown-item">Users </a></li>
                <li><a href="#" class="dropdown-item">Seções</a></li>
                <li><?php// Html::a('Sign out ( ' . Yii::$app->user->identity->username . ' )', ['site/logout'], ['data-method' => 'post', 'class' => 'dropdown-item']) ?></li>

            </ul>
        </li>
        -->
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item">

            <?= Html::a('Sign out ('  . Yii::$app->user->identity->username .  ')', ['site/logout'], ['data-method' => 'post', 'class' => 'btn btn-default btn-flat float-right']) ?>
           </a>
        </li>

    </ul>
</nav>