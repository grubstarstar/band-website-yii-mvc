<?php

/**
 * This is the model class for table "song".
 *
 * The followings are the available columns in table 'song':
 * @property string $id
 * @property string $title
 * @property string $art_url
 * @property integer $bpm
 * @property string $file_name
 * @property string $waveform_image
 */
class Song extends CActiveRecord
{
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
			array('file_name', 'required'),
			array('bpm', 'numerical', 'integerOnly'=>true),
			array('title, art_url, waveform_image', 'length', 'max'=>100),
			array('file_name', 'length', 'max'=>128),
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
			'file_name' => 'File Name',
			'waveform_image' => 'Waveform Url',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('art_url',$this->art_url,true);
		$criteria->compare('bpm',$this->bpm);
		$criteria->compare('file_name',$this->file_name,true);
		$criteria->compare('waveform_image',$this->waveform_image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}