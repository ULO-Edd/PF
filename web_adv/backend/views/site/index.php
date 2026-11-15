<?php

use common\models\Pessoa;
use common\models\Ticket;
use common\models\Produto;
use common\models\Evento;
use common\models\Participar;

//Variaveis de outros controladores 

// Totais 

$totalUsers = count(Pessoa::find()->all());
$totalTickets = count(Ticket::find()->all());
$sql = Yii::$app->db->createCommand("SELECT sum(points) from pessoa");
$totalPontos = $sql->queryScalar();
$totalProdutos = count(Produto::find()->all());
$totalEventos = count(Evento::find()->all());
$totalParticipantes = count(Participar::find()->all());


// Novos Utilizadores 
$sqlNovosUtilizadores = Yii::$app->db->createCommand("SELECT FROM_UNIXTIME(created_at,'%Y-%m-%d') as data, count(FROM_UNIXTIME(created_at,'%Y-%m-%d')) as repeticoes from user GROUP by data");
$novosUtilizadores = $sqlNovosUtilizadores->queryAll();

// Idades Utilizadores

$sqlCountAllIdades = Yii::$app->db->createCommand("select count(name) from pessoa");
$countIdades = $sqlCountAllIdades->queryScalar();

$sqlIdade18_30 = Yii::$app->db->createCommand("select count(datediff(CURDATE(),birthday_date)/ 365.25) idade from pessoa where datediff(CURDATE(),birthday_date)/ 365.25 >= 18 and datediff(CURDATE(),birthday_date)/ 365.25 <= 30");
$idade18_30 = $sqlIdade18_30->queryScalar();
$idade18_30_Result = intval($idade18_30 / $countIdades * 100);

$sqlIdade31_40 = Yii::$app->db->createCommand("select count(datediff(CURDATE(),birthday_date)/ 365.25) idade from pessoa where datediff(CURDATE(),birthday_date)/ 365.25 >= 31 and datediff(CURDATE(),birthday_date)/ 365.25 <= 40 ");
$idade31_40 = $sqlIdade31_40->queryScalar();
$idade31_40_Result = intval($idade31_40 / $countIdades * 100);

$sqlIdade41_55 = Yii::$app->db->createCommand("select count(datediff(CURDATE(),birthday_date)/ 365.25) idade from pessoa where datediff(CURDATE(),birthday_date)/ 365.25 >= 41 and datediff(CURDATE(),birthday_date)/ 365.25 <= 55");
$idade41_55 = $sqlIdade41_55->queryScalar();
$idade41_55_Result = intval($idade41_55 / $countIdades * 100);

$sqlIdade56_100 = Yii::$app->db->createCommand("select count(datediff(CURDATE(),birthday_date)/ 365.25) idade from pessoa where datediff(CURDATE(),birthday_date)/ 365.25 >= 56 and datediff(CURDATE(),birthday_date)/ 365.25 <= 100");
$idade56_100 = $sqlIdade56_100->queryScalar();
$idade56_100_Result = intval($idade56_100 / $countIdades * 100);

// Top 5 produtos

$sqlProdutos = Yii::$app->db->createCommand("SELECT descricao,points FROM produto limit 5 ");
$produtos = $sqlProdutos->queryAll();

// Ultimos Bilhetes Comprados

$sqlUltimosBilhetes = Yii::$app->db->createCommand("select data_de_compra from ticket order by data_de_compra desc");
$ultimosBilhetes = $sqlUltimosBilhetes->queryAll();


//Separar Array NovosUtilizadores para adaptar ao gráfico

$array = [];

foreach ($novosUtilizadores as $key => $value) {
    array_push($array, [$value['data'], $value['repeticoes']]);
}

$series = [
    [
        'name' => 'Novos Utilizadores',
        'data' =>
        $array
    ],
];

// tickets comprados diariamente 

$sqlTicketsComprados = Yii::$app->db->createCommand("SELECT data_de_compra, count(data_de_compra) as repeticoes from ticket GROUP by data_de_compra");
$ticketsComprados = $sqlTicketsComprados->queryAll();

//Separar Array Tickets Comprados para adaptar ao gráfico

$newArray = [];

foreach ($ticketsComprados as $key => $value) {
    array_push($newArray, [$value['data_de_compra'], $value['repeticoes']]);
}

