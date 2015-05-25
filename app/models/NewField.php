<?php

/**
 * This is the model class for table "new_field".
 *
 * The followings are the available columns in table 'new_field':
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property integer $type_field
 * @property string $table
 * @property integer $position
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $deleted
 */
class NewField extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'new_field';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, label, type_field, table', 'required'),
			array('type_field, position, date_created, date_updated, deleted', 'numerical', 'integerOnly'=>true),
			array('name, label, table', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, label, type_field, table, position, date_created, date_updated, deleted', 'safe', 'on'=>'search'),
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
            'newFieldProjects' => array(self::MANY_MANY, 'Project', 'new_field_project(new_field_id, project_id)'),
        );
	}


    public function scopes()
    {
        return array(
            'not_deleted'=> array(
                'condition' => 'deleted = 0',
            ),
        );
    }
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'label' => 'Label',
			'type_field' => 'Type Field',
			'table' => 'Table',
			'position' => 'Position',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('label',$this->label,true);
		$criteria->compare('type_field',$this->type_field);
		$criteria->compare('table',$this->table,true);
		$criteria->compare('position',$this->position);
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
	 * @return NewField the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
