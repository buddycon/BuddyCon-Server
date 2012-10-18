<?php

/**
 * This is the model class for table "screen".
 *
 * The followings are the available columns in table 'screen':
 * @property integer $id
 * @property string $link
 * @property string $delete
 * @property integer $thumb
 * @property integer $bot_id
 * @property integer $uploadedtime
 * @property integer $private
 *
 * The followings are the available model relations:
 * @property Bot $bot
 */
class Screen extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Screen the static model class
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
		return 'screen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bot_id', 'required'),
			array('bot_id, uploadedtime', 'numerical', 'integerOnly'=>true),
			array('link, delete, thumb', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, link, delete, thumb, bot_id, uploadedtime', 'safe', 'on'=>'search'),
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
			'bot' => array(self::BELONGS_TO, 'Bot', 'bot_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'link' => 'Link',
			'delete' => 'Delete',
			'thumb' => 'Thumb',
			'bot_id' => 'Bot',
			'uploadedtime' => 'Uploadedtime',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('delete',$this->delete,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('bot_id',$this->bot_id);
		$criteria->compare('uploadedtime',$this->uploadedtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}