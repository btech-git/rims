<?php

/**
 * This is the model class for table "{{employee_absence}}".
 *
 * The followings are the available columns in table '{{employee_absence}}':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $month
 * @property integer $total_attendance
 * @property integer $absent
 * @property string $bonus
 * @property double $overtime
 *
 * The followings are the available model relations:
 * @property Employee $employee
 */
class EmployeeAbsence extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{employee_absence}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee_id, month, total_attendance, absent, bonus, overtime', 'required'),
			array('employee_id, month, total_attendance, absent', 'numerical', 'integerOnly'=>true),
			array('overtime', 'numerical'),
			array('bonus', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employee_id, month, total_attendance, absent, bonus, overtime', 'safe', 'on'=>'search'),
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
			'employee_id' => 'Employee',
			'month' => 'Month',
			'total_attendance' => 'Total Attendance',
			'absent' => 'Absent',
			'bonus' => 'Bonus',
			'overtime' => 'Overtime',
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
		$criteria->compare('month',$this->month);
		$criteria->compare('total_attendance',$this->total_attendance);
		$criteria->compare('absent',$this->absent);
		$criteria->compare('bonus',$this->bonus,true);
		$criteria->compare('overtime',$this->overtime);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EmployeeAbsence the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
