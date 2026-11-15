<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "activities_ticket".
 *
 * @property int $id_ticket
 * @property int $id_activity
 *
 * @property Atividade $activity
 * @property Ticket $ticket
 */
class ActivitiesTicket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activities_ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ticket', 'id_activity'], 'required'],
            [['id_ticket', 'id_activity'], 'integer'],
            [['id_ticket', 'id_activity'], 'unique', 'targetAttribute' => ['id_ticket', 'id_activity']],
            [['id_activity'], 'exist', 'skipOnError' => true, 'targetClass' => Atividade::class, 'targetAttribute' => ['id_activity' => 'id']],
            [['id_ticket'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['id_ticket' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ticket' => 'Id Ticket',
            'id_activity' => 'Id Activity',
        ];
    }

    /**
     * Gets query for [[Activity]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Atividade::class, ['id' => 'id_activity']);
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['id' => 'id_ticket']);
    }
}
