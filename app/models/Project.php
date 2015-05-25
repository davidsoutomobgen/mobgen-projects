<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property string $alias
 * @property string $logo
 * @property string $description
 * @property integer $active
 * @property integer $internal
 * @property string $additional_information
 * @property string $onboarding_document
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property ProjectType[] $projectTypes
 */
class Project extends ActiveRecord
{
    public $project;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Track the static model class
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
		return 'project';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, alias, description', 'required'),
			array('active, internal, date_created, date_updated, deleted', 'numerical', 'integerOnly'=>true),
			array('name, alias, logo', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, alias, logo, description, active, internal, additional_information, onboarding_document, date_created, date_updated, deleted', 'safe', 'on'=>'search'),
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
			'projectTypes' => array(self::HAS_MANY, 'ProjectType', 'project_id'),
           // 'projectTypes' => array(self::MANY_MANY, 'ProjectType', 'project_type(project_id, dtype_id)'),
            'newFieldProjects' => array(self::MANY_MANY, 'NewFieldProject', 'new_field_project(new_field_id, project_id)'),
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
			'alias' => 'Alias',
			'logo' => 'Logo',
			'description' => 'Description',
			'active' => 'Active',
			'internal' => 'Internal',
			'additional_information' => 'Additional Information',
			'onboarding_document' => 'Onboarding Document',
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('internal',$this->internal);
		$criteria->compare('additional_information',$this->additional_information,true);
		$criteria->compare('onboarding_document',$this->onboarding_document,true);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_updated',$this->date_updated);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getTypePath()
    {
        return _app()->basePath.DS.'..'.DS.'html'.DS.'files'.DS.'projects'.DS;
    }


    public function getImageFile()
    {
        return CHtml::image(Utils::imageUrl('..' . DS . 'files' . DS . 'projects' . DS . $this->thumb), '', array('style' => 'width:90px;height:90px;'));
    }

    public function getThumb()
    {
        $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
        return basename($this->filename, '.' . $ext) . '_thumb.' . $ext;
    }

}
