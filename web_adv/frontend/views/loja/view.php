<?php

use frontend\assets\BackendAsset;
use yii\helpers\Html;

/** @var yii\web\View $this */

if($loja == null){
    $this->title = 'Ainda não existe Loja';
}else{
    $this->title = $loja->designacao;
}

$backend = BackendAsset::register($this);
?>
<div class="loja-index">

    <div class="background-image" style="background-image: url('../imgs/park-store.jpg')" id="report-image"></div>

    <div class="headline-page">
        <h1 id="headline" class="display-4">Loja</h1>
    </div>

    <div class="form-page" style="min-height: 65vh">
        <div id="form">
            <h1 style="font-size: 20px"><?='Pontos: ' . $pessoa->points ?></h1>
            <hr>
            <h1><?= Html::encode($this->title) ?></h1>
            <hr>
            <?php if($loja != null && $loja->produtos != null){ ?>
                <ul class="tilesWrap">
                    <?php foreach($loja->produtos as $produto){ ?>
                        <li id="ticket-child">
                            <h2>
                                <img src="<?= $backend->baseUrl . '/' . $produto->image?>">
                            </h2>
                            <h3>
                                <?= Html::a(Html::encode($produto->descricao)) ?>
                            </h3>

                            <p>
                            <p><?= "Pontos: " ?> <span style="color: lightblue; font-size: 20px"> <?= $produto->points ?></span></p>

                            </p>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>
