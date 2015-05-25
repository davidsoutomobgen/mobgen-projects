<?php

/**
 * This is the model class for table "track_image".
 *
 * The followings are the available columns in table 'track_image':
 * @property integer $inapp_id
 * @property integer $particle_id
 */
class InAppParticle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TrackImage the static model class
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
		return 'in_app_particle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('inapp_id, particle_id, type_content', 'required'),
			array('inapp_id, particle_id, type_content', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('inapp_id, particle_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'inapp_id' => 'InApp ID',
			'particle_id' => 'Element',
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
		$criteria->compare('particle_id',$this->particle_id);
        $criteria->compare('type_content',$this->type_content);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}