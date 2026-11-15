<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "patrocinio".
 *
 * @property int $id
 * @property string $designacao
 * @property string $data_adesao
 * @property string|null $image
 *
 * @property EventoPatrocinio[] $eventoPatrocinios
 * @property Evento[] $eventos
 */
class Patrocinio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patrocinio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacao', 'data_adesao'], 'required'],
            [['data_adesao'], 'safe'],
            [['designacao'], 'string', 'max' => 450],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'designacao' => 'Designacao',
            'data_adesao' => 'Data Adesao',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[EventoPatrocinios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventoPatrocinios()
    {
        return $this->hasMany(EventoPatrocinio::class, ['id_patrocinio' => 'id']);
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::class, ['id' => 'id_evento'])->viaTable('evento_patrocinio', ['id_patrocinio' => 'id']);
    }
}
