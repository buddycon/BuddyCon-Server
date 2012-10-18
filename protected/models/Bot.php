<?php

/**
 * This is the model class for table "bot".
 *
 * The followings are the available columns in table 'bot':
 * @property integer $id
 * @property integer $user_id
 * @property integer $level
 * @property integer $gold
 * @property integer $xp
 * @property integer $xp_needed
 * @property string $name
 * @property integer $latestupdate
 * @property integer $wantscreen
 * @property string $do
 * @property string $nodes
 * @property string $running
 * @property string $filter
 * @property integer $lastvisit
 * @property integer $xph
 * @property integer $timetolevel
 * @property integer $kills
 * @property integer $killsh
 * @property integer $honor
 * @property integer $honorh
 * @property integer $death
 * @property integer $deathh
 * @property integer $bgwin
 * @property integer $bglost
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Chat[] $chats
 * @property Reply[] $replies
 * @property Screen[] $screens
 * @property Status[] $statuses
 */
class Bot extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bot the static model class
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
		return 'bot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, wantscreen', 'required'),
			array('user_id, level, gold, xp, xp_needed, latestupdate, wantscreen, lastvisit', 'numerical', 'integerOnly'=>true),
			array('name, do', 'length', 'max'=>45),
			array('running', 'length', 'max'=>60),
			array('nodes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, level, gold, xp, xp_needed, name, latestupdate, wantscreen, do, nodes, running, lastvisit', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'chats' => array(self::HAS_MANY, 'Chat', 'bot_id'),
			'replies' => array(self::HAS_MANY, 'Reply', 'bot_id'),
			'screens' => array(self::HAS_MANY, 'Screen', 'bot_id'),
			'statuses' => array(self::HAS_MANY, 'Status', 'bot_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'level' => 'Level',
			'gold' => 'Gold',
			'xp' => 'Xp',
			'xp_needed' => 'Xp Needed',
			'name' => 'Name',
			'latestupdate' => 'Latestupdate',
			'wantscreen' => 'Wantscreen',
			'do' => 'Do',
			'nodes' => 'Nodes',
			'running' => 'Running',
			'lastvisit' => 'Lastvisit',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('level',$this->level);
		$criteria->compare('gold',$this->gold);
		$criteria->compare('xp',$this->xp);
		$criteria->compare('xp_needed',$this->xp_needed);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('latestupdate',$this->latestupdate);
		$criteria->compare('wantscreen',$this->wantscreen);
		$criteria->compare('do',$this->do,true);
		$criteria->compare('nodes',$this->nodes,true);
		$criteria->compare('running',$this->running,true);
		$criteria->compare('lastvisit',$this->lastvisit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}