<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Pessoa;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * Signup form
 */
class UpdateUserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $telephone;
    public $name;
    public $lastname;
    public $image;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'verifyUsername'],
            ['username', 'required', 'message' => 'É necessário inserir um username.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 21,'tooLong' => 'O seu username não deverá ter mais de {max} caracteres', 'tooShort' => 'O seu username não deverá ter menos de {min} caracteres'],

            [['telephone'], 'integer'],
            ['telephone', 'verifyTelephone', 'message' => 'É necessário inserir um número de telefone válido'],
            [['telephone'], PhoneInputValidator::className()],
            [['telephone'], 'unique', 'targetClass' => '\common\models\Pessoa', 'message' => 'Este número de telefone já foi utilizado.'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'É necessário inserir um email.'],
            ['email', 'verifyEmail'],
            ['email', 'email', 'message' => 'É necessário inserir um email válido'],
            ['email', 'string', 'max' => 31,'tooLong' => 'O seu email não deverá ter mais de {max} caracteres'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já foi utilizado.'],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['name', 'trim'],
            ['name', 'required', 'message' => 'É necessário inserir um nome.'],
            ['name', 'string', 'max' => 45,'tooLong' => 'O seu nome não deverá ter mais de {max} caracteres'],

            ['lastname', 'trim'],
            ['lastname', 'required', 'message' => 'É necessário inserir um apelido.'],
            ['lastname', 'string', 'max' => 45,'tooLong' => 'O seu apelido não deverá ter mais de {max} caracteres'],

            [['image'], 'string', 'max' => 255],
        ];
    }

    public function updatePassword($new_password) {
        return $this->password = Yii::$app->security->generatePasswordHash($new_password);
    }

    public function findUserPessoa($id){
        $pessoa = Pessoa::findOne($id);
        $user = User::findOne($id);

        $this->username = $user->username;
        $this->name = $pessoa->name;
        $this->lastname = $pessoa->lastname;
        $this->image = $pessoa->image;
        $this->telephone = $pessoa->telephone;
        $this->email = $user->email;
        $this->id = $user->getId();

        return $this;
    }



    public function update($id)
    {
        //$new_password = $this->updatePassword($this->password);

        $user = User::findOne($id);
        $user->username = $this->username;
        $user->email = $this->email;
        // $user->password_hash = $new_password;


        if ($user->save() == true)
        {
            $pessoa = Pessoa::findOne($id);
            $pessoa->telephone = str_replace("351", "" ,$this->telephone);
            $pessoa->name = $this->name;
            $pessoa->lastname = $this->lastname;
            if($this->image != null){
                $pessoa->image = $this->image;
            }


            return $pessoa->save();
        }

        return false;

    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */

    /*
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
    */

    public function verifyEmail(){
        $user = User::findOne(['email' => $this->email]);

        if ($user != null)
        {
            if ($this->id != $user->id)
            {
                $this->addError('email', 'já existe');
            }
        }
    }

    public function verifyUsername(){
        $user = User::findOne(['username' => $this->username]);

        if ($user != null)
        {
            if ($this->id != $user->id)
            {
                $this->addError('username', 'já existe');
            }
        }
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
