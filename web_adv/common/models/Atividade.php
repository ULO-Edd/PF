<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "atividade".
 *
 * @property int $id
 * @property int $id_tipo_atividade
 * @property string $descricao
 * @property int $lotacao
 * @property string|null $image
 *
 * @property ActivitiesEvento[] $activitiesEventos
 * @property ActivitiesTicket[] $activitiesTickets
 * @property Evento[] $eventos
 * @property Favorito[] $favoritos
 * @property Participar[] $participars
 * @property Ticket[] $tickets
 * @property TipoAtividade $tipoAtividade
 * @property User[] $users
 * @property User[] $users0
 */
class Atividade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atividade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['designacao'], 'required', 'message' => 'É necessário inserir uma designação.'],
            [['descricao'], 'required', 'message' => 'É necessário inserir uma descrição.'],
            [['lotacao'], 'required', 'message' => 'É necessário inserir uma lotação.'],

            [['id_tipo_atividade'], 'required', 'message' => 'É necessário inserir um tipo de atividade.'],
            [['id_tipo_atividade', 'lotacao'], 'integer'],

            [['designacao'], 'string', 'max' => 450,'tooLong' => 'A sua designação não deverá ter mais de {max} caracteres'],
            [['descricao'], 'string', 'max' => 450,'tooLong' => 'A sua descrição não deverá ter mais de {max} caracteres'],

            [['image'], 'string', 'max' => 255],
            [['id_tipo_atividade'], 'exist', 'skipOnError' => true, 'targetClass' => TipoAtividade::class, 'targetAttribute' => ['id_tipo_atividade' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tipo_atividade' => 'Id Tipo Atividade',
            'designacao' => 'Designacao',
            'descricao' => 'Descricao',
            'lotacao' => 'Lotacao',
            'image' => 'Image',
        ];
    }

    /**
     * Gets query for [[ActivitiesEventos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivitiesEventos()
    {
        return $this->hasMany(ActivitiesEvento::class, ['id_atividade' => 'id']);
    }

    /**
     * Gets query for [[ActivitiesTickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivitiesTickets()
    {
        return $this->hasMany(ActivitiesTicket::class, ['id_activity' => 'id']);
    }

    /**
     * Gets query for [[Eventos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::class, ['id' => 'id_evento'])->viaTable('activities_evento', ['id_atividade' => 'id']);
    }

    /**
     * Gets query for [[Favoritos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritos()
    {
        return $this->hasMany(Favorito::class, ['id_atividade' => 'id']);
    }

    /**
     * Gets query for [[Participars]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParticipars()
    {
        return $this->hasMany(Participar::class, ['id_atividade' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::class, ['id' => 'id_ticket'])->viaTable('activities_ticket', ['id_activity' => 'id']);
    }

    /**
     * Gets query for [[TipoAtividade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoAtividade()
    {
        return $this->hasOne(TipoAtividade::class, ['id' => 'id_tipo_atividade']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'id_user'])->viaTable('favorito', ['id_atividade' => 'id']);
    }

    /**
     * Gets query for [[Users0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers0()
    {
        return $this->hasMany(User::class, ['id' => 'id_user'])->viaTable('participar', ['id_atividade' => 'id']);
    }
}
