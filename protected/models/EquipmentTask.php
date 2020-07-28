<?php

/**
 * This is the model class for table "{{equipment_task}}".
 *
 * The followings are the available columns in table '{{equipment_task}}':
 * @property integer $id
 * @property integer $equipment_id
 * @property string $task
 * @property string $description
 * @property string $check_period
 * @property string $status
 *
 * The followings are the available model relations:
 * @property EquipmentMaintenance[] $equipmentMaintenances
 * @property EquipmentMaintenances[] $equipmentMaintenances1
 * @property Equipments $equipment
 */
class EquipmentTask extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment_task}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipment_id, task, description, check_period', 'required'),
			array('equipment_id', 'numerical', 'integerOnly'=>true),
			array('task', 'length', 'max'=>100),
			array('check_period, status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, equipment_id, task, description, check_period, status', 'safe', 'on'=>'search'),
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
			'equipmentMaintenances' => array(self::HAS_MANY, 'EquipmentMaintenance', 'equipment_task_id'),
			'equipmentMaintenances1' => array(self::HAS_MANY, 'EquipmentMaintenances', 'equipment_task_id'),
			'equipment' => array(self::BELONGS_TO, 'Equipments', 'equipment_id'),
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
			'task' => 'Task',
			'description' => 'Description',
			'check_period' => 'Check Period',
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
		$criteria->compare('task',$this->task,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('check_period',$this->check_period,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EquipmentTask the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
