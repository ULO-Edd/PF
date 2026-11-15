<?php

namespace common\models;


use backend\mosquitto\phpMQTT;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property string $date_expire
 * @property string|null $image
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required', 'message' => 'É necessário inserir um título.'],
            [['descricao'], 'required', 'message' => 'É necessário inserir uma descrição.'],
            [['date_expire'], 'required', 'message' => 'É necessário inserir uma data de validade.'],
            [['date_expire'], 'safe'],
            [['titulo'], 'string', 'max' => 45,'tooLong' => 'O seu título não deverá ter mais de {max} caracteres'],
            [['descricao'], 'string', 'max' => 450,'tooLong' => 'A sua descricão não deverá ter mais de {max} caracteres'],
            [['image'], 'string', 'max' => 255],
            [['image'], 'file', 'extensions' => 'jpg,png,gif']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descricao' => 'Descricao',
            'date_expire' => 'Date Expire',
            'image' => 'Image',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        //Obter dados do registo em causa
        $id = $this->id;
        $titulo = $this->titulo;
        $descricao = $this->descricao;
        $date_expire = $this->date_expire;
        $image = $this->image;
        $myObj=new \stdClass();
        $myObj->id=$id;
        $myObj->titulo=$titulo;
        $myObj->descricao=$descricao;
        $myObj->date_expire=$date_expire;
        $myObj->image=$image;
        $myJSON = json_encode($myObj);
        if($insert)
            $this->FazPublishNoMosquitto("INSERT",$myJSON);
        else
            $this->FazPublishNoMosquitto("UPDATE",$myJSON);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $prod_id= $this->id;
        $myObj=new \stdClass();
        $myObj->id=$prod_id;
        $myJSON = json_encode($myObj);
        $this->FazPublishNoMosquitto("DELETE",$myJSON);
    }

    public function FazPublishNoMosquitto($canal,$msg)
    {
        $server = "broker.emqx.io";
        $port = 1883;
        $username = ""; // set your username
        $password = ""; // set your password
        $client_id = "PHP"; // unique!
        $mqtt = new phpMQTT($server, $port, $client_id);
        if ($mqtt->connect(true, NULL, $username, $password))
        {

            $mqtt->publish($canal, $msg, 1);
            $mqtt->close();
        }
        else { file_put_contents('debug.output',"Time out!"); }
}
}
