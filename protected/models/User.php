<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $password_repeat
 * @property string $is_confirmed
 * @property string $hash_confirm
 * @property string $date_add
 * @property string $date_update
 */
class User extends ActiveRecord
{
    const ROLE_GUEST = 0;
    const ROLE_USER = 1;

    public $password_repeat;

    private $salt = '1J!0Gb$Ifu@_OLMa';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['date_add', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => self::SCENARIO_INSERT],
            ['date_update', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => self::SCENARIO_UPDATE],
            ['is_confirmed', 'default', 'value' => 0, 'setOnEmpty' => false, 'on' => self::SCENARIO_INSERT],
            ['name, email, password, password_repeat', 'required', 'on' => self::SCENARIO_INSERT],
            ['email', 'email'],
            ['email', 'unique'],
            ['password', 'compare'],
            ['name, email, password', 'length', 'max' => 255],
            ['password_repeat', 'safe'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'date_add' => 'Date Add',
            'date_update' => 'Date Update',
        ];
    }

    public function scopes()
    {
        return [
            'confirmed' => [
                'condition' => 'is_confirmed=1',
            ],
        ];
    }

    public function authenticate($password)
    {
        return $this->password === $this->crypt($password);
    }

    protected function beforeSave()
    {
        if ($this->password_repeat) { //user set up password (registration or profile edit)
            $this->password = $this->crypt($this->password);
        }
        if ($this->getIsNewRecord()) {
            $this->hash_confirm = md5($this->email . microtime(true));
        }

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if ($this->getIsNewRecord()) {
            Yii::app()->userMailer->accountConfirm($this);
        }
        return parent::afterSave();
    }


    protected function crypt($password)
    {
        return crypt($password, $this->salt);
    }
}
