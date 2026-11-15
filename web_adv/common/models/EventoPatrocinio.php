<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evento_patrocinio".
 *
 * @property int $id_evento
 * @property int $id_patrocinio
 *
 * @property Evento $evento
 * @property Patrocinio $patrocinio
 */
class EventoPatrocinio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento_patrocinio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_evento', 'id_patrocinio'], 'required'],
            [['id_evento', 'id_patrocinio'], 'integer'],
            [['id_evento', 'id_patrocinio'], 'unique', 'targetAttribute' => ['id_evento', 'id_patrocinio']],
            [['id_evento'], 'exist', 'skipOnError' => true, 'targetClass' => Evento::class, 'targetAttribute' => ['id_evento' => 'id']],
            [['id_patrocinio'], 'exist', 'skipOnError' => true, 'targetClass' => Patrocinio::class, 'targetAttribute' => ['id_patrocinio' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_evento' => 'Id Evento',
            'id_patrocinio' => 'Id Patrocinio',
        ];
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

    /**
     * Gets query for [[Patrocinio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPatrocinio()
    {
        return $this->hasOne(Patrocinio::class, ['id' => 'id_patrocinio']);
    }
}
