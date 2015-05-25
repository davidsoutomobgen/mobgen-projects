<?php

/**
 * This is the model class for table "peak".
 *
 * The followings are the available columns in table 'peak':
 * @property integer $track_id
 * @property integer $point
 * @property integer $amplitude
 *
 * The followings are the available model relations:
 * @property Audio $audio
 */
class Peak extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Peak the static model class
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
		return 'peak';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('track_id, point, amplitude', 'required'),
			array('track_id, point, amplitude', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('track_id, point, amplitude', 'safe', 'on'=>'search'),
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
			'track' => array(self::BELONGS_TO, 'Track', 'track_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'track_id' => 'Audio',
			'point' => 'Point',
			'amplitude' => 'Amplitude',
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

		$criteria->compare('track_id',$this->track_id);
		$criteria->compare('point',$this->point);
		$criteria->compare('amplitude',$this->amplitude);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}