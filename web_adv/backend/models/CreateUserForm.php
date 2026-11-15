<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Pessoa;
use borales\extensions\phoneInput\PhoneInputValidator;

/**
 * Signup form
 */
class CreateUserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $lastname;
    public $birthday_date;
    public $telephone;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'É necessário inserir um username.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Já existe um utilizador com esse nome.'],
            ['username', 'string', 'min' => 2, 'max' => 255,'tooLong' => 'O seu username não deverá ter mais de {max} caracteres', 'tooShort' => 'O seu username não deverá ter menos de {min} caracteres'],

            ['name', 'trim'],
            ['name', 'required', 'message' => 'É necessário inserir um nome.'],
            ['name', 'string','max' => 45,'tooLong' => 'O seu nome não deverá ter mais de {max} caracteres'],

            ['lastname', 'trim'],
            ['lastname', 'required', 'message' => 'É necessário inserir um apelido.'],
            ['lastname', 'string','max' => 45,'tooLong' => 'O seu apelido não deverá ter mais de {max} caracteres'],

            ['birthday_date', 'required', 'message' => 'É necessário inserir uma data de nascimento.'],
            ['birthday_date', 'safe'],
            ['birthday_date', 'date', 'format' => 'yyyy-MM-dd'],

            [['telephone'], 'integer'],
            [['telephone'], PhoneInputValidator::className()],
            [['telephone'], 'unique', 'targetClass' => '\common\models\Pessoa', 'message' => 'Este número de telefone já foi utilizado.'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'É necessário inserir um email.'],
            ['email', 'string', 'max' => 255,'tooLong' => 'O seu email não deverá ter mais de {max} caracteres'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já foi utilizado.'],

            ['password', 'required', 'message' => 'É necessário inserir uma password.'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['role', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        $auth = Yii::$app->authManager;

        if (!$this->validate()) {
            return null;
        }


        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();



        if ($user->save() == true)
        {

            $pessoa = new Pessoa();
            $pessoa->id = $user->id;
            $pessoa->name = $this->name;
            $pessoa->lastname = $this->lastname;
            $pessoa->birthday_date = $this->birthday_date;
            $pessoa->telephone = str_replace("351", "" ,$this->telephone);
            $pessoa->points = 0;

            $user_role = $auth->getRole($this->role);
            $auth->assign($user_role, $user->getId());

            return $pessoa->save();
        }

        return false;

    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
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
}
