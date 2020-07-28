<?php

/**
 * This is the model class for table "{{equipment_maintenances}}".
 *
 * The followings are the available columns in table '{{equipment_maintenances}}':
 * @property integer $id
 * @property integer $equipment_id
 * @property integer $equipment_task_id
 * @property integer $equipment_detail_id
 * @property integer $employee_id
 * @property string $maintenance_date
 * @property string $next_maintenance_date
 * @property string $check_date
 * @property string $checked
 * @property string $notes
 * @property string $equipment_condition
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Equipments $equipment
 * @property EquipmentTask $equipmentTask
 * @property EquipmentDetails $equipmentDetail
 */
class EquipmentMaintenances extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment_maintenances}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('equipment_id, equipment_task_id, equipment_detail_id, employee_id, maintenance_date, next_maintenance_date, check_date, notes', 'required'),
			array('equipment_id, equipment_task_id, equipment_detail_id', 'numerical', 'integerOnly'=>true),
			array('checked', 'length', 'max'=>20),
			array('equipment_condition', 'length', 'max'=>11),
			array('status', 'length', 'max'=>8),
			array('maintenance_date', 'safe'),
			array('next_maintenance_date', 'safe'),
			array('check_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, equipment_id, equipment_task_id, equipment_detail_id, employee_id, maintenance_date, next_maintenance_date, check_date, checked, notes, equipment_condition, status', 'safe', 'on'=>'search'),
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
			//'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
			'equipment' => array(self::BELONGS_TO, 'Equipments', 'equipment_id'),
			'equipmentTask' => array(self::BELONGS_TO, 'EquipmentTask', 'equipment_task_id'),
			'equipmentDetail' => array(self::BELONGS_TO, 'EquipmentDetails', 'equipment_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'equipment_id' => 'Equipment',
			'equipment_task_id' => 'Equipment Task',
			'equipment_detail_id' => 'Equipment Detail',
			'employee_id' => 'Employee',
			'maintenance_date' => 'Maintenance Date',
			'next_maintenance_date' => 'Next Maintenance Date',
			'check_date' => 'Check Date',
			'checked' => 'Checked',
			'notes' => 'Notes',
			'equipment_condition' => 'Equipment Condition',
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
		$criteria->compare('equipment_id',$this->equipment_id);
		$criteria->compare('equipment_task_id',$this->equipment_task_id);
		$criteria->compare('equipment_detail_id',$this->equipment_detail_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('maintenance_date',$this->maintenance_date,true);
		$criteria->compare('next_maintenance_date',$this->next_maintenance_date,true);
		$criteria->compare('check_date',$this->check_date,true);
		$criteria->compare('checked',$this->checked,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('equipment_condition',$this->equipment_condition,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EquipmentMaintenances the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
