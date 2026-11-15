<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_topico
 * @property string $descricao
 *
 * @property TopicoReport $topico
 * @property Pessoa $user
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_topico'], 'required', 'message' => 'É necessário inserir um tópico.'],
            [['descricao'], 'required', 'message' => 'É necessário inserir uma descricão.'],

            [['id_user', 'id_topico', 'descricao'], 'required'],
            [['id_user', 'id_topico'], 'integer'],
            [['descricao'], 'string', 'max' => 450, 'min' => 10,'tooLong' => 'A sua descricão não deverá ter mais de {max} caracteres', 'tooShort' => 'A sua descricão não deverá ter menos de {min} caracteres'],
            [['id_topico'], 'exist', 'skipOnError' => true, 'targetClass' => TopicoReport::class, 'targetAttribute' => ['id_topico' => 'id']],
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
            'id_topico' => 'Id Topico',
            'descricao' => 'Descricao',
        ];
    }

    /**
     * Gets query for [[Topico]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTopico()
    {
        return $this->hasOne(TopicoReport::class, ['id' => 'id_topico']);
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
