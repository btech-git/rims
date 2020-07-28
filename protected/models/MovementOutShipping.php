<?php

/**
 * This is the model class for table "{{movement_out_shipping}}".
 *
 * The followings are the available columns in table '{{movement_out_shipping}}':
 * @property integer $id
 * @property integer $movement_out_id
 * @property integer $movement_out_detail_id
 * @property string $status
 * @property string $date
 * @property integer $supervisor_id
 *
 * The followings are the available model relations:
 * @property MovementOutHeader $movementOut
 * @property MovementOutDetail $movementOutDetail
 */
class MovementOutShipping extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{movement_out_shipping}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('movement_out_id, status, date, supervisor_id', 'required'),
			array('movement_out_id, movement_out_detail_id, supervisor_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, movement_out_id, movement_out_detail_id, status, date, supervisor_id', 'safe', 'on'=>'search'),
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
			'movementOut' => array(self::BELONGS_TO, 'MovementOutHeader', 'movement_out_id'),
			'movementOutDetail' => array(self::BELONGS_TO, 'MovementOutDetail', 'movement_out_detail_id'),
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
			'movement_out_id' => 'Movement Out',
			'movement_out_detail_id' => 'Movement Out Detail',
			'status' => 'Status',
			'date' => 'Date',
			'supervisor_id' => 'Supervisor',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('movement_out_id',$this->movement_out_id);
		$criteria->compare('movement_out_detail_id',$this->movement_out_detail_id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('supervisor_id',$this->supervisor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MovementOutShipping the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