$seriesTickets = [
    [
        'name' => 'Tickets Comprados',
        'data' =>
        $newArray
    ],
];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>BRISA PARK </title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            <!-- page content -->

            <!-- top tiles -->
            <div class="row" style="display: inline-block;">
                <div class="tile_count">
                    <div class="col-md-2 col-sm-4  tile_stats_count" style="width:150px">
                        <span class="count_top"><i class="fa fa-user"></i> Nº Utilizadores</span>
                        <div class="count"><?php echo $totalUsers ?></div>

                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count" style="width:150px">
                        <span class="count_top"><i class="fa fa-clock-o"></i> Nº Bilhetes </span>
                        <div class="count"><?php echo $totalTickets ?></div>

                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count" style="width:150px">
                        <span class="count_top"><i class="fa fa-user"></i> Total Pontos</span>
                        <div class="count green"><?php echo $totalPontos ?></div>

                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count" style="width:150px">
                        <span class="count_top"><i class="fa fa-user"></i> Nº Produtos</span>
                        <div class="count"><?php echo $totalProdutos ?></div>

                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count" style="width:150px">
                        <span class="count_top"><i class="fa fa-user"></i> Nº Eventos</span>
                        <div class="count"><?php echo $totalEventos ?></div>

                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count" style="width:150px">
                        <span class="count_top"><i class="fa fa-user"></i> Total Participantes</span>
                        <div class="count"><?php echo $totalParticipantes ?></div>

                    </div>
                </div>
            </div>
            <!-- /top tiles -->

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3>Novos Utilizadores <small>Desde Sempre</small></h3>
                            </div>

                        </div>

                        <div class="col-md-9 col-sm-9" style="height:300px">
                            <?php
                            echo \onmotion\apexcharts\ApexchartsWidget::widget([
                                'type' => 'area', // default area
                                'height' => '300', // default 350
                                'width' => '750', // default 100%
                                'chartOptions' => [
                                    'chart' => [
                                        'toolbar' => [
                                            'show' => true,
                                            'autoSelected' => 'zoom'
                                        ],
                                    ],
                                    'xaxis' => [
                                        'type' => 'datetime',
                                        // 'categories' => $categories,
                                    ],
                                    'plotOptions' => [
                                        'bar' => [
                                            'horizontal' => false,
                                            'endingShape' => 'rounded'
                                        ],
                                    ],
                                    'dataLabels' => [
                                        'enabled' => false
                                    ],
                                    'stroke' => [
                                        'show' => true,
                                        'colors' => ['transparent']
                                    ],
                                    'legend' => [
                                        'verticalAlign' => 'bottom',
                                        'horizontalAlign' => 'left',
                                    ],
                                ],
                                'series' => $series
                            ]);
                            ?>
                            <div id="chart_plot_01" class="demo-placeholder"></div>
                        </div>
                        <div class="col-md-3 col-sm-3  bg-white">
                            <div class="x_title">
                                <h2>Idade Utilizadores</h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="col-md-12 col-sm-12 ">
                                <div>
                                    <p>18-30 Anos</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal=<?php echo $idade18_30_Result ?>></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>31-40 Anos</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal=<?php echo $idade31_40_Result ?>></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 ">
                                <div>
                                    <p>41-55 Anos</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal=<?php echo $idade41_55_Result ?>></div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <p>56-100 Anos</p>
                                    <div class="">
                                        <div class="progress progress_sm" style="width: 76%;">
                                            <div class="progress-bar bg-green" role="progressbar" data-transitiongoal=<?php echo $idade56_100_Result ?>></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>
            <br />

            <div class="row">


                <div class="col-md-4 col-sm-4 ">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2>Bilhetes</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <h4> Últimos Bilhetes Adquiridos</h4>
                            <?php if($ultimosBilhetes != null) foreach ($ultimosBilhetes as $ticket){ ?>
                            <div class="widget_summary">
                                <div class="w_left w_25">
                                    <span style="font-size:20px">Bilhete</span>
                                </div>

                                <div class="w_right" style="margin-left :50px">
                                    <span><?php echo $ticket['data_de_compra'] ?></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 ">
                    <div class="x_panel tile fixed_height_320 overflow_hidden">
                        <div class="x_title">
                            <h2>Bilhetes</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="" style="width:100%">
                                <tr>
                                    <th style="width:37%;">
                                        <p>Bilhetes Comprados</p>
                                        <?php
                                        echo \onmotion\apexcharts\ApexchartsWidget::widget([
                                            'type' => 'bar', // default area
                                            'height' => '250', // default 350
                                            'width' => '320', // default 100%
                                            'chartOptions' => [
                                                'chart' => [
                                                    'toolbar' => [
                                                        'show' => true,
                                                        'autoSelected' => 'zoom'
                                                    ],
                                                ],
                                                'xaxis' => [
                                                    'type' => 'datetime',
                                                    // 'categories' => $categories,
                                                ],
                                                'plotOptions' => [
                                                    'bar' => [
                                                        'horizontal' => false,
                                                        'endingShape' => 'rounded'
                                                    ],
                                                ],
                                                'dataLabels' => [
                                                    'enabled' => false
                                                ],
                                                'stroke' => [
                                                    'show' => true,
                                                    'colors' => ['transparent']
                                                ],
                                                'legend' => [
                                                    'verticalAlign' => 'bottom',
                                                    'horizontalAlign' => 'left',
                                                ],
                                            ],
                                            'series' => $seriesTickets
                                        ]);
                                        ?>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="col-md-4 col-sm-4 ">
                    <div class="x_panel tile fixed_height_320">
                        <div class="x_title">
                            <h2>Produtos</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <h4>Pontos por Produto</h4>
                            <?php if($produtos != null) foreach($produtos as $produto){ ?>
                            <div class="widget_summary">
                                <div class="w_left w_25">
                                    <span><?php echo $produto['descricao'] ?></span>
                                </div>
                                <div class="w_center w_55">
                                    <div class="progress">
                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $produto['points'] ?>%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w_right w_20">
                                    <span><?php echo $produto['points'] ?></span>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <?php } ?>


                        </div>
                    </div>
                </div>

            </div>




            <!-- /page content -->

            <!-- footer content -->

            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="../vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../vendors/Flot/jquery.flot.js"></script>
    <script src="../vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../vendors/Flot/jquery.flot.time.js"></script>
    <script src="../vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../vendors/moment/min/moment.min.js"></script>
    <script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>

</body>

</html>