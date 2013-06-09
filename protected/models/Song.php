<?php

Yii::import('application.lib.RUtils.RUtils');

/**
 * This is the model class for table "song".
 *
 * The followings are the available columns in table 'song':
 * @property integer $id
 * @property string $title
 * @property string $art_url
 * @property integer $bpm
 * @property string $file_name
 * @property string $waveform_image
 */
class Song extends CActiveRecord
{
	public $songFile; // saves the CUploadedFile object for file_name

	/**
    * Saves the name, size, type and data of the uploaded file
    */
    public function afterSave()
    {
    	if($file=CUploadedFile::getInstance($this,'songFile'))
        {
			$this->file_name = RUtils::cleanFileName(sprintf("%s_%s.%s", $this->id, $this->title, $file->extensionName));
			// die(sprintf("[%s]", $this->file_name));
			$savePath = $this->songFilePath;
			$file->saveAs($savePath);
			$this->isNewRecord = false;
			$this->saveAttributes(array('file_name'));
        }

		return parent::afterSave();
    }

	/**
    * Remove the file from disk
    */
    public function afterDelete()
    {
        unlink($this->songFilePath); 
		return parent::afterDelete();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Song the static model class
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
		return 'song';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, bpm', 'numerical', 'integerOnly'=>true),
			array('title, art_url, file_name, waveform_image', 'length', 'max'=>100),
			array('art_url, waveform_image', 'url'),
			array('songFile', 'file', 'maxSize'=>16*1024*1024),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, art_url, bpm, file_name, waveform_image', 'safe', 'on'=>'search'),
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
			// 'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
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
			'art_url' => 'Art Url',
			'bpm' => 'Bpm',
			'file_name' => 'Song',
			'waveform_image' => 'Wavform Image',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('art_url',$this->art_url,true);
		$criteria->compare('bpm',$this->bpm);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('waveform_image',$this->waveform_image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	# utility functions for getting paths and urls.

	public $_songsFolder;
	public $_waveImagesFolder;
	public $_dataFolder;
	public $_dataUrl;
	public $_songsUrl;
	public $_waveImagesUrl;


	/*** get Folders ***/
	// The folder that contains the data
	public function getDataFolder() {
		if(!$this->_dataFolder) {
			$this->_dataFolder = sprintf("%s\\static", str_replace('\protected', '', Yii::app()->basePath));
			$this->createdir(sprintf("%s\\static", str_replace('\protected', '', Yii::app()->basePath)));
			$this->createdir($this->_dataFolder);
		}
		return $this->_dataFolder;
	}
	// The folder that contains the songs
	public function getSongsFolder() {
		if(!$this->_songsFolder) {
			$this->_songsFolder = sprintf("%s\\songs", $this->dataFolder);
			$this->createdir($this->_songsFolder);
		}
		return $this->_songsFolder;
	}
	// The folder that contains the wave images
	public function getWaveImagesFolder() {
		if(!$this->_waveImagesFolder) {
			$this->_waveImagesFolder = sprintf("%s\\wave_images", $this->dataFolder);
			$this->createdir($this->_waveImagesFolder);
		}
		return $this->_waveImagesFolder;
	}


	/*** get File paths ***/	
	// returns the full path where this file is stored
    public function getSongFilePath()
    {
    	return sprintf("%s\\%s", $this->songsFolder, $this->file_name);
    }
    // returns the full path where this file is stored
    public function getWaveImageFilePath()
    {	
    	$w = preg_split('/\./', $this->file_name);
    	return sprintf("%s\\%s", $this->waveImagesFolder, $this->waveImageFileName);
    }


    /*** get File names ***/
    // returns the waveform image filename
    public function getWaveImageFileName()
    {	
    	// $w = preg_split('/\./', $this->file_name);
    	return preg_replace('/\..*$/', ".png", $this->file_name);
    	// return sprintf("%s.%s", $w[0], "png");
    }

	
    /*** get URLs ***/
    // The url to the data
	public function getDataUrl() {
		if(!$this->_dataUrl) { $this->_dataUrl = sprintf("%s/static", str_replace('/protected', '', Yii::app()->baseUrl)); }
		return $this->_dataUrl;
	}
	// The url to the songs
	public function getSongsUrl() {
		if(!$this->_songsUrl) { $this->_songsUrl = sprintf("%s/songs", $this->dataUrl); }
		return $this->_songsUrl;
	}
	// returns the full path where this file is stored
    public function getSongUrl()
    {
    	return sprintf("%s/%s", $this->songsUrl, $this->file_name);
    }
    // The url to the waveimagefile
	public function getWaveImagesUrl() {
		if(!$this->_waveImagesUrl) { $this->_waveImagesUrl = sprintf("%s/wave_images", $this->dataUrl); }
		return $this->_waveImagesUrl;
	}
	// returns the full path where this file is stored
    public function getWaveImageUrl()
    {
    	return sprintf("%s/%s", $this->waveImagesUrl, $this->waveImageFileName);
    }

	

	// create directory if it doesn't exist
	private function createdir($path) {
		if(!is_dir($path)) {
			return mkdir($path);
		}
	}

}