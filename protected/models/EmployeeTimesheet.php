<?php

/**
 * This is the model class for table "{{employee_timesheet}}".
 *
 * The followings are the available columns in table '{{employee_timesheet}}':
 * @property integer $id
 * @property string $date
 * @property string $clock_in
 * @property string $clock_out
 * @property integer $employee_id
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class EmployeeTimesheet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeeTimesheet the static model class
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
		return '{{employee_timesheet}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, clock_in, employee_id', 'required'),
			array('employee_id', 'numerical', 'integerOnly'=>true),
			array('clock_out', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date, clock_in, clock_out, employee_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'clock_in' => 'Clock In',
			'clock_out' => 'Clock Out',
			'employee_id' => 'Employee',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('clock_in',$this->clock_in,true);
		$criteria->compare('clock_out',$this->clock_out,true);
		$criteria->compare('employee_id',$this->employee_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}