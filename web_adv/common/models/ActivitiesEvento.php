<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activities_evento".
 *
 * @property int $id_evento
 * @property int $id_atividade
 *
 * @property Atividade $atividade
 * @property Evento $evento
 */
class ActivitiesEvento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activities_evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_evento', 'id_atividade'], 'required'],
            [['id_evento', 'id_atividade'], 'integer'],
            [['id_evento', 'id_atividade'], 'unique', 'targetAttribute' => ['id_evento', 'id_atividade']],
            [['id_atividade'], 'exist', 'skipOnError' => true, 'targetClass' => Atividade::class, 'targetAttribute' => ['id_atividade' => 'id']],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_evento' => 'Id Evento',
            'id_atividade' => 'Id Atividade',
        ];
    }

    /**
     * Gets query for [[Atividade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtividade()
    {
        return $this->hasOne(Atividade::class, ['id' => 'id_atividade']);
    }

    /**
     * Gets query for [[Evento]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEvento()
    {
        return $this->hasOne(Evento::class, ['id' => 'id_evento']);
    }
}
