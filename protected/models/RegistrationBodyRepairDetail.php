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
class RegistrationBodyRepairDetail extends CActiveRecord {

    const QUALITY_CONTROL_FAILED = 0;
    const QUALITY_CONTROL_PASSED = 1;
    const QUALITY_CONTROL_FAILED_LITERAL = 'FAILED';
    const QUALITY_CONTROL_PASSED_LITERAL = 'PASSED';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RegistrationBodyRepairDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{registration_body_repair_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('service_name', 'required'),
            array('total_time, to_be_checked, is_passed, registration_transaction_id, mechanic_id, mechanic_head_id, mechanic_assigned_id', 'numerical', 'integerOnly' => true),
            array('service_name', 'length', 'max' => 60),
            array('start_date_time, finish_date_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, service_name, start_date_time, finish_date_time, total_time, to_be_checked, is_passed, registration_transaction_id, mechanic_id, mechanic_head_id, mechanic_assigned_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
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
    public function attributeLabels() {
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
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

    public function getLevelIdByProcessName($processName) {
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
        } else if ($processName == 'Spare Part') {
            $levelId = 16;
        }

        return $levelId;
    }

    public function searchByQueueBongkar() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Bongkar Pasang' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Bongkar - Pending' AND registrationTransaction.status = 'Queue Bongkar Pasang'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignBongkar() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND t.service_name = 'Bongkar Pasang' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Bongkar - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressBongkar() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Bongkar Pasang' AND registrationTransaction.service_status = 'Bongkar Pasang - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlBongkar() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Bongkar Pasang' AND registrationTransaction.service_status = 'Bongkar Pasang - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedBongkar() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Bongkar Pasang' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueSparepart() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Spare Part' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Spare Part - Pending' AND registrationTransaction.status = 'Queue Spare Part'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignSparePart() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Spare Part' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Spare Part - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressSparepart() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Spare Part' AND registrationTransaction.service_status = 'Spare Part - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlSparepart() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Spare Part' AND registrationTransaction.service_status = 'Spare Part - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedSparepart() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Spare Part' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueKetok() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Las Ketok' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Las Ketok - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignKetok() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Las Ketok'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressKetok() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Las Ketok' AND registrationTransaction.service_status = 'Las Ketok - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlKetok() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Las Ketok' AND registrationTransaction.service_status = 'Las Ketok - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedKetok() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Las Ketok' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueDempul() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Dempul' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Dempul - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignDempul() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Dempul'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressDempul() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Dempul' AND registrationTransaction.service_status = 'Dempul - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlDempul() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Dempul' AND registrationTransaction.service_status = 'Dempul - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedDempul() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Dempul' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueEpoxy() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Epoxy' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Epoxy - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignEpoxy() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Epoxy'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressEpoxy() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Epoxy' AND registrationTransaction.service_status = 'Epoxy - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlEpoxy() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Epoxy' AND registrationTransaction.service_status = 'Epoxy - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedEpoxy() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Epoxy' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueCat() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Cat' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Cat - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignCat() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Cat'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressCat() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Cat' AND registrationTransaction.service_status = 'Cat - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlCat() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Cat' AND registrationTransaction.service_status = 'Cat - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedCat() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Cat' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueuePasang() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Finishing' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Finishing - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignPasang() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Finishing'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressPasang() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Finishing' AND registrationTransaction.service_status = 'Finishing - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlPasang() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Finishing' AND registrationTransaction.service_status = 'Finishing - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedPasang() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Finishing' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueCuci() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Cuci' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Cuci - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignCuci() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Cuci'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressCuci() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Cuci' AND registrationTransaction.service_status = 'Cuci - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlCuci() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Cuci' AND registrationTransaction.service_status = 'Cuci - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedCuci() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Cuci' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueuePoles() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Poles' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Poles - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAssignPoles() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NOT NULL AND t.mechanic_id IS NULL AND service_name = 'Poles'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByProgressPoles() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Poles' AND registrationTransaction.service_status = 'Poles - Started'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQualityControlPoles() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Poles' AND registrationTransaction.service_status = 'Poles - Checking' AND t.to_be_checked = 1 AND t.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByFinishedPoles() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.service_name = 'Poles' AND t.to_be_checked = 1 AND t.is_passed = 1");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByQueueMechanic() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array (
                'with' => array(
                    'branch',
                    'customer',
                    'vehicle',
                )
            ),
            'mechanic',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('service_name', $this->service_name, true);
        $criteria->compare('start_date_time', $this->start_date_time, true);
        $criteria->compare('finish_date_time', $this->finish_date_time, true);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('to_be_checked', $this->to_be_checked);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('mechanic_id', $this->mechanic_id);
        $criteria->compare('mechanic_head_id', $this->mechanic_head_id);
        $criteria->compare('mechanic_assigned_id', $this->mechanic_assigned_id);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'BR' AND t.mechanic_assigned_id IS NULL AND t.mechanic_id IS NULL AND t.service_name = 'Cat' AND t.is_passed = 0 AND registrationTransaction.service_status = 'Cat - Pending'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.transaction_date DESC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
}
