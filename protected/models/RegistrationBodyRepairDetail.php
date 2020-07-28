<?php

/**
 * This is the model class for table "{{registration_body_repair_detail}}".
 *
 * The followings are the available columns in table '{{registration_body_repair_detail}}':
 * @property integer $id
 * @property string $service_name
 * @property string $start_date_time
 * @property string $finish_date_time
 * @property integer $total_time
 * @property integer $to_be_checked
 * @property integer $is_passed
 * @property integer $registration_transaction_id
 * @property integer $mechanic_id
 * @property integer $mechanic_head_id
 * @property integer $mechanic_assigned_id
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property Employee $mechanic
 * @property Employee $mechanicHead
 * @property Employee $mechanicAssigned
 * @property RegistrationBodyRepairDetailTimesheet[] $registrationBodyRepairDetailTimesheets
 */
class RegistrationBodyRepairDetail extends CActiveRecord
{
    const QUALITY_CONTROL_FAILED = 0;
    const QUALITY_CONTROL_PASSED = 1;
    
    const QUALITY_CONTROL_FAILED_LITERAL = 'FAILED';
    const QUALITY_CONTROL_PASSED_LITERAL = 'PASSED';
    
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationBodyRepairDetail the static model class
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
		return '{{registration_body_repair_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_name', 'required'),
			array('total_time, to_be_checked, is_passed, registration_transaction_id, mechanic_id, mechanic_head_id, mechanic_assigned_id', 'numerical', 'integerOnly'=>true),
			array('service_name', 'length', 'max'=>60),
			array('start_date_time, finish_date_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_name, start_date_time, finish_date_time, total_time, to_be_checked, is_passed, registration_transaction_id, mechanic_id, mechanic_head_id, mechanic_assigned_id', 'safe', 'on'=>'search'),
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
			'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
			'mechanic' => array(self::BELONGS_TO, 'Employee', 'mechanic_id'),
			'mechanicHead' => array(self::BELONGS_TO, 'Employee', 'mechanic_head_id'),
			'mechanicAssigned' => array(self::BELONGS_TO, 'Employee', 'mechanic_assigned_id'),
			'registrationBodyRepairDetailTimesheets' => array(self::HAS_MANY, 'RegistrationBodyRepairDetailTimesheet', 'registration_body_repair_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_name' => 'Service Name',
			'start_date_time' => 'Start Date Time',
			'finish_date_time' => 'Finish Date Time',
			'total_time' => 'Total Time',
			'to_be_checked' => 'To Be Checked',
			'is_passed' => 'QC Status',
			'registration_transaction_id' => 'Registration Transaction',
			'mechanic_id' => 'Mechanic',
			'mechanic_head_id' => 'Mechanic Head',
			'mechanic_assigned_id' => 'Mechanic Assigned',
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
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('start_date_time',$this->start_date_time,true);
		$criteria->compare('finish_date_time',$this->finish_date_time,true);
		$criteria->compare('total_time',$this->total_time);
		$criteria->compare('to_be_checked',$this->to_be_checked);
		$criteria->compare('is_passed',$this->is_passed);
		$criteria->compare('registration_transaction_id',$this->registration_transaction_id);
		$criteria->compare('mechanic_id',$this->mechanic_id);
		$criteria->compare('mechanic_head_id',$this->mechanic_head_id);
		$criteria->compare('mechanic_assigned_id',$this->mechanic_assigned_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getTotalTimeFormatted() {
        $time = $this->total_time;
        $daysCount = intval($time / (24 * 60 * 60));
        $time = $time % (24 * 60 * 60);
        $hoursCount = intval($time / (60 * 60));
        $time = $time % (60 * 60);
        $minutesCount = intval($time / 60);
        $time = $time % 60;
        $secondsCount = $time;
        
        $str = '';
        if ($daysCount > 0) {
            $str .= $daysCount . 'd ';
        }
        if ($hoursCount > 0) {
            $str .= $hoursCount . 'h ';
        }
        if ($minutesCount > 0) {
            $str .= $minutesCount . 'm ';
        }
        if ($secondsCount > 0) {
            $str .= $secondsCount . 's';
        }
        return $str;
    }
    
    public function getQualityControlStatus() {
        return ($this->is_passed == self::QUALITY_CONTROL_FAILED) ? self::QUALITY_CONTROL_FAILED_LITERAL : self::QUALITY_CONTROL_PASSED_LITERAL;
    }
    
    public function getLevelIdByProcessName($processName)
    {
        $levelId = '';
        
        if ($processName == 'Bongkar Pasang') {
            $levelId = 8;
        } else if ($processName == 'Las Ketok') {
            $levelId = 9;
        } else if ($processName == 'Dempul') {
            $levelId = 10;
        } else if ($processName == 'Epoxy') {
            $levelId = 11;
        } else if ($processName == 'Cat') {
            $levelId = 12;
        } else if ($processName == 'Finishing') {
            $levelId = 13;
        } else if ($processName == 'Cuci') {
            $levelId = 14;
        } else if ($processName == 'Poles') {
            $levelId = 15;
        }
        
        return $levelId;
    }
}