<?php

/**
 * This is the model class for table "webuser".
 *
 * The followings are the available columns in table 'webuser':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $role
 * @property integer $active
 * @property string $last_login
 */
class Webuser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Webuser the static model class
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
		return 'webuser';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role, active', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>60),
            array('username', 'unique', 'className' => 'Webuser', 'attributeName' => 'username','message'=>'This username is already in use'),
			array('password', 'length', 'max'=>60),
			array('last_login', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, role, active, last_login', 'safe', 'on'=>'search'),
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
			'username' => 'Username',
			'password' => 'Password',
			'role' => 'Role',
			'active' => 'Active',
			'last_login' => 'Last Login',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('active',$this->active);
		$criteria->compare('last_login',$this->last_login,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors() {
        return array(
            'EHashPasswordBehavior' => array(
                'class' => 'ext.behaviors.EHashPasswordBehavior',
            ),
        );
    }

    public function getUserId(){
        $username = Yii::app()->user->id;
        $user = $this->findByAttributes(array('username' => $username));
        return $user->id;
    }


}