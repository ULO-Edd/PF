<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "topico_report".
 *
 * @property int $id
 * @property string $topico
 *
 * @property Reports[] $reports
 */
class TopicoReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topico_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['topico'], 'required', 'message' => 'É necessário inserir um tópico.'],
            [['topico'], 'string', 'max' => 50],
            [['topico'], 'string', 'min' => 5,'tooShort' => 'O seu tópico não deverá ter menos de {min} caracteres.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topico' => 'Topico',
        ];
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Reports::className(), ['id_topico' => 'id']);
    }
}
