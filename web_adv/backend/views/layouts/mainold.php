<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {


    \hail812\adminlte3\assets\FontAwesomeAsset::register($this);
    \hail812\adminlte3\assets\AdminLteAsset::register($this);
    $this->registerCssFile('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700');

    $assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">

    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body="d-flex flex-column h-100">
        <?php $this->beginBody() ?>

        <header>
            <?= $this->render('navbar', ['assetDir' => $assetDir]) ?>
        </header>
        <main>
            <div role="main" class="flex-shrink-0">

                <?= $this->render('content', ['content' => $content, 'assetDir' => $assetDir]) ?>
            </div>
        </main>
        <footer>
            <div class="container">
                <p class="float-left"><?= Html::encode('PARK & JOY  | ') ?> <?= date('Y') ?></p>
                <p class="float-right"><?= Yii::powered() ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
        </body>

    </html>
    <?php $this->endPage() ?>
<?php } ?>