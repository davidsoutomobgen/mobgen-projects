<?php

/**
 * This is the model class for table "track_track".
 *
 * The followings are the available columns in table 'track_track':
 * @property integer $track_id1
 * @property integer $track_id2
 *
 * The followings are the available model relations:
 * @property Track $trackId2
 * @property Track $trackId1
 */
class TrackTrack extends CActiveRecord
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
		return 'track_track';
	}

	public function primaryKey()
	{
		return array('track_id1', 'track_id2');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('track_id1, track_id2', 'required'),
			array('track_id1, track_id2', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('track_id1, track_id2', 'safe', 'on'=>'search'),
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
			'trackId2' => array(self::BELONGS_TO, 'Track', 'track_id2'),
			'trackId1' => array(self::BELONGS_TO, 'Track', 'track_id1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'track_id1' => 'Track Id1',
			'track_id2' => 'Track Id2',
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

		$criteria->compare('track_id1',$this->track_id1);
		$criteria->compare('track_id2',$this->track_id2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}