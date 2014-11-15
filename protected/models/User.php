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
            ['date_add', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'insert'],
            ['date_update', 'default', 'value' => new CDbExpression('NOW()'), 'setOnEmpty' => false, 'on' => 'update'],
            ['is_confirmed', 'default', 'value' => 0, 'setOnEmpty' => false, 'on' => 'insert'],
            ['name, email, password, password_repeat', 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['password', 'compare'],
            ['name, email, password', 'length', 'max' => 255],
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

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('date_add', $this->date_add, true);
        $criteria->compare('date_update', $this->date_update, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    public function authenticate($password)
    {
        return $this->password === $this->crypt($password);
    }

    protected function beforeSave()
    {
        if ($this->getScenario() == self::SCENARIO_INSERT) {
            $this->password = $this->crypt($this->password);
        }

        return parent::beforeSave();
    }

    protected function crypt($password)
    {
        return crypt($password, $this->salt);
    }
}
