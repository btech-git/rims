<?php

/**
 * This is the model class for table "rims_employee_division_position_level".
 *
 * The followings are the available columns in table 'rims_employee_division_position_level':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $division_id
 * @property integer $position_id
 * @property integer $level_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Division $division
 * @property Position $position
 * @property Level $level
 */
class EmployeeDivisionPositionLevel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rims_employee_division_position_level';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, division_id, position_id, level_id', 'required'),
			array('employee_id, division_id, position_id, level_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employee_id, division_id, position_id, level_id, status', 'safe', 'on'=>'search'),
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
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
			'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
			'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
			'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employee_id' => 'Employee',
			'division_id' => 'Division',
			'position_id' => 'Position',
			'level_id' => 'Level',
			'status' => 'Status',
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
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('division_id',$this->division_id);
		$criteria->compare('position_id',$this->position_id);
		$criteria->compare('level_id',$this->level_id);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmployeeDivisionPositionLevel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
