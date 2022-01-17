<?php

/**
 * This is the model class for table "{{registration_service_management}}".
 *
 * The followings are the available columns in table '{{registration_service_management}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property integer $service_type_id
 * @property string $start
 * @property string $end
 * @property string $pause
 * @property string $resume
 * @property integer $pause_time
 * @property integer $total_time
 * @property string $note
 * @property string $status
 * @property integer $start_mechanic_id
 * @property integer $finish_mechanic_id
 * @property integer $pause_mechanic_id
 * @property integer $resume_mechanic_id
 * @property integer $assign_mechanic_id
 * @property integer $supervisor_id
 * @property integer $is_passed
 * @property string $hour
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property ServiceType $serviceType
 * @property Employee $startMechanic
 * @property Employee $finishMechanic
 * @property Employee $pauseMechanic
 * @property Employee $resumeMechanic
 * @property Employee $assignMechanic
 * @property Employee $supervisor
 */
class RegistrationServiceManagement extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{registration_service_management}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('registration_transaction_id, service_type_id', 'required'),
            array('registration_transaction_id, service_type_id, pause_time, total_time, start_mechanic_id, finish_mechanic_id, pause_mechanic_id, resume_mechanic_id, assign_mechanic_id, supervisor_id, is_passed', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 45),
            array('hour', 'length', 'max' => 10),
            array('start, end, pause, resume', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, registration_transaction_id, service_type_id, start, end, pause, resume, pause_time, total_time, note, status, start_mechanic_id, finish_mechanic_id, pause_mechanic_id, resume_mechanic_id, assign_mechanic_id, supervisor_id, hour, is_passed', 'safe', 'on' => 'search'),
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
            'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'service_type_id'),
            'startMechanic' => array(self::BELONGS_TO, 'Employee', 'start_mechanic_id'),
            'finishMechanic' => array(self::BELONGS_TO, 'Employee', 'finish_mechanic_id'),
            'pauseMechanic' => array(self::BELONGS_TO, 'Employee', 'pause_mechanic_id'),
            'resumeMechanic' => array(self::BELONGS_TO, 'Employee', 'resume_mechanic_id'),
            'assignMechanic' => array(self::BELONGS_TO, 'Employee', 'assign_mechanic_id'),
            'supervisor' => array(self::BELONGS_TO, 'Employee', 'supervisor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'registration_transaction_id' => 'Registration Transaction',
            'service_type_id' => 'Service Type',
            'start' => 'Start',
            'end' => 'End',
            'pause' => 'Pause',
            'resume' => 'Resume',
            'pause_time' => 'Pause Time',
            'total_time' => 'Total Time',
            'note' => 'Note',
            'status' => 'Status',
            'start_mechanic_id' => 'Start Mechanic',
            'finish_mechanic_id' => 'Finish Mechanic',
            'pause_mechanic_id' => 'Pause Mechanic',
            'resume_mechanic_id' => 'Resume Mechanic',
            'assign_mechanic_id' => 'Assign Mechanic',
            'supervisor_id' => 'Supervisor',
            'is_passed' => 'Pass/Fail',
            'hour' => 'Hour',
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('service_type_id', $this->service_type_id);
        $criteria->compare('start', $this->start, true);
        $criteria->compare('end', $this->end, true);
        $criteria->compare('pause', $this->pause, true);
        $criteria->compare('resume', $this->resume, true);
        $criteria->compare('pause_time', $this->pause_time);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('start_mechanic_id', $this->start_mechanic_id);
        $criteria->compare('finish_mechanic_id', $this->finish_mechanic_id);
        $criteria->compare('pause_mechanic_id', $this->pause_mechanic_id);
        $criteria->compare('resume_mechanic_id', $this->resume_mechanic_id);
        $criteria->compare('assign_mechanic_id', $this->assign_mechanic_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('hour', $this->hour, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegistrationServiceManagement the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getRegistrationServiceManagementQueue() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Queue' AND rt.service_status = 'Queue' AND rsm.assign_mechanic_id IS NULL";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementAssigned() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Queue' AND rt.service_status = 'Queue' AND rsm.assign_mechanic_id IS NOT NULL";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementProgress() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Start Service' AND rsm.start_mechanic_id IS NOT NULL AND rsm.start IS NOT NULL";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementControl() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Ready to QC' AND rsm.finish_mechanic_id IS NOT NULL AND rsm.end IS NOT NULL AND rsm.is_passed = 0";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementFinished() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Finished' AND rsm.finish_mechanic_id IS NOT NULL AND rsm.end IS NOT NULL AND rsm.is_passed = 1";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }
    
    public function getRegistrationServiceManagementMechanicAssignment() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Queue' AND rt.service_status = 'Queue' AND rsm.assign_mechanic_id = " . Yii::app()->user->id;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementMechanicProgress() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Start Service' AND rsm.start IS NOT NULL AND rsm.start_mechanic_id = " . Yii::app()->user->id;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementMechanicControl() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Ready to QC' AND rsm.end IS NOT NULL AND rsm.is_passed = 0 AND rsm.finish_mechanic_id = " . Yii::app()->user->id;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }

    public function getRegistrationServiceManagementMechanicFinished() {
        $sql = "SELECT rsm.id AS service_management_id, rt.id AS registration_transaction_id, rsm.service_type_id, v.plate_number, vcm.name AS car_make, vmod.name AS car_model, rt.work_order_number, rt.work_order_date, rt.transaction_date, rt.status, b.code AS branch, rt.priority_level
                FROM " . RegistrationServiceManagement::model()->tableName() . " rsm
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " rt ON rt.id = rsm.registration_transaction_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = rt.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = rt.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " vcm ON vcm.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " vmod ON vmod.id = v.car_model_id
                WHERE rt.work_order_number IS NOT NULL AND rt.repair_type = 'GR' AND rsm.status = 'Finished' AND rsm.end IS NOT NULL AND rsm.is_passed = 1 AND rsm.finish_mechanic_id = " . Yii::app()->user->id;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);

        return $resultSet;
    }
}
