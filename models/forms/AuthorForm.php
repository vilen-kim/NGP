<?php

namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Auth;
use app\models\UserProfile;
use app\models\forms\ActivateForm;

class AuthorForm extends Model {

    public $firstname;
    public $lastname;
    public $middlename;
    public $email;
    public $organization;
    public $phone;



    public function rules() {
        $rules = [
            [['firstname', 'lastname', 'email'], 'required', 'message' => 'Это обязательное поле'],
            [['firstname', 'lastname', 'middlename', 'email'], 'string', 'max' => 128],
            ['email', 'email'],
            ['organization', 'string', 'max' => 1024],
            ['phone', 'string', 'max' => 32],
        ];
        return $rules;
    }



    public function attributeLabels() {
        return [
            'email' => '* Электронная почта',
            'firstname' => '* Имя',
            'lastname' => '* Фамилия',
            'middlename' => 'Отчество',
            'organization' => 'Наименование организации (юридического лица)',
            'phone' => 'Номер телефона',
            'fio' => 'ФИО',
        ];
    }



    public function getFio() {
        return $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename;
    }



    public function createAuthor() {
        if ($auth = Auth::findByEmail($this->email)) {
            return $auth->id;
        }
        $transaction = Yii::$app->db->beginTransaction();
            $auth = new Auth;
            $auth->email = $this->email;
            $auth->status = Auth::STATUS_INACTIVE;
            $auth->password_hash = '12345';
            $auth->generateAuthKey();
            if (!$auth->save()) {
                $transaction->rollBack();
                return $auth->errors;
            }

            $profile = new UserProfile;
            $profile->auth_id = $auth->id;
            $profile->firstname = $this->firstname;
            $profile->lastname = $this->lastname;
            $profile->middlename = $this->middlename;
            $profile->phone = $this->phone;
            $profile->organization = $this->organization;
            if (!$profile->save()) {
                $transaction->rollBack();
                return $profile->errors;
            }

            $role = Yii::$app->authManager->getRole('user');
            if (Yii::$app->authManager->assign($role, $auth->id)){
                $activate = new ActivateForm();
                $activate->email = $auth->email;
                if ($activate->sendEmail()){
                    $transaction->commit();
                    return $auth->id;
                }
            }
        $transaction->rollBack();
        return false;
    }
}
