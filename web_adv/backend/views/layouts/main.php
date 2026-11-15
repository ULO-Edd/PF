<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;

if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    $bundle = yiister\gentelella\assets\Asset::register($this);



?>
    <?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta charset="<?= Yii::$app->charset ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>">
        <?php $this->beginBody();
        if (Yii::$app->controller->action->id !== 'error') {
        ?>
        <div class="container body">

            <div class="main_container">

                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">

                        <div class="navbar nav_title" style="border: 0;">
                            <a href="/" class="site_title"><i class="fa fa-tree"></i> <span>BRISA PARK</span></a>
                        </div>
                        <div class="clearfix"></div>

                        <!-- menu prile quick info -->
                        <div class="profile">
                            <div class="profile_pic">
                                <?php
                                $pessoa = \common\models\Pessoa::findOne(['id' => Yii::$app->user->getId()]);
                                if($pessoa->image != null){
                                ?>
                                <?= Html::img('../imgs/'. $pessoa->image, ['style' => 'max-width: 80px; max-height:80px; margin-top: 10']); ?>
                                <?php } else{ ?>
                                <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt="..." class="img-circle profile_img">
                                <?php } ?>
                            </div>
                            <div class="profile_info">
                                <span>Bem Vindo,</span>
                                <h2><?= ("" . Yii::$app->user->identity->username . "") ?></h2>
                            </div>
                        </div>
                        <!-- /menu prile quick info -->

                        <br />

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu" style="margin-top: 60px">
                            <div class="menu_section">
                                <?php if(Yii::$app->user->can('seeUser')){
                                    echo \yiister\gentelella\widgets\Menu::widget(
                                        [
                                            "items" => [
                                                ["label" => "Utilizadores", "url" => ["user/index"], "icon" => "group"],
                                            ],
                                        ]
                                    );
                                } ?>
                                <?=
                                \yiister\gentelella\widgets\Menu::widget(
                                    [
                                        "items" => [
                                            ["label" => "Bilhetes", "url" => ["ticket/index"], "icon" => "ticket"],
                                            [
                                                "label" => "Sugestões",
                                                "icon" => "comment",
                                                "url" => "#",
                                                "items" => [
                                                    ["label" => "Ver Sugestões", "url" => ["report/index"]],
                                                    ["label" => "Tópicos de Sugestões", "url" => ["topico-report/index"]],
                                                ],
                                            ],
                                            [
                                                "label" => "Novidades",
                                                "icon" => "bullhorn",
                                                "url" => "#",
                                                "items" => [
                                                    ["label" => "Ver Novidades", "url" => ["news/index"]],
                                                    ["label" => "Criar Novidades", "url" => ["news/create"]],
                                                ],
                                            ],
                                            [
                                                "label" => "Atividades",
                                                "url" => "#",
                                                "icon" => "pied-piper-alt",
                                                "items" => [
                                                    [
                                                        "label" => "Ver Atividades",
                                                        "url" => ["atividade/index"],
                                                    ],
                                                    [
                                                        "label" => "Criar Atividade",
                                                        "url" => ["atividade/create"],
                                                    ],
                                                    [
                                                        "label" => "Tipo Atividades",
                                                        "url" =>  ["tipo-atividade/index"],
                                                    ],

                                                ],
                                            ],
                                            [
                                                "label" => "Eventos",
                                                "icon" => "calendar",
                                                "url" => "#",
                                                "items" => [
                                                    ["label" => "Ver Eventos", "url" => ["evento/index"]],
                                                    ["label" => "Criar Eventos", "url" => ["evento/create"]],
                                                ],
                                            ],
                                            ["label" => "Loja", "icon" => "bell", "url" => ["loja/view"]],
                                            ["label" => "Produtos", "icon" => "dropbox", "url" => ["produto/index"]],
                                        ],
                                    ]
                                )
                                ?>
                            </div>

                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>
                <?php } ?>
                <!-- top navigation -->
                <div class="top_nav">

                    <div class="nav_menu">
                        <nav class="" role="navigation">
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460__340.png" alt=""> <?= ("" . Yii::$app->user->identity->username . "") ?>
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <?php if (Yii::$app->controller->action->id !== 'error') {?>
                                        <li>
                                            <?= Html::a('Perfil',['user/profile']); ?>
                                        </li>
                                    <?php } ?>
                                        <li><?= Html::a(' Logout ', ['site/logout'], ['data-method' => 'post', 'class' => 'fa fa-sign-out pull-right']) ?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>

                </div>
                <!-- /top navigation -->

                <!-- page content -->
                <div class="right_col" role="main">
                    <?php if (isset($this->params['h1'])) : ?>
                        <div class="page-title">
                            <div class="title_left">
                                <h1><?= $this->params['h1'] ?></h1>
                            </div>
                            <div class="title_right">
                                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search for...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Go!</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="clearfix"></div>

                    <?= $content ?>
                </div>
                <!-- /page content -->
            </div>

        </div>

        <div id="custom_notifications" class="custom-notifications dsp_none">
            <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
            </ul>
            <div class="clearfix"></div>
            <div id="notif-group" class="tabbed_notifications"></div>
        </div>
        <!-- /footer content -->
        <?php $this->endBody(); ?>
    </body>

    </html>

    <?php $this->endPage(); ?>
<?php } ?>