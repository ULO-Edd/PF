<?php
/* @var $this yii\web\View */

use yii\helpers\Html;


$this->title = 'Brisa Park';


?>
<div class="site-index">

    <div class="frontpage-background-image">
        <img src="../imgs/park2.jpg">
        <div class="frontpage-logo">
            <img id="logo" src="imgs/logoweb.png">
            <!--<h1 style="font-size: 70px;">BRISA  PARK</h1>-->
        </div>
    </div>

    <div class="brisa-main-page">
        <?php if (!Yii::$app->user->isGuest){?>
            <div class="brisa-black-div">
                <div>
                <h2 class="display-4" style="text-align: right">Atividades do Parque</h2>
                <?= Html::a('Ver Atividades &raquo;', ['/atividade/index'], ['class' => 'btn btn-outline-secondary'])?>
                </div>
                <img src="imgs/park1.jpg">
            </div>
            <div class="brisa-white-div">
                <img src="imgs/park-bilhete.jpg">

                <div>
                    <h2 class="display-4" style="text-align: right">Bilhetes</h2>
                    <p style="text-align: right">De modo a facilitar a organização e o uso das diversas secções, assim como, as suas atividades é necessário a compra e o uso de bilhetes</p>
                    <?= Html::a('Comprar Ticket &raquo;', ['/ticket/create'], ['class' => 'btn btn-outline-secondary'])?>
                </div>
            </div>
            <div class="brisa-black-div">
                <div>
                    <h2 class="display-4" style="text-align: right">Ajude-nos a melhorar</h2>
                    <p>É para nós de uma grande importância reconhecer e acompanhar a experiência dos nossos clientes, por isso todas
                        as sugestões e /ou reclamações redirecionadas à nossa equipa através deste método serão ativamente analisadas
                        e ponderadas.</p>
                    <?= Html::a('Criar Sugestão &raquo;', ['/reports/create'], ['class' => 'btn btn-outline-secondary'])?>
                </div>
                <img src="imgs/park-suggestion.jpg">
            </div>
        <?php } ?>
        <div class="brisa-white-div">
            <img src="imgs/park-novidades.jpg">
            <div>
                <h2 class="display-4">Novidades</h2>
                <p style="text-align: right">Verifique as ultimas novidades do parque!</p>
                <?= Html::a('Ver Novidades &raquo;', ['/news/index'], ['class' => 'btn btn-outline-secondary'])?>
            </div>
        </div>
        <div class="brisa-black-div">
            <div>
                <h2 class="display-4" style="text-align: right">Eventos</h2>
                <p style="text-align: right">Verifique os mais recentes eventos do parque!</p>
                <?= Html::a('Ver Eventos &raquo;', ['/evento/index'], ['class' => 'btn btn-outline-secondary'])?>
            </div>
            <img src="imgs/park-events.jpg">
        </div>
        <div class="brisa-white-div">
            <img src="imgs/park-us.jpg">
            <div>
            <h2 class="display-4" > Sobre Nós</h2>

                <p style="text-align: right">A empresa Brisa Park foi criada em 2021 tendo como principal objetivo a prática de atividades
                    radicais/desportivas e de diversão privilegiando a natureza envolvente de forma a promover um estilo
                    de vida saudável ao nível físico, psíquico e social.
                    <br>
                    <br>
                    De forma a possibilitar um conjunto vasto de experiências desportivas e/ou radicais aos nossos
                    clientes, a empresa Brisa Park está sediada num parque junto a uma reserva natural.
                    <br>
                    <br>
                    Para que os nossos clientes se sintam seguros e enquadrados no parque, é disponibilizado
                    um website com todas as informações necessárias para uma melhor experiência.
                    <br>
                    <br>
                    A empresa, também, promove uma aplicação móvel, apenas, de uso no interior do parque de forma apelativa e organizada aos nosso cliente.</p>
            </div>
        </div>
    </div>
</div>
