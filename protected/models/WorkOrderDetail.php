<?php

/**
 * This is the model class for table "{{work_order_detail}}".
 *
 * The followings are the available columns in table '{{work_order_detail}}':
 * @property integer $id
 * @property integer $work_order_id
 * @property integer $service_id
 * @property string $start
 * @property string $end
 * @property integer $employee_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property WorkOrder $workOrder
 * @property Service $service
 * @property Employee $employee
 */
class WorkOrderDetail extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WorkOrderDetail the static model class
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
		return '{{work_order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('work_order_id, service_id', 'required'),
			array('work_order_id, service_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>30),
			array('start, end', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, work_order_id, service_id, start, end, employee_id, status', 'safe', 'on'=>'search'),
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
			'workOrder' => array(self::BELONGS_TO, 'WorkOrder', 'work_order_id'),
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
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
			'work_order_id' => 'Work Order',
			'service_id' => 'Service',
			'start' => 'Start',
			'end' => 'End',
			'employee_id' => 'Employee',
			'status' => 'Status',
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
		$criteria->compare('work_order_id',$this->work_order_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('start',$this->start,true);
		$criteria->compare('end',$this->end,true);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}