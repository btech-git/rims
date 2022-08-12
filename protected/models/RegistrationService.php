<?php

/**
 * This is the model class for table "{{registration_service}}".
 *
 * The followings are the available columns in table '{{registration_service}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property integer $service_id
 * @property string $claim
 * @property string $price
 * @property string $total_price
 * @property string $discount_price
 * @property string $discount_type
 * @property integer $is_quick_service
 * @property string $start
 * @property string $end
 * @property string $pause
 * @property string $resume
 * @property integer $pause_time
 * @property integer $total_time
 * @property string $note
 * @property integer $is_body_repair
 * @property integer $is_paused
 * @property string $status
 * @property integer $assign_mechanic_id
 * @property integer $start_mechanic_id
 * @property integer $finish_mechanic_id
 * @property integer $pause_mechanic_id
 * @property integer $resume_mechanic_id
 * @property integer $supervisor_id
 * @property integer $service_type_id
 * @property string $hour
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property Service $service
 * @property ServiceType $serviceType
 * @property Employee $employee
 * @property StartMechanic $startMechanic
 * @property FinishMechanic $finishMechanic
 * @property Employee $supervisor
 * @property RegistrationServiceEmployee[] $registrationServiceEmployees
 * @property RegistrationServiceSupervisor[] $registrationServiceSupervisors
 */
