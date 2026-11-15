<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "produto".
 *
 * @property int $id
 * @property int $id_loja
 * @property string $descricao
 * @property int $quantidade
 * @property int $points
 * @property string|null $image
 *
 * @property Loja $loja
 */
class Produto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'produto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descricao'], 'required', 'message' => 'É necessário inserir uma descricão.'],
            [['quantidade'], 'required', 'message' => 'É necessário inserir uma quantidade.'],
            [['points'], 'required', 'message' => 'É necessário inserir o número de pontos.'],
            [['id_loja', 'quantidade', 'points'], 'integer'],
            [['descricao'], 'string', 'max' => 450,'tooLong' => 'A sua descricao não deverá ter mais de {max} caracteres'],
            [['image'], 'string', 'max' => 255],
            [['id_loja'], 'exist', 'skipOnError' => true, 'targetClass' => Loja::class, 'targetAttribute' => ['id_loja' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_loja' => 'Id Loja',
            'descricao' => 'Descricao',
            'quantidade' => 'Quantidade',
            'points' => 'Points',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[Loja]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoja()
    {
        return $this->hasOne(Loja::class, ['id' => 'id_loja']);
    }
}
