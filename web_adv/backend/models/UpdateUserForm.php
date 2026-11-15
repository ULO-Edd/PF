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
class UpdateUserForm extends Model
{
    public $id;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['role', 'required'],
        ];
    }


    public function update($id)
    {
        $auth = Yii::$app->authManager;

        $auth->revokeall($id);
        $user_role = $auth->getRole($this->role);
        $auth->assign($user_role, $id);

        return true;
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
