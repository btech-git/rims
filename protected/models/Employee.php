<?php

/**
 * This is the model class for table "{{employee}}".
 *
 * The followings are the available columns in table '{{employee}}':
 * @property integer $id
 * @property string $name
 * @property string $recruitment_date
 * @property string $local_address
 * @property string $home_address
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $home_province
 * @property integer $home_city
 * @property string $sex
 * @property string $email
 * @property string $id_card
 * @property string $driving_license
 * @property integer $branch_id
 * @property string $status
 * @property string $salary_type
 * @property string $basic_salary
 * @property string $payment_type
 * @property string $code
 * @property string $availability
 * @property string $skills
 * @property integer $registration_service_id
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property string $off_day
 * @property string $mobile_phone_number
 * @property string $marriage_status
 * @property integer $children_quantity
 * @property string $emergency_contact_relationship
 * @property integer $division_id
 * @property integer $position_id
 * @property integer $level_id
 * @property integer $employee_head_id
 * @property string $mother_name
 * @property string $bank_name
 * @property string $birth_place
 * @property string $emergency_contact_name
 * @property string $religion
 * @property string $family_card_number
 * @property string $bank_account_number
 * @property string $tax_registration_number
 * @property string $school_degree
 * @property string $school_subject
 * @property string $employment_type
 * @property string $emergency_contact_mobile_phone
 * @property string $birth_date
 * @property string $emergency_contact_address
 * @property integer $onleave_allocation
 * @property integer $user_id
 * @property string $clock_in_time
 * @property string $clock_out_time
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property integer $user_id_updated
 *
 * The followings are the available model relations:
 * @property Province $province
 * @property Users $user
 * @property City $city
 * @property Province $homeProvince
 * @property City $homeCity
 * @property Branch $branch
 * @property Division $division
 * @property Position $position
 * @property Level $level
 * @property Employee $employeeHead
 * @property Employee[] $employees
 * @property EmployeeAbsence[] $employeeAbsences
 * @property EmployeeAttendance[] $employeeAttendances
 * @property EmployeeBank[] $employeeBanks
 * @property EmployeeBranchDivisionPositionLevel[] $employeeBranchDivisionPositionLevels
 * @property EmployeeDayoff[] $employeeDayoffs
 * @property EmployeeDeductions[] $employeeDeductions
 * @property EmployeeIncentives[] $employeeIncentives
 * @property EmployeeMobile[] $employeeMobiles
 * @property EmployeePhone[] $employeePhones
 * @property EmployeeSchedule[] $employeeSchedules
 * @property EmployeeTimesheet[] $employeeTimesheets
 * @property EquipmentMaintenance[] $equipmentMaintenances
 * @property EquipmentMaintenances[] $equipmentMaintenances1
 * @property RegistrationBodyRepairDetail[] $registrationBodyRepairDetails
 * @property RegistrationBodyRepairDetail[] $registrationBodyRepairDetails1
 * @property RegistrationBodyRepairDetail[] $registrationBodyRepairDetails2
 * @property RegistrationService[] $registrationServices
 * @property RegistrationServiceEmployee[] $registrationServiceEmployees
 * @property RegistrationServiceManagement[] $registrationServiceManagements
 * @property RegistrationServiceManagement[] $registrationServiceManagements1
 * @property RegistrationServiceManagement[] $registrationServiceManagements2
 * @property RegistrationServiceManagement[] $registrationServiceManagements3
 * @property RegistrationServiceManagement[] $registrationServiceManagements4
 * @property RegistrationServiceManagement[] $registrationServiceManagements5
 * @property RegistrationServiceSupervisor[] $registrationServiceSupervisors
 * @property RegistrationTransaction[] $registrationTransactions
 * @property RegistrationTransaction[] $registrationTransactions1
 * @property RegistrationTransaction[] $registrationTransactions2
 * @property RegistrationTransaction[] $registrationTransactions3
 * @property RegistrationTransaction[] $registrationTransactions4
 * @property SaleEstimationHeader[] $saleEstimationHeaders
 */
