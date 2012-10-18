<?php

/**
 * This is the model class for table "chat".
 *
 * The followings are the available columns in table 'chat':
 * @property integer $id
 * @property integer $bot_id
 * @property string $message
 * @property string $type
 * @property string $from
 * @property integer $sended
 *
 * The followings are the available model relations:
 * @property Bot $bot
 */
class Chat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Chat the static model class
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
		return 'chat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bot_id, sended', 'required'),
			array('bot_id, sended', 'numerical', 'integerOnly'=>true),
			array('type, from', 'length', 'max'=>45),
			array('message', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bot_id, message, type, from, sended', 'safe', 'on'=>'search'),
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
			'bot_id' => 'Bot',
			'message' => 'Message',
			'type' => 'Type',
			'from' => 'From',
			'sended' => 'Sended',
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
		$criteria->compare('bot_id',$this->bot_id);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('sended',$this->sended);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}