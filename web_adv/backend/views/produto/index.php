<?php

use common\models\Loja;
use common\models\Produto;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Produtos';

$idLoja = Yii::$app->request->get('idl');
?>
<div class="produto-index">
    <div>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Criar um Produto', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>


    <?php if($idLoja != null){
        $form = ActiveForm::begin(['action' => '../loja/add-products']); ?>
        <div>
            <?= Html::submitButton('Adicionar Produtos', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php } ?>

<div style="display: flex; justify-content: center">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'emptyText' => 'Não existem produtos',
        'options' => ['style' => 'flex-basis: 95%'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'format' => 'html',
                'contentOptions' => ['style' => 'text-align: center'],
                'label' => 'Imagem',
                'value' => function ($data) {
                    return Html::img('../imgs/'. $data['image'],
                        ['height' => '83px']);
                },
            ],
            'descricao',
            'quantidade',
            'points',
            [
                'attribute' => 'loja.designacao',
                'options' => ['style' => 'width: 15%'],
                'label' => 'Loja',
                'value' => function ($data) {
                    if($data['id_loja'] == null){
                        return '- -';
                    }
                    return \common\models\Loja::findOne($data['id_loja'])->designacao;
                },
            ],
            ['class' => 'yii\grid\ActionColumn', 'options' => ['style' => 'width: 7%']],
        ],
    ]); ?>
 <?php if($idLoja != null){ ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'summary' => '',
            'emptyText' => '',
            'columns' => [
                ['class' => 'yii\grid\ActionColumn',
                    'template'=>'{addToLoja}',
                    'contentOptions' => ['style' => 'height: 100px'],
                    'buttons'=>[
                        'addToLoja' => function ($url, $model, $key) use ($idLoja) {
                                $loja = Loja::findOne(['id' => $idLoja]);

                                $contains = null;

                                foreach ($loja->produtos as $produto){
                                    if($produto->id == $model->id){
                                        $contains = true;
                                    }
                                }
                                if($contains != true) {
                                    return Html::checkbox('checkbox' . $model->id, false);
                                }
                            return null;
                        }
                    ],]
            ],
        ]); ?>
<?php } ?>
</div>
<?php if($idLoja != null){
    ActiveForm::end();
} ?>
</div>


</div>