class Employee extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, recruitment_date, sex, branch_id, user_id, clock_in_time, clock_out_time', 'required'),
            array('province_id, city_id, home_province, home_city, branch_id, registration_service_id, is_deleted, deleted_by, children_quantity, division_id, position_id, level_id, employee_head_id, onleave_allocation, user_id, user_id_updated', 'numerical', 'integerOnly' => true),
            array('name, mother_name, bank_name, birth_place, emergency_contact_name', 'length', 'max' => 100),
            array('sex, status, basic_salary', 'length', 'max' => 10),
            array('email, mobile_phone_number, marriage_status, emergency_contact_relationship', 'length', 'max' => 60),
            array('id_card, driving_license, off_day, religion, family_card_number, bank_account_number, tax_registration_number', 'length', 'max' => 30),
            array('salary_type, payment_type, code, school_degree, school_subject, employment_type, emergency_contact_mobile_phone', 'length', 'max' => 50),
            array('availability', 'length', 'max' => 5),
            array('local_address, home_address, skills, deleted_at, birth_date, emergency_contact_address, created_datetime, updated_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, recruitment_date, local_address, home_address, province_id, city_id, home_province, home_city, sex, email, id_card, driving_license, branch_id, status, salary_type, basic_salary, payment_type, code, availability, skills, registration_service_id, is_deleted, deleted_at, deleted_by, off_day, mobile_phone_number, marriage_status, children_quantity, emergency_contact_relationship, division_id, position_id, level_id, employee_head_id, mother_name, bank_name, birth_place, emergency_contact_name, religion, family_card_number, bank_account_number, tax_registration_number, school_degree, school_subject, employment_type, emergency_contact_mobile_phone, birth_date, emergency_contact_address, onleave_allocation, user_id, clock_in_time, clock_out_time, created_datetime, updated_datetime, user_id_updated', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'homeProvince' => array(self::BELONGS_TO, 'Province', 'home_province'),
            'homeCity' => array(self::BELONGS_TO, 'City', 'home_city'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
            'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
            'employeeHead' => array(self::BELONGS_TO, 'Employee', 'employee_head_id'),
            'employees' => array(self::HAS_MANY, 'Employee', 'employee_head_id'),
            'employeeAbsences' => array(self::HAS_MANY, 'EmployeeAbsence', 'employee_id'),
            'employeeAttendances' => array(self::HAS_MANY, 'EmployeeAttendance', 'employee_id'),
            'employeeBanks' => array(self::HAS_MANY, 'EmployeeBank', 'employee_id'),
            'employeeBranchDivisionPositionLevels' => array(self::HAS_MANY, 'EmployeeBranchDivisionPositionLevel', 'employee_id'),
            'employeeDayoffs' => array(self::HAS_MANY, 'EmployeeDayoff', 'employee_id'),
            'employeeDeductions' => array(self::HAS_MANY, 'EmployeeDeductions', 'employee_id'),
            'employeeIncentives' => array(self::HAS_MANY, 'EmployeeIncentives', 'employee_id'),
            'employeeMobiles' => array(self::HAS_MANY, 'EmployeeMobile', 'employee_id'),
            'employeePhones' => array(self::HAS_MANY, 'EmployeePhone', 'employee_id'),
            'employeeSchedules' => array(self::HAS_MANY, 'EmployeeSchedule', 'employee_id'),
            'employeeTimesheets' => array(self::HAS_MANY, 'EmployeeTimesheet', 'employee_id'),
            'equipmentMaintenances' => array(self::HAS_MANY, 'EquipmentMaintenance', 'employee_id'),
            'equipmentMaintenances1' => array(self::HAS_MANY, 'EquipmentMaintenances', 'employee_id'),
            'registrationBodyRepairDetails' => array(self::HAS_MANY, 'RegistrationBodyRepairDetail', 'mechanic_id'),
            'registrationBodyRepairDetails1' => array(self::HAS_MANY, 'RegistrationBodyRepairDetail', 'mechanic_head_id'),
            'registrationBodyRepairDetails2' => array(self::HAS_MANY, 'RegistrationBodyRepairDetail', 'mechanic_assigned_id'),
            'registrationServices' => array(self::HAS_MANY, 'RegistrationService', 'supervisor_id'),
            'registrationServiceEmployees' => array(self::HAS_MANY, 'RegistrationServiceEmployee', 'employee_id'),
            'registrationServiceManagements' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'start_mechanic_id'),
            'registrationServiceManagements1' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'finish_mechanic_id'),
            'registrationServiceManagements2' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'pause_mechanic_id'),
            'registrationServiceManagements3' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'resume_mechanic_id'),
            'registrationServiceManagements4' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'assign_mechanic_id'),
            'registrationServiceManagements5' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'supervisor_id'),
            'registrationServiceSupervisors' => array(self::HAS_MANY, 'RegistrationServiceSupervisor', 'supervisor_id'),
            'registrationTransactions' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_mechanic_helper_1'),
            'registrationTransactions1' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_mechanic_helper_2'),
            'registrationTransactions2' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_mechanic_helper_3'),
            'registrationTransactions3' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_assign_mechanic'),
            'registrationTransactions4' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_sales_person'),
            'saleEstimationHeaders' => array(self::HAS_MANY, 'SaleEstimationHeader', 'employee_id_sale_person'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'recruitment_date' => 'Recruitment Date',
            'local_address' => 'Local Address',
            'home_address' => 'Home Address',
            'province_id' => 'Province',
            'city_id' => 'City',
            'home_province' => 'Home Province',
            'home_city' => 'Home City',
            'sex' => 'Sex',
            'email' => 'Email',
            'id_card' => 'Id Card',
            'driving_license' => 'Driving License',
            'branch_id' => 'Branch',
            'status' => 'Status',
            'salary_type' => 'Salary Type',
            'basic_salary' => 'Basic Salary',
            'payment_type' => 'Payment Type',
            'code' => 'Code',
            'availability' => 'Availability',
            'skills' => 'Skills',
            'registration_service_id' => 'Registration Service',
            'is_deleted' => 'Is Deleted',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'off_day' => 'Off Day',
            'mobile_phone_number' => 'Mobile Phone Number',
            'marriage_status' => 'Marriage Status',
            'children_quantity' => 'Children Quantity',
            'emergency_contact_relationship' => 'Emergency Contact Relationship',
            'division_id' => 'Division',
            'position_id' => 'Position',
            'level_id' => 'Level',
            'employee_head_id' => 'Employee Head',
            'mother_name' => 'Mother Name',
            'bank_name' => 'Bank Name',
            'birth_place' => 'Birth Place',
            'emergency_contact_name' => 'Emergency Contact Name',
            'religion' => 'Religion',
            'family_card_number' => 'Family Card Number',
            'bank_account_number' => 'Bank Account Number',
            'tax_registration_number' => 'Tax Registration Number',
            'school_degree' => 'School Degree',
            'school_subject' => 'School Subject',
            'employment_type' => 'Employment Type',
            'emergency_contact_mobile_phone' => 'Emergency Contact Mobile Phone',
            'birth_date' => 'Birth Date',
            'emergency_contact_address' => 'Emergency Contact Address',
            'onleave_allocation' => 'Onleave Allocation',
            'user_id' => 'User',
            'clock_in_time' => 'Clock In Time',
            'clock_out_time' => 'Clock Out Time',
            'created_datetime' => 'Created Datetime',
            'updated_datetime' => 'Updated Datetime',
            'user_id_updated' => 'User Id Updated',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('recruitment_date', $this->recruitment_date, true);
        $criteria->compare('local_address', $this->local_address, true);
        $criteria->compare('home_address', $this->home_address, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('home_province', $this->home_province);
        $criteria->compare('home_city', $this->home_city);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('id_card', $this->id_card, true);
        $criteria->compare('driving_license', $this->driving_license, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('salary_type', $this->salary_type, true);
        $criteria->compare('basic_salary', $this->basic_salary, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('availability', $this->availability, true);
        $criteria->compare('skills', $this->skills, true);
        $criteria->compare('registration_service_id', $this->registration_service_id);
        $criteria->compare('is_deleted', $this->is_deleted);
        $criteria->compare('deleted_at', $this->deleted_at, true);
        $criteria->compare('deleted_by', $this->deleted_by);
        $criteria->compare('off_day', $this->off_day, true);
        $criteria->compare('mobile_phone_number', $this->mobile_phone_number, true);
        $criteria->compare('marriage_status', $this->marriage_status, true);
        $criteria->compare('children_quantity', $this->children_quantity);
        $criteria->compare('emergency_contact_relationship', $this->emergency_contact_relationship, true);
        $criteria->compare('division_id', $this->division_id);
        $criteria->compare('position_id', $this->position_id);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('employee_head_id', $this->employee_head_id);
        $criteria->compare('mother_name', $this->mother_name, true);
        $criteria->compare('bank_name', $this->bank_name, true);
        $criteria->compare('birth_place', $this->birth_place, true);
        $criteria->compare('emergency_contact_name', $this->emergency_contact_name, true);
        $criteria->compare('religion', $this->religion, true);
        $criteria->compare('family_card_number', $this->family_card_number, true);
        $criteria->compare('bank_account_number', $this->bank_account_number, true);
        $criteria->compare('tax_registration_number', $this->tax_registration_number, true);
        $criteria->compare('school_degree', $this->school_degree, true);
        $criteria->compare('school_subject', $this->school_subject, true);
        $criteria->compare('employment_type', $this->employment_type, true);
        $criteria->compare('emergency_contact_mobile_phone', $this->emergency_contact_mobile_phone, true);
        $criteria->compare('birth_date', $this->birth_date, true);
        $criteria->compare('emergency_contact_address', $this->emergency_contact_address, true);
        $criteria->compare('onleave_allocation', $this->onleave_allocation);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('clock_in_time', $this->clock_in_time, true);
        $criteria->compare('clock_out_time', $this->clock_out_time, true);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('user_id_updated', $this->user_id_updated);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchResigned() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('local_address', $this->local_address, true);
        $criteria->compare('home_address', $this->home_address, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('home_province', $this->home_province);
        $criteria->compare('home_city', $this->home_city);
        $criteria->compare('sex', $this->sex, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('id_card', $this->id_card, true);
        $criteria->compare('driving_license', $this->driving_license, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('status', 'Inactive');
        $criteria->compare('salary_type', $this->salary_type, true);
        $criteria->compare('basic_salary', $this->basic_salary, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('availability', $this->availability, true);
        $criteria->compare('skills', $this->skills, true);
        $criteria->compare('off_day', $this->off_day, true);
        $criteria->compare('recruitment_date', $this->recruitment_date);
        $criteria->compare('is_deleted', 1);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name ASC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByMechanicPerformance() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('availability', $this->availability, true);
        $criteria->compare('skills', $this->skills, true);

        $tampilkan = ($this->is_deleted == 1) ? array(0, 1) : array(0);
        $criteria->addInCondition('t.is_deleted', $tampilkan);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name ASC',
            ),
        ));
    }

    public function getUsername() {
        $user = Users::model()->findByAttributes(array('employee_id' => $this->id));
        
        return empty($user) ? '' : $user->username;
    }
    
    public function getSalesmanPerformanceReport($startDate, $endDate) {
        
        $params = array(
            ':employee_id_sales_person' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "
            SELECT i.id, i.invoice_number, i.invoice_date, r.repair_type, c.name AS customer, v.plate_number AS vehicle, i.total_price AS total_price, i.status
            FROM " . RegistrationTransaction::model()->tableName() . " r
            INNER JOIN " . InvoiceHeader::model()->tableName() . " i ON r.id = i.registration_transaction_id
            INNER JOIN " . Customer::model()->tableName(). " c ON c.id = i.customer_id
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            WHERE r.employee_id_sales_person = :employee_id_sales_person AND substr(i.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND i.status NOT LIKE '%CANCELLED%'
            ORDER BY i.invoice_date, i.invoice_number
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getEmployeeBirthdayList() {
        $sql = "SELECT MONTH(e.birth_date) as birth_month, e.id_card, e.name, e.mobile_phone_number, d.name AS division, p.name AS position, l.name AS level, 
                    e.employment_type, e.birth_date, TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age
                FROM " . Employee::model()->tableName() . " e 
                INNER JOIN " . Division::model()->tableName() . " d ON d.id = e.division_id
                INNER JOIN " . Position::model()->tableName() . " p ON p.id = e.position_id
                INNER JOIN " . Level::model()->tableName() . " l ON l.id = e.level_id
                WHERE e.status = 'Active'
                ORDER BY birth_month ASC, DAY(e.birth_date)ASC, YEAR(e.birth_date)ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }    
}
