<?php

/**
 * This is the model class for table "{{employee}}".
 *
 * The followings are the available columns in table '{{employee}}':
 * @property integer $id
 * @property string $name
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
 * @property string $recruitment_date
 * @property string $mobile_phone_number
 * @property string $mother_name
 * @property string $religion
 * @property string $marriage_status
 * @property string $family_card_number
 * @property string $school_degree
 * @property string $school_subject
 * @property string $bank_name
 * @property string $bank_account_number
 * @property string $tax_registration_number
 * @property string $employment_type
 * @property integer $division_id
 * @property integer $position_id
 * @property integer $level_id
 * @property integer $employee_head_id
 * @property string $birth_date
 * @property string $birth_place
 * @property string $emergency_contact_name
 * @property string $emergency_contact_relationship
 * @property string $emergency_contact_mobile_phone
 * @property string $emergency_contact_address
 * @property integer $onleave_allocation
 * @property integer $children_quantity
 * @property string $clock_in_time
 * @property string $clock_out_time
 * 
 * The followings are the available model relations:
 * @property Province $province
 * @property City $city
 * @property Province $homeProvince
 * @property City $homeCity
 * @property RegistrationService $registrationService
 * @property EmployeeBank[] $employeeBanks
 * @property EmployeeBranchDivisionPositionLevel[] $employeeBranchDivisionPositionLevels
 * @property EmployeeDeductions[] $employeeDeductions
 * @property EmployeeIncentives[] $employeeIncentives
 * @property EmployeeMobile[] $employeeMobiles
 * @property EmployeePhone[] $employeePhones
 * @property EquipmentMaintenance[] $equipmentMaintenances
 * @property RegistrationService[] $registrationServices
 * @property RegistrationServiceEmployee[] $registrationServiceEmployees
 * @property WorkOrderDetail[] $workOrderDetails
 * @property RegistrationTransaction[] $registrationTransactions
 */
