<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the api
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/atividade',
                    'extraPatterns' => [
                        'GET getall' => 'getall',
                    ],],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/novidade',
                    'extraPatterns' => [
                        'GET latest' => 'latest',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/report'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/ticket',
                    'extraPatterns' => [
                        'GET {id}/atividades' => 'atividades',
                        'DELETE {id}/remove' => 'remove',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/user',
                    'extraPatterns' => [
                        'GET {id}/tickets' => 'tickets',
                        'GET {id}/favoritos' => 'favoritos',
                        'PUT modify/{id}' => 'modify',
                        'GET get/{id}' => 'get',
                        'POST register' => 'register',
                        'DELETE <user_id:\d+>/removefav/<atividade_id:\d+>' => 'removefav',
                        'POST <user_id:\d+>/addfav/<atividade_id:\d+>' => 'addfav'
                        /*'POST {id_user}/adicionarfavorito/{id_atividade}' => 'adicionarfavorito',
                        'POST {id_user}/participar/{id_atividade}' => 'participar',
                        'DELETE {id_user}/desparticipar/{id_atividade}' => 'desparticipar',*/
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/tipo-atividade'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/topico-report'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/auth'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/participar'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/evento',
                    'extraPatterns' => [
                        'GET {id}/atividades' => 'atividades',
                        'GET latest' => 'latest',
                        ],
                ],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'v1/loja',
                    'extraPatterns' => [
                        'GET produtos' => 'produtos',
                    ],
                ],
            ],
        ]
    ],
    'params' => $params,
];
