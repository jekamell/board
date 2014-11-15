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
 */
class Product extends CActiveRecord
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
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
            ['title, price , image', 'required'],
			['is_deleted', 'numerical', 'integerOnly' => true],
			['title', 'length', 'max' => 255],
			['price', 'length', 'max' => 12],
            ['image', 'file', 'types' => 'jpeg, png', 'maxSize' => Yii::app()->params['image']['maxSize'] * 1024 * 1024],
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
}
