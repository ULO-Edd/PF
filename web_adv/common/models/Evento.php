<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "evento".
 *
 * @property int $id
 * @property string $designacao
 * @property string $descricao
 * @property string $data_inicio
 * @property string $data_conclusao
 * @property int $pontos_participacao
 * @property string|null $image
 * @property int|null $ativo
 *
 * @property ActivitiesEvento[] $activitiesEventos
 * @property Atividade[] $atividades
 * @property EventoPatrocinio[] $eventoPatrocinios
 */
class Evento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'evento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_inicio'], 'required', 'message' => 'É necessário inserir uma data de início.'],
            [['data_conclusao'], 'required', 'message' => 'É necessário inserir uma data de conclusão.'],
            [['pontos_participacao'], 'required', 'message' => 'É necessário inserir os pontos de participação.'],

            [['designacao'], 'required', 'message' => 'É necessário inserir uma designação.'],
            [['descricao'], 'required', 'message' => 'É necessário inserir uma descrição.'],

            [['data_inicio', 'data_conclusao'], 'safe'],
            [['pontos_participacao'], 'integer'],
            [['designacao'], 'string', 'max' => 50,'tooLong' => 'A sua designação não deverá ter mais de {max} caracteres'],
            [['descricao'], 'string', 'max' => 450,'tooLong' => 'A sua descrição não deverá ter mais de {max} caracteres'],

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
            'descricao' => 'Descricao',
            'data_inicio' => 'Data Inicio',
            'data_conclusao' => 'Data Conclusao',
            'pontos_participacao' => 'Pontos Participacao',
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
        return $this->hasMany(ActivitiesEvento::class, ['id_evento' => 'id']);
    }

    /**
     * Gets query for [[Atividades]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtividades()
    {
        return $this->hasMany(Atividade::class, ['id' => 'id_atividade'])->viaTable('activities_evento', ['id_evento' => 'id']);
    }
}
