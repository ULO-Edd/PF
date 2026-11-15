<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "historico".
 *
 * @property int $id
 * @property int $id_user
 * @property string $data
 * @property string $titulo
 * @property string $descricao
 * @property int|null $pontos
 * @property int|null $acumulou
 *
 * @property Pessoa $user
 */
class Historico extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'data', 'titulo', 'descricao'], 'required'],
            [['id_user', 'pontos', 'acumulou'], 'integer'],
            [['data'], 'safe'],
            [['titulo'], 'string', 'max' => 45],
            [['descricao'], 'string', 'max' => 450],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'data' => 'Data',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'pontos' => 'Pontos',
            'acumulou' => 'Acumulou',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Pessoa::class, ['id' => 'id_user']);
    }
}
