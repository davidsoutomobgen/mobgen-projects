<?php

/**
 * This is the model class for table "collection".
 *
 * The followings are the available columns in table 'collection':
 * @property integer $id
 * @property string $title
 * @property string $price_type
 *
 * The followings are the available model relations:
 * @property Audio[] $audios
 */
class Collection extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Collection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'collection';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, price_type', 'required'),
			array('title', 'length', 'max'=>255),
			array('price_type', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, price_type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'audios' => array(self::HAS_MANY, 'Audio', 'collection_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'price_type' => 'Price Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('price_type',$this->price_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getPriceTypes()
	{
		return array(
			1 => "free",
			2 => "regular",
			3 => "premium",
		);
	}

	public function getPriceTypeText($price_type)
	{
		switch ($price_type) {
			case 1:
				return "free";
			case 2:
				return "regular";
			case 3:
				return "premium";
			default:
				return false;
		}
	}

}