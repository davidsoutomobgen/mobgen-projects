<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $token
 *
 * The followings are the available model relations:
 * @property UserPush $userPush
 * @property Tweet[] $tweets
 */
class User extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, token', 'required'),
            array('username', 'length', 'max' => 25),
            array('password', 'length', 'max' => 60),
            array('token', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, token', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userPush' => array(self::HAS_ONE, 'UserPush', 'user_id'),
            'tweets' => array(self::MANY_MANY, 'Tweet', 'user_tweet(user_id, tweet_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'token' => 'Token',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('token', $this->token, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    public function behaviors() {
        return array(
            'EHashPasswordBehavior' => array(
                'class' => 'ext.behaviors.EHashPasswordBehavior',
            ),
        );
    }

    public static function findByToken($token) {
        return User::model()->findByAttributes(array(
                    'token' => $token,
                ));
    }
    
    public function generateToken() {
        $uniqueToken = function() {
                    do {
                        $token = md5(uniqid(mt_rand(), true));
                    } while (User::model()->exists('token = :token', array(':token' => $token)));
                    return $token;
                };
        $this->token = $uniqueToken();

        return;
    }
    
    public function getInfo() {
        $obj = new stdclass;
        $obj->username = $this->username;
        $obj->token = $this->token;
        
        return $obj;
    }

}