<?php

/**
 * This is the model class for table "track".
 *
 * The followings are the available columns in table 'track':
 * @property integer $id
 * @property string $title
 * @property string $version
 * @property integer $collection_id
 * @property string $mp3
 * @property string $wav
 * @property integer $length
 * @property integer $length_type
 * @property integer $points
 * @property integer $bpm
 * @property integer $probability
 * @property string $lyrics
 * @property string $about
 * @property string $notes
 * @property integer $status
 * @property string $visuals
 * @property integer $date_created
 * @property integer $date_updated
 *
 * The followings are the available model relations:
 * @property Peak[] $peaks
 * @property Collection $collection
 * @property Image[] $images
 * @property Track[] $relatedTracks
 */
class Track extends ActiveRecord
{
	public $mp3File;
	public $wavFile;
	public $imageIds;

	public $gradient_start;
	public $gradient_end;

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
		return 'track';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, collection_id, in_app', 'required'),
			array('mp3File, wavFile', 'required', 'on'=>'insert'),
			array('mp3File', 'file', 'types'=>'mp3, aac', 'allowEmpty'=>true),
			array('wavFile', 'file', 'types'=>'wav', 'allowEmpty'=>true),
			array('probability', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>100),
			array('collection_id, in_app, length, length_type, points, bpm, probability, status, date_created, date_updated', 'numerical', 'integerOnly'=>true),
			array('title, version, mp3, wav', 'length', 'max'=>255),
			array('about, lyrics, notes, gradient_start, gradient_end, date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, version, collection_id, in_app, mp3, wav, length, length_type, points, bpm, probability, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'peaks' => array(self::HAS_MANY, 'Peak', 'track_id'),
			'collection' => array(self::BELONGS_TO, 'Collection', 'collection_id'),
			'images' => array(self::MANY_MANY, 'Image', 'track_image(track_id, image_id)', 'index'=>'id'),
			'relatedTracks' => array(self::MANY_MANY, 'Track', 'track_track(track_id1, track_id2)'),
            //'inAppTracks' => array(self::MANY_MANY, 'Track', 'in_app_particle(particle_id)'),
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
			'version' => 'Version',
                        'in_app' => 'Type',
			'collection_id' => 'Collection',
			'file' => 'File',
			'mp3File' => 'File (mp3)',
			'wavFile' => 'File (wav)',
			'length' => 'Length',
			'length_type' => 'Length Type',
			'points' => 'Points',
			'bpm' => 'BPM',
			'probability' => 'Probability',
			'lyrics' => 'Lyrics',
			'about' => 'About',
			'notes' => 'Notes',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
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

		$criteria->condition = 'status != 99';

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('version',$this->version,true);
                $criteria->compare('in_app',$this->in_app);
		$criteria->compare('collection_id',$this->collection_id);
		$criteria->compare('mp3',$this->mp3,true);
		$criteria->compare('wav',$this->wav,true);
		$criteria->compare('length',$this->length);
		$criteria->compare('length_type',$this->length_type);
		$criteria->compare('points',$this->points);
		$criteria->compare('bpm',$this->bpm);
		$criteria->compare('probability',$this->probability);
		$criteria->compare('date_created',$this->date_created);
		$criteria->compare('date_updated',$this->date_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>20,
			),
		));
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

	public function getTrackUrl()
	{
		return _app()->baseUrl.DS.'..'.DS.'track'.DS;
	}

	public function getTrackPath()
	{
		return _app()->basePath.DS.'..'.DS.'html'.DS.'track'.DS;
	}

	public function getLengthTypes()
	{
		return array(
			1 => 'short',
			2 => 'medium',
			3 => 'long',
		);
	}

	public function getLengthTypeText($length_type)
	{
		switch ($length_type) {
			case 1: return "short"; break;
			case 2: return "medium"; break;
			case 3: return "long"; break;
			default: return false; break;
		}
	}



	protected function afterFind()
	{
		if ($this->images) {
			$this->imageIds = array_keys($this->images);
		}
		if ($this->visuals) {
			$visuals = CJSON::decode($this->visuals) ? : array();
			foreach ($visuals as $key => $value) {
				$this->$key = $value;
			}
		}
		parent::afterFind();
	}

	protected function beforeSave()
	{
		$this->visuals = CJSON::encode(array(
			'gradient_start' => $this->gradient_start,
			'gradient_end' => $this->gradient_end,
		));
		return parent::beforeSave();
	}
}