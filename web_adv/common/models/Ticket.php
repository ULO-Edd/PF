<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int $id_pessoa
 * @property string|null $data_de_compra
 * @property string|null $data_de_uso
 * @property int|null $anulado
 * @property int|null $expirado
 * @property int|null $pre_compra
 * @property float|null $preco
 * @property int $numero_atividades
 *
 * @property Atividade[] $activities
 * @property ActivitiesTicket[] $activitiesTickets
 * @property Pessoa $pessoa
 */



class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pessoa'], 'required'],
            [['data_de_uso'], 'required', 'message' => 'É necessário ter uma data de uso.'],
            [['id_pessoa', 'anulado', 'expirado', 'pre_compra', 'numero_atividades'], 'integer'],
            [['data_de_compra', 'data_de_uso'], 'safe'],
            [['preco'], 'number'],
            [['id_pessoa'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::class, 'targetAttribute' => ['id_pessoa' => 'id']],

            ['data_de_uso', 'verifyDataUso'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pessoa' => 'Id Pessoa',
            'data_de_compra' => 'Data De Compra',
            'data_de_uso' => 'Data De Uso',
            'anulado' => 'Anulado',
            'expirado' => 'Expirado',
            'pre_compra' => 'Pre Compra',
            'preco' => 'Preco',
            'numero_atividades' => 'Numero Atividades'
        ];
    }

    /**
     * Gets query for [[Activities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Atividade::class, ['id' => 'id_activity'])->viaTable('activities_ticket', ['id_ticket' => 'id']);
    }

    /**
     * Gets query for [[ActivitiesTickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActivitiesTickets()
    {
        return $this->hasMany(ActivitiesTicket::class, ['id_ticket' => 'id']);
    }

    /**
     * Gets query for [[Pessoa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPessoa()
    {
        return $this->hasOne(Pessoa::class, ['id' => 'id_pessoa']);
    }

    public function containsFavorites(){
        $favs[] = null;
        $atvs[] = null;
        foreach ($this->pessoa->user->atividades as $fav){
            $favs = null;
            $favs[] = $fav->id;
        }
        foreach ($this->activities as $atv){
            $atvs = null;
            $atvs[] = $atv->id;
        }
        foreach ($favs as $fav){
            if(!in_array($fav, $atvs)){
                return false;
            }else{
                return true;
            }
        }
    }

    public function addAllFavorites($idUser, $idTicket){
        $certificador = null;

        $favoritos_user = Favorito::findAll(['id_user' => $idUser]);

        if (count($favoritos_user) == 0) {
            return 0;
        }
        foreach ($favoritos_user as $favorito) {
            $atividades = Atividade::findAll(['id' => $favorito->id_atividade]);
            foreach ($atividades as $atividade) {
                $newActivityTicket = new ActivitiesTicket();

                $newActivityTicket->id_ticket = $idTicket;
                $newActivityTicket->id_activity = $atividade->id;

                if ($newActivityTicket->validate() && $newActivityTicket->save()) {
                    $certificador = true;
                }
            }
        }
        if ($certificador == true) {
            return 1;
        }
        return -1;
    }

    public function verifyDataUso(){
        if ($this->data_de_uso <= Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'))
        {
            $this->addError('data_de_uso', 'Tem que possuir uma data superior a de hoje');
        }
    }
}
