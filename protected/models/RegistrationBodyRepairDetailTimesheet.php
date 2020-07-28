<?php

/**
 * This is the model class for table "{{registration_body_repair_detail_timesheet}}".
 *
 * The followings are the available columns in table '{{registration_body_repair_detail_timesheet}}':
 * @property integer $id
 * @property string $start_date_time
 * @property string $finish_date_time
 * @property integer $total_time
 * @property integer $registration_body_repair_detail_id
 *
 * The followings are the available model relations:
 * @property RegistrationBodyRepairDetail $registrationBodyRepairDetail
 */
class RegistrationBodyRepairDetailTimesheet extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationBodyRepairDetailTimesheet the static model class
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
		return '{{registration_body_repair_detail_timesheet}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date_time, registration_body_repair_detail_id', 'required'),
			array('total_time, registration_body_repair_detail_id', 'numerical', 'integerOnly'=>true),
			array('finish_date_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, start_date_time, finish_date_time, total_time, registration_body_repair_detail_id', 'safe', 'on'=>'search'),
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
			'registrationBodyRepairDetail' => array(self::BELONGS_TO, 'RegistrationBodyRepairDetail', 'registration_body_repair_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'start_date_time' => 'Start Date Time',
			'finish_date_time' => 'Finish Date Time',
			'total_time' => 'Total Time',
			'registration_body_repair_detail_id' => 'Registration Body Repair Detail',
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
		$criteria->compare('start_date_time',$this->start_date_time,true);
		$criteria->compare('finish_date_time',$this->finish_date_time,true);
		$criteria->compare('total_time',$this->total_time);
		$criteria->compare('registration_body_repair_detail_id',$this->registration_body_repair_detail_id);

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
}