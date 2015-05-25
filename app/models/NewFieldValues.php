<?php

/**
 * This is the model class for table "new_field_values".
 *
 * The followings are the available columns in table 'new_field_values':
 * @property integer $id
 * @property integer $new_field
 * @property integer $view_id
 * @property string $value
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property NewField $newField
 */
class NewFieldValues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'new_field_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('new_field, view_id, value', 'required'),
			array('new_field, view_id, date_created, date_updated, deleted', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, new_field, view_id, value, date_created, date_updated, deleted', 'safe', 'on'=>'search'),
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
			'newField' => array(self::BELONGS_TO, 'NewField', 'new_field'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'new_field' => 'New Field',
			'view_id' => 'View',
			'value' => 'Value',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'deleted' => 'Deleted',
		);
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('new_field',$this->new_field);
		$criteria->compare('view_id',$this->view_id);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_updated',$this->date_updated);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NewFieldValues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
