<?php

/**
 * This is the model class for table "system".
 *
 * The followings are the available columns in table 'system':
 * @property integer $id
 * @property string $last_update
 * @property string $min_app_version
 * @property string $build_url
 */
class System extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return System the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'system';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('last_update', 'required'),
            array('min_app_version', 'length', 'max' => 7),
            array('build_url', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, last_update, min_app_version, build_url', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'last_update' => 'Last Update',
            'min_app_version' => 'Min App Version',
            'build_url' => 'Build Url',
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
        $criteria->compare('last_update', $this->last_update, true);
        $criteria->compare('min_app_version', $this->min_app_version, true);
        $criteria->compare('build_url', $this->build_url, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}