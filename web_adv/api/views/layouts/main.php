<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use api\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;


AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100" >
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="stylesheet" href="../../web/css/site.css" type="text/css">
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>

        <?php

        NavBar::begin([
            'innerContainerOptions' => ['class' => 'nav-container'],
            'brandLabel' => '<img src="../imgs/13.png" class="frontpage-brand">',
            //'brandLabel' => 'Brisa Park',
            //'brandOptions' => ['class' => 'frontpage-brand'],//options of the brand
            'brandUrl' => Yii::$app->homeUrl,
            'brandOptions' => ['style' => 'padding-right: 1rem; border-right: double'],
            'options' => [
                'class' => 'navbar-styled navbar-expand-md navbar-dark bg-dark fixed-top-styled',
            ],
        ]);
        $menuItems = [
            ['label' => 'Home', 'url' => ['../']],
            ['label' => 'Novidades', 'url' => ['/news/index']],
            ['label' => 'Eventos', 'url' => ['/evento/index']],

        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Registar', 'url' => ['/site/signup'], 'options' => [ 'style' => 'display: flex; justify-content: right; width: 100%;']];
            $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'], 'options' => [ 'style' => 'display: flex; justify-content: right']];

        } else {
            $menuItems[] = ['label' => 'Sugestões', 'url' => ['/reports/create']];
            $menuItems[] = ['label' => 'Atividades', 'url' => ['/atividade/index']];
            $menuItems[] = ['label' => 'Favoritos', 'url' => ['/favorito/index']];
            $menuItems[] = ['label' => 'Bilhetes', 'url' => ['/ticket/index']];
            $menuItems[] = ['label' => 'Loja', 'url' => ['/loja/index']];
            $menuItems[] = '<li  style="width: 100%">'
                . Html::beginForm(['/user/update', 'id' => Yii::$app->user->getId()], '',['class' => 'form-inline', 'style' => 'float:right'])
                . Html::submitButton(
                    'Perfil',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';
            $menuItems[] = '<li>'
                . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline', 'style' => 'float:right'])
                . Html::submitButton(
                    'Logout',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>';

        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav', 'style' => 'width:100%; flex-wrap:unset'],
            'items' => $menuItems,
        ]);
        NavBar::end();
        ?>
        </div>
    </header>

    <main role="main" class="flex-shrink-0">
        <div>
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <div class="alert-column">
                <?= Alert::widget() ?>
            </div>
            <?= $content ?>
        </div>
    </main>
    <!--
<footer class="footer mt-auto py-3 text-muted">
    <div class="container">
        <p class="float-left">&copy; <?php// Html::encode(Yii::$app->name) ?> <?php// date('Y')?></p>
        <p class="float-right"><?php// Yii::powered() ?></p>
    </div>
</footer>
-->

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
