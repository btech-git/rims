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
            array('name, local_address, home_address, province_id, city_id, home_province, home_city, sex, email, id_card, driving_license, branch_id, basic_salary, skills', 'required'),
            array('province_id, city_id, home_province, home_city, branch_id, registration_service_id, is_deleted, deleted_by', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('sex, status, basic_salary', 'length', 'max' => 10),
            array('email', 'length', 'max' => 60),
            array('id_card, driving_license, off_day', 'length', 'max' => 30),
            array('salary_type, payment_type, code', 'length', 'max' => 50),
            array('availability', 'length', 'max' => 5),
            array('deleted_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, local_address, home_address, province_id, city_id, home_province, home_city, sex, email, id_card, driving_license, branch_id, status, salary_type, basic_salary, payment_type, code, availability, skills, registration_service_id, is_deleted, deleted_at, deleted_by, off_day', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'local_address' => 'Local Address',
            'home_address' => 'Home Address',
            'province_id' => 'Province',
            'city_id' => 'City',
            'home_province' => 'Home Province',
            'home_city' => 'Home City',
            'sex' => 'Sex',
            'email' => 'Email',
            'id_card' => 'Id Card No',
            'driving_licence' => 'Driving Licence No',
            'branch_id' => 'Branch',
            'status' => 'Status',
            'salary_type' => 'Salary Type',
            'basic_salary' => 'Basic Salary',
            'payment_type' => 'Payment Type',
            'code' => 'Code',
            'availability' => 'Availability',
            // 'is_deleted' => 'Deleted',
            'skills' => 'Skills',
            'registration_service_id' => 'Registration Service',
            'off_day' => 'Off Day',
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

        $tampilkan = ($this->is_deleted == 1) ? array(0, 1) : array(0);
        $criteria->addInCondition('is_deleted', $tampilkan);

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

}
