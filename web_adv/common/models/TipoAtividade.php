<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipo_atividade".
 *
 * @property int $id
 * @property string $tipo
 *
 * @property Atividade[] $atividades
 */
class TipoAtividade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_atividade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo'], 'required', 'message' => 'É necessário inserir um tipo de atividade.'],
            [['tipo'], 'string', 'max' => 45,'tooLong' => 'O seu tipo de atividade não deverá ter mais de {max} caracteres'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * Gets query for [[Atividades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtividades()
    {
        return $this->hasMany(Atividade::className(), ['id_tipo_atividade' => 'id']);
    }
}
