<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $title
 * @property string $price
 * @property integer $is_deleted
 * @property string $user_id
 * @property string $date_add
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property User $user
 *
 * The followings are the available behavior methods:
 * @method saveImage()
 * @method makeThumb
 * @method getHttpPath($filePrefix)
 */
class Product extends ActiveRecord
{
    public $image;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'product';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return [
            'fileBehavior' => [
                'class' => 'FileBehavior',
                'basePath' => Yii::getPathOfAlias('webroot') . Yii::app()->params['image']['savePath']
            ]
        ];
    }

    public function scopes()
    {
        return [
            'noDeleted' => [
                'condition' => 'is_deleted=0',
            ],
            'orderedDateDesc' => [
                'order' => 't.`date_add` DESC'
            ],
        ];
    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            [
                'date_add',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => self::SCENARIO_INSERT
            ],
            [
                'date_update',
                'default',
                'value' => new CDbExpression('NOW()'),
                'setOnEmpty' => false,
                'on' => self::SCENARIO_UPDATE
            ],
            [
                'user_id',
                'default',
                'value' => Yii::app()->getUser()->getId(),
                'setOnEmpty' => false,
                'on' => self::SCENARIO_INSERT
            ], // can get Exception here when app run in console mode, but we have not this case now
            ['title, price', 'required'],
            ['is_deleted', 'numerical', 'integerOnly' => true],
            ['title', 'length', 'max' => 255],
            ['price', 'length', 'max' => 12],
            [
                'image',
                'file',
                'types' => 'jpeg, png',
                'maxSize' => Yii::app()->params['image']['maxSize'] * 1024 * 1024
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'is_deleted' => 'Is Deleted',
            'user_id' => 'User',
            'date_add' => 'Date Add',
            'date_update' => 'Date Update',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('is_deleted', 0);
        if (($user = Yii::app()->getUser()) && !$user->getIsGuest()) {
            $criteria->compare('user_id', $user->getId());
        }

        $sort = new CSort();
        $sort->defaultOrder = '`date_add` DESC';

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => 2,
            ],
        ]);
    }

    protected function afterSave()
    {
        if ($this->image && $this->saveImage()) {
            $this->makeThumb();
        }

        return parent::afterSave();
    }


}
