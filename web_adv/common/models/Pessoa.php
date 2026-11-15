<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pessoa".
 *
 * @property int $id
 * @property string $name
 * @property string $lastname
 * @property string $birthday_date
 * @property int|null $telephone
 * @property string|null $image
 * @property int $points
 *
 * @property User $id0
 * @property Reports[] $reports
 * @property Historico[] $historico
 * @property Ticket[] $tickets
 */
class Pessoa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pessoa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'lastname', 'birthday_date', 'points'], 'required'],
            [['birthday_date'], 'safe'],
            [['telephone', 'points'], 'integer'],
            [['name', 'lastname'], 'string', 'max' => 45],
            [['image'], 'string', 'max' => 255],
            [['telephone'], 'unique'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
            ['telephone', 'verifyTelephone']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'birthday_date' => 'Birthday Date',
            'telephone' => 'Telephone',
            'image' => 'Image',
            'points' => 'Points',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Reports::class, ['id_user' => 'id']);
    }

    public function getHistorico()
    {
        return $this->hasMany(Historico::class, ['id_user' => 'id']);
    }


    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::className(), ['id_pessoa' => 'id']);
    }

    public function verifyTelephone(){
        $pessoa = Pessoa::findOne(['telephone' => $this->telephone]);

        if ($pessoa != null)
        {
            if ($this->id != $pessoa->id)
            {
                $this->addError('telephone', 'já existe');
            }
        }
    }
}
