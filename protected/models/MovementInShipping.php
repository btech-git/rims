<?php

/**
 * This is the model class for table "{{movement_in_shipping}}".
 *
 * The followings are the available columns in table '{{movement_in_shipping}}':
 * @property integer $id
 * @property integer $movement_in_id
 * @property string $status
 * @property string $date
 * @property integer $supervisor_id
 *
 * The followings are the available model relations:
 * @property MovementInHeader $movementIn
 */
class MovementInShipping extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MovementInShipping the static model class
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
		return '{{movement_in_shipping}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movement_in_id, status, date, supervisor_id', 'required'),
			array('movement_in_id, supervisor_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, movement_in_id, status, date, supervisor_id', 'safe', 'on'=>'search'),
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
			'movementIn' => array(self::BELONGS_TO, 'MovementInHeader', 'movement_in_id'),
			'supervisor' => array(self::BELONGS_TO, 'Users', 'supervisor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'movement_in_id' => 'Movement In',
			'status' => 'Status',
			'date' => 'Date',
			'supervisor_id' => 'Supervisor',
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
		$criteria->compare('movement_in_id',$this->movement_in_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('supervisor_id',$this->supervisor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}