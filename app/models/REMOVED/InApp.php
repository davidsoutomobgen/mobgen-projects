<?php
 /**
  * This is the model class for table "in_app".
  *
  * The followings are the available columns in table 'in_app':
  * @property integer $id
  * @property string $title
  * @property string $description
  * @property string $notes
  * @property string $bundle
  * @property string $type
  * @property integer $status
  * @property integer $date_created
  * @property integer $date_updated
 */
class InApp extends ActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'in_app';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, bundle, description', 'required'),
            array('bundle', 'unique'),
			array('status, date_created, date_updated', 'numerical', 'integerOnly'=>true),
			array('title, bundle', 'length', 'max'=>255),
			array('type', 'length', 'max'=>2),
			array('description, notes', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, description, notes, bundle, type, date_created, date_updated', 'safe', 'on'=>'search'),
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
            'inAppTracks' => array(self::MANY_MANY, 'Track', 'in_app_track(inapp_id, track_id)'),
            'inAppPaintings' => array(self::MANY_MANY, 'InApp', 'in_app_painting(inapp_id, painting_id)'),
            'inAppParticles' => array(self::MANY_MANY, 'InApp', 'in_app_particle(inapp_id, particle_id)'),
            'inAppVideos' => array(self::MANY_MANY, 'InApp', 'in_app_video(inapp_id, video_id)'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'notes' => 'Notes',
			'bundle' => 'Bundle',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
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

        $criteria->condition = 'status != 99';

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('bundle',$this->bundle,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_updated',$this->date_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InApp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = 1',
            ),
            'published_inapp'=> array(
                'condition' => 'status = 1 and in_app = 1',
            ),
        );
    }

    public function getStatus()
    {
        return array(
            0 => "Unplublished",
            1 => "Published",
        );
    }

    public function getStatusText($price_type)
    {
        switch ($price_type) {
            case 0:
                return "Published";
            case 1:
                return "Published";
            default:
                return false;
        }
    }

    /*
public function getAllOption(){
    $query = 'SELECT t.id, t.title, c.title as collection FROM track t INNER JOIN collection c ON c.id = t.collection_id WHERE (status = 1 and in_app = 1) AND (t.id !=9)
UNION
SELECT id, title, title as collection FROM particle  p WHERE (status = 1 and in_app = 1) AND (id !=9)';

    return Yii::app()->db->createCommand($query)->setFetchMode(PDO::FETCH_OBJ);

}
    */

/*
    public function getStatus()
    {
        return array(
            1 => "Unpublished",
            2 => "Publishes",
            3 => "In-App",

        );
    }
    */
}
