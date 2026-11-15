<?php
namespace api\modules\v1\controllers;

use common\models\News;
use yii\rest\ActiveController;

class NovidadeController extends  ActiveController
{
    public $modelClass = 'common\models\News';

    public function actionLatest()
    {
        return ['Novidade' => News::find()->orderBy(['id' => SORT_DESC])->one()];
    }
}