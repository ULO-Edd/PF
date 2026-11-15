<?php


namespace backend\models;


use borales\extensions\phoneInput\PhoneInputValidator;
use common\models\Pessoa;
use common\models\User;
use Yii;
use yii\base\Model;

class UpdateUserMobile extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $telephone;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'verifyUsername'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            [['telephone'], 'integer'],
            ['telephone', 'verifyTelephone'],
            [['telephone'], PhoneInputValidator::className()],
            [['telephone'], 'unique', 'targetClass' => '\common\models\Pessoa', 'message' => 'This telephone number has already been taken.'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'verifyEmail'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],

            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['role', 'required'],
        ];
    }

    public function updatePassword($new_password) {
        return $this->password = Yii::$app->security->generatePasswordHash($new_password);
    }

    public function findUserPessoa($id){
        $pessoa = Pessoa::findOne($id);
        $user = User::findOne($id);

        $this->username = $user->username;
        $this->telephone = $pessoa->telephone;
        $this->email = $user->email;
        $this->id = $user->getId();

        return $this;
    }



    public function update($id)
    {


        $auth = Yii::$app->authManager;

        //$new_password = $this->updatePassword($this->password);

        $user = User::findOne($id);
        $user->username = $this->username;
        $user->email = $this->email;
        // $user->password_hash = $new_password;


        if ($user->save() == true)
        {
            $pessoa = Pessoa::findOne($id);
            $pessoa->telephone = str_replace("351", "" ,$this->telephone);

            $auth->revokeall($id);
            $user_role = $auth->getRole($this->role);
            $auth->assign($user_role, $user->getId());

            return $pessoa->save() /* && $this->sendEmail($user);*/;
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
