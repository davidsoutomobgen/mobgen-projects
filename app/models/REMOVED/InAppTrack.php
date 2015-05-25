<?php

/**
 * This is the model class for table "track_track".
 *
 * The followings are the available columns in table 'track_track':
 * @property integer $inapp_id
 * @property integer $track_id
 *
 * The followings are the available model relations:
 * @property Track $trackId2
 * @property Track $trackId1
 */
class InAppTrack extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TrackTrack the static model class
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
		return 'in_app_track';
	}

	public function primaryKey()
	{
		return array('inapp_id', 'track_id');
	}


	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inapp_id, track_id', 'required'),
			array('inapp_id, track_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inapp_id, track_id', 'safe', 'on'=>'search'),
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
			'inAppTrack' => array(self::BELONGS_TO, 'Track', 'track_id'),
			'inAppId' => array(self::BELONGS_TO, 'InApp', 'inapp_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inapp_id' => 'In app',
			'track_id' => 'Track Id',
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

		$criteria->compare('inapp_id',$this->inapp_id);
		$criteria->compare('track_id',$this->track_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}