<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property integer $id_project
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $company
 * @property string $job_title
 * @property string $image
 * @property integer $active
 * @property integer $user
 * @property integer $date_created
 * @property integer $date_updated
 * @property integer $deleted
 */
class Client extends CActiveRecord
{
    public $client;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_project, name, email, job_title', 'required'),
			array('id_project, active, user, date_created, date_updated, deleted', 'numerical', 'integerOnly'=>true),
			array('name, email, phone, company, job_title, image', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_project, name, email, phone, company, job_title, image, active, user, date_created, date_updated, deleted', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'id_project' => 'Id Project',
			'name' => 'Name',
			'email' => 'Email',
			'phone' => 'Phone',
			'company' => 'Company',
			'job_title' => 'Job Title',
			'image' => 'Image',
			'active' => 'Active',
			'user' => 'User',
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
		$criteria->compare('id_project',$this->id_project);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('job_title',$this->job_title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('user',$this->user);
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
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getClientPath()
    {
        return _app()->basePath.DS.'..'.DS.'html'.DS.'files'.DS.'clients'.DS;
    }


    public function getImageFile()
    {
        return CHtml::image(Utils::imageUrl('..' . DS . 'files' . DS . 'clients' . DS . $this->thumb), '', array('style' => 'width:90px;height:90px;'));
    }

    public function getThumb()
    {
        $ext = pathinfo($this->filename, PATHINFO_EXTENSION);
        return basename($this->filename, '.' . $ext) . '_thumb.' . $ext;
    }
}