class Employee extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $city_name;
    public $province_name;
    public $home_province_name;
    public $home_city_name;

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
            array('name, local_address, home_address, sex, email, id_card, branch_id, basic_salary, skills, onleave_allocation, clock_in_time, clock_out_time, off_day', 'required'),
            array('province_id, city_id, home_province, home_city, branch_id, registration_service_id, is_deleted, deleted_by, division_id, position_id, level_id, employee_head_id, onleave_allocation, children_quantity', 'numerical', 'integerOnly' => true),
            array('name, mother_name, bank_name, birth_place, emergency_contact_name', 'length', 'max' => 100),
            array('sex, status, basic_salary', 'length', 'max' => 10),
            array('email, mobile_phone_number, marriage_status, emergency_contact_relationship', 'length', 'max' => 60),
            array('id_card, driving_license, off_day, religion, family_card_number, bank_account_number, tax_registration_number', 'length', 'max' => 30),
            array('salary_type, payment_type, code, school_degree, school_subject, employment_type, emergency_contact_mobile_phone', 'length', 'max' => 50),
            array('availability', 'length', 'max' => 5),
            array('deleted_at, recruitment_date, birth_date, emergency_contact_address', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, local_address, home_address, province_id, city_id, home_province, home_city, sex, email, id_card, driving_license, branch_id, status, salary_type, basic_salary, payment_type, code, availability, skills, registration_service_id, is_deleted, deleted_at, deleted_by, off_day, recruitment_date, mother_name, bank_name, birth_place, emergency_contact_name, mobile_phone_number, marriage_status, emergency_contact_relationship, driving_license, off_day, religion, family_card_number, bank_account_number, tax_registration_number, code, school_degree, school_subject, employment_type, emergency_contact_mobile_phone, division_id, position_id, level_id, employee_head_id, onleave_allocation, children_quantity, clock_in_time, clock_out_time', 'safe', 'on' => 'search'),
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
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'homeProvince' => array(self::BELONGS_TO, 'Province', 'home_province'),
            'homeCity' => array(self::BELONGS_TO, 'City', 'home_city'),
//			'registrationService' => array(self::BELONGS_TO, 'RegistrationService', 'registration_service_id'),
            'employeeBanks' => array(self::HAS_MANY, 'EmployeeBank', 'employee_id'),
            'employeeBranchDivisionPositionLevels' => array(self::HAS_MANY, 'EmployeeBranchDivisionPositionLevel', 'employee_id'),
            'employeeDeductions' => array(self::HAS_MANY, 'EmployeeDeductions', 'employee_id'),
            'employeeIncentives' => array(self::HAS_MANY, 'EmployeeIncentives', 'employee_id'),
            'employeeMobiles' => array(self::HAS_MANY, 'EmployeeMobile', 'employee_id'),
            'employeePhones' => array(self::HAS_MANY, 'EmployeePhone', 'employee_id'),
            'equipmentMaintenances' => array(self::HAS_MANY, 'EquipmentMaintenance', 'employee_id'),
            'registrationServices' => array(self::HAS_MANY, 'RegistrationService', 'start_mechanic_id'),
            'registrationServices1' => array(self::HAS_MANY, 'RegistrationService', 'supervisor_id'),
            'registrationServicesFinish' => array(self::HAS_MANY, 'RegistrationService', 'finish_mechanic_id'),
            'workOrderDetails' => array(self::HAS_MANY, 'WorkOrderDetail', 'employee_id'),
            'registrationTransactions' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_assign_mechanic'),
            'registrationTransactionSalesmans' => array(self::HAS_MANY, 'RegistrationTransaction', 'employee_id_sales_person'),
            'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
            'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
            'employeeHead' => array(self::BELONGS_TO, 'Employee', 'employee_head_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Nama Karyawan',
            'local_address' => 'Alamat Domisili',
            'home_address' => 'Alamat KTP',
            'bank_name' => 'Nama Bank',
            'city_id' => 'City',
            'home_province' => 'Home Province',
            'home_city' => 'Home City',
            'sex' => 'Jenis Kelamin',
            'email' => 'Email',
            'id_card' => 'NIK',
            'driving_licence' => 'SIM',
            'branch_id' => 'Lokasi Cabang',
            'status' => 'Status',
            'salary_type' => 'Salary Type',
            'basic_salary' => 'Basic Salary',
            'payment_type' => 'Payment Type',
            'code' => 'NIP',
            'availability' => 'Availability',
            'recruitment_date' => 'Tanggal Mulai Kerja',
            'skills' => 'Skills',
            'registration_service_id' => 'Registration Service',
            'off_day' => 'Hari Libur',
            'mother_name' => 'Nama Ibu Kandung',
            'birth_place' => 'Tempat Lahir',
            'emergency_contact_name' => 'Nama',
            'division_id' => 'Divisi',
            'employee_head_id' => 'Atasan',
            'position_id' => 'Posisi',
            'level_id' => 'Level',
            'mobile_phone_number' => 'No Telpon',
            'marriage_status' => 'Status Perkawinan',
            'emergency_contact_relationship' => 'Hubungan',
            'religion' => 'Agama',
            'family_card_number' => 'Kartu Keluarga',
            'bank_account_number' => 'No. Rekening',
            'tax_registration_number' => 'NPWP',
            'school_degree' => 'Pendidikan',
            'school_subject' => 'Jurusan',
            'employment_type' => 'Status Karyawan',
            'emergency_contact_mobile_phone' => 'No Telpon',
            'birth_date' => 'Tanggal Lahir',
            'emergency_contact_address' => 'Alamat',
        );
    }

    /**
     * @return array
     */
    public function behaviors() {
        return array(
            'SoftDelete' => array('class' => 'application.components.behaviors.SoftDeleteBehavior'),
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
        $criteria->compare('off_day', $this->off_day, true);
        $criteria->compare('clock_in_time', $this->clock_in_time, true);
        $criteria->compare('clock_out_time', $this->clock_out_time, true);
        $criteria->compare('recruitment_date', $this->recruitment_date);
        $criteria->compare('is_deleted', 0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name ASC',
            ),
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Employee the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByMechanicPerformance() {
        // @todo Please modify the following code to remove attributes that should not be searched.

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
}