class RegistrationService extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $service_name;
    public $hour;
    public $total;
    public $listemployee;
    public $platnumber;
    public $service_activity;

    public function tableName() {
        return '{{registration_service}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('note', 'required'),
            array('registration_transaction_id, service_id, is_quick_service, is_body_repair, start_mechanic_id, finish_mechanic_id, pause_mechanic_id, resume_mechanic_id, assign_mechanic_id, supervisor_id, pause_time, total_time, service_type_id, is_paused', 'numerical', 'integerOnly' => true),
            array('claim, price,hour', 'length', 'max' => 10),
            array('total_price, discount_price', 'length', 'max' => 18),
            array('discount_type', 'length', 'max' => 50),
            array('status', 'length', 'max' => 30),
            array('start, end, pause, resume, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, registration_transaction_id, service_id, claim, price, total_price, discount_price, discount_type, is_quick_service, start, end, pause, resume, pause_time, total_time, note, is_body_repair, status, start_mechanic_id, finish_mechanic_id, pause_mechanic_id, resume_mechanic_id, assign_mechanic_id, supervisor_id, service_name, listemployee, platnumber,hour, service_activity, service_type_id, is_paused', 'safe', 'on' => 'search'),
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
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
            'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'service_type_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'startMechanic' => array(self::BELONGS_TO, 'Employee', 'start_mechanic_id'),
            'finishMechanic' => array(self::BELONGS_TO, 'Employee', 'finish_mechanic_id'),
            'assignMechanic' => array(self::BELONGS_TO, 'Employee', 'assign_mechanic_id'),
            'supervisor' => array(self::BELONGS_TO, 'Employee', 'supervisor_id'),
            'registrationServiceEmployees' => array(self::HAS_MANY, 'RegistrationServiceEmployee', 'registration_service_id'),
            'registrationServiceSupervisors' => array(self::HAS_MANY, 'RegistrationServiceSupervisor', 'registration_service_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'registration_transaction_id' => 'Registration Transaction',
            'service_id' => 'Service',
            'service_type_id' => 'Service Type',
            'claim' => 'Claim',
            'price' => 'Price',
            'total_price' => 'Total Price',
            'discount_price' => 'Discount Price',
            'discount_type' => 'Discount Type',
            'is_quick_service' => 'Is Quick Service',
            'start' => 'Start',
            'end' => 'End',
            'pause' => 'Pause',
            'resume' => 'Resume',
            'pause_time' => 'Pause Time',
            'total_time' => 'Total Time',
            'note' => 'Note',
            'is_body_repair' => 'Is Body Repair',
            'status' => 'Status',
            'assign_mechanic_id' => 'Assign Mechanic',
            'start_mechanic_id' => 'Start Mechanic',
            'finish_mechanic_id' => 'Finish Mechanic',
            'pause_mechanic_id' => 'Pause Mechanic',
            'resume_mechanic_id' => 'Resume Mechanic',
            'supervisor_id' => 'Supervisor',
            'hour' => 'Hour',
            'is_paused' => 'Paused',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('service_type_id', $this->service_type_id);
        $criteria->compare('claim', $this->claim, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('discount_price', $this->discount_price, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time, true);
        $criteria->compare('total_time', $this->total_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_body_repair', $this->is_body_repair);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('hour', $this->hour, true);
        $criteria->compare('is_paused', $this->is_paused, true);

        $criteria->together = 'true';
        $criteria->with = array('service', 'registrationTransaction' => array('with' => array('vehicle')));
        $criteria->compare('service.name', $this->service_name, true);
        $criteria->compare('vehicle.plate_number', $this->platnumber, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /* public function getTotalTime($serviceId,$registrationId)
      {
      $c = new CDbCriteria;
      $c->select = array(
      'SEC_TO_TIME(TIME_TO_SEC(`end`)-TIME_TO_SEC(`start`)) as totaltime'
      );
      $c->condition = 'registration_transaction_id = '.$registrationId . ' and service_id = ' . $serviceId;
      $t = RegistrationService::model()->find($c);
      return $t["totaltime"];
      } */

    public function getTotal($registrationId) {
        $c = new CDbCriteria;
        $c->select = array(
            'SEC_TO_TIME(SUM(TIME_TO_SEC(`total_time`))) as total'
        );
        $c->condition = 'registration_transaction_id = ' . $registrationId;
        $t = RegistrationService::model()->find($c);
        return $t["total"];
    }

    public function getEmployee() {

        $em = array();

        foreach ($this->registrationServiceEmployees as $employee) {
            $em[] = $employee->employee->name . '<br>';
        }

        return $this->listemployee = implode('', $em);
    }

    public function getDiscountAmount() {
        $discountPrice = 0;

        if (!empty($this->discount_type)) {
            $discountPrice = ($this->discount_type == 'Nominal') ? $this->discount_price : $this->price * $this->discount_price / 100;
        }

        return $discountPrice;
    }

    public function getTotalAmount() {

        $priceAfterDiscount = $this->price - $this->discountAmount;
        $taxNominal = 0;

        return $priceAfterDiscount + $taxNominal;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegistrationService the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getStartMechanicName() {
        $user = User::model()->findByPk($this->start_mechanic_id);

        return empty($user) ? "N/A" : $user->username;
    }

    public function searchByGeneralRepairIdleManagement() {
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
            'service',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('claim', $this->claim, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('discount_price', $this->discount_price, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time, true);
        $criteria->compare('total_time', $this->total_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_body_repair', $this->is_body_repair);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('hour', $this->hour, true);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'GR' AND t.status = 'Pending' AND registrationTransaction.status = 'Processing WO'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.id ASC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
   
    public function searchByPlanning() {
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
            'service',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('claim', $this->claim, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('discount_price', $this->discount_price, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time, true);
        $criteria->compare('total_time', $this->total_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_body_repair', $this->is_body_repair);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('hour', $this->hour, true);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'GR' AND registrationTransaction.service_status = 'Pending' AND t.status = 'Planning' AND t.assign_mechanic_id IS NULL");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.id ASC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function searchByServiceQueue() {
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
            'service',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('claim', $this->claim, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('discount_price', $this->discount_price, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time, true);
        $criteria->compare('total_time', $this->total_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_body_repair', $this->is_body_repair);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('hour', $this->hour, true);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'GR' AND registrationTransaction.service_status = 'Pending' AND t.status = 'Planning' AND t.assign_mechanic_id IS NOT NULL");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.id ASC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function searchByProgressMechanic() {
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
            'service',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('claim', $this->claim, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('discount_price', $this->discount_price, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time, true);
        $criteria->compare('total_time', $this->total_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_body_repair', $this->is_body_repair);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('hour', $this->hour, true);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'GR' AND t.status = 'On Progress'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.id ASC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function searchByQualityControl() {
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
            'service',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('claim', $this->claim, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('discount_price', $this->discount_price, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time, true);
        $criteria->compare('total_time', $this->total_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_body_repair', $this->is_body_repair);
//        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('hour', $this->hour, true);

        $criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'GR' AND registrationTransaction.service_status = 'PrepareToCheck' AND t.status = 'Finished' AND registrationTransaction.is_passed = 0");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.id ASC';
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function getFormattedTotalTime() {
        $hours = floor($this->total_time / 3600);
        $minutes = floor($this->total_time / 60 % 60);
        $seconds = floor($this->total_time % 60);
        
        return sprintf('%dh %dm %ds', $hours, $minutes, $seconds);
    }
    
    public function getRegistrationServiceData($registrationTransactionIds, $serviceTypeIds) {
        $resultSet = Yii::app()->db->createCommand()
                ->select('d.registration_transaction_id, d.service_type_id, s.name')
                ->from('rims_registration_service d')
                ->join('rims_service s', 's.id = d.service_id')
                ->where(array('in', 'd.registration_transaction_id', $registrationTransactionIds))
                ->andWhere(array('in', 'd.service_type_id', $serviceTypeIds))
                ->queryAll();

        return $resultSet;
    }
}
