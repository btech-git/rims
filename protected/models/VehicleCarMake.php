<?php

/**
 * This is the model class for table "{{vehicle_car_make}}".
 *
 * The followings are the available columns in table '{{vehicle_car_make}}':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property integer $service_difficulty_rate
 * @property integer $is_approved
 * @property integer $user_id
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property ChasisCode[] $chasisCodes
 * @property Product[] $products
 * @property ProductVehicle[] $productVehicles
 * @property ServicePricelist[] $servicePricelists
 * @property Vehicle[] $vehicles
 * @property VehicleCarModel[] $vehicleCarModels
 * @property VehicleCarSubModel[] $vehicleCarSubModels
 * @property VehicleCarSubModelDetail[] $vehicleCarSubModelDetails
 * @property User $user
 */
class VehicleCarMake extends CActiveRecord {

    const EASY_VALUE = 1;
    const MEDIUM_VALUE = 2;
    const HARD_VALUE = 3;
    const LUXURY_VALUE = 4;
    
    const EASY_LITERAL = 'Easy';
    const MEDIUM_LITERAL = 'Medium';
    const HARD_LITERAL = 'Hard';
    const LUXURY_LITERAL = 'Luxury';
    
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_car_make}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, status, service_difficulty_rate, user_id', 'required'),
            array('name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 10),
            array('service_difficulty_rate, is_approved, user_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, service_difficulty_rate, is_approved, created_datetime, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'chasisCodes' => array(self::HAS_MANY, 'ChasisCode', 'car_make_id'),
            'products' => array(self::HAS_MANY, 'Product', 'vehicle_car_make_id'),
            'productVehicles' => array(self::HAS_MANY, 'ProductVehicle', 'vehicle_car_make_id'),
            'servicePricelists' => array(self::HAS_MANY, 'ServicePricelist', 'car_make_id'),
            'vehicles' => array(self::HAS_MANY, 'Vehicle', 'car_make_id'),
            'vehicleCarModels' => array(self::HAS_MANY, 'VehicleCarModel', 'car_make_id'),
            'vehicleCarSubModels' => array(self::HAS_MANY, 'VehicleCarSubModel', 'car_make_id'),
            'vehicleCarSubModelDetails' => array(self::HAS_MANY, 'VehicleCarSubModelDetail', 'car_make_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'service_difficulty_rate' => 'Service Difficulty Rate',
            'is_approved' => 'Approval',
            'user_id' => 'User Input',
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
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.service_difficulty_rate', $this->service_difficulty_rate);  
        $criteria->compare('t.is_approved', $this->is_approved);      
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('t.user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VehicleCarMake the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getServiceDifficultyRate($rate) {
        switch ($rate) {
            case self::EASY_VALUE: return self::EASY_LITERAL;
            case self::MEDIUM_VALUE: return self::MEDIUM_LITERAL;
            case self::HARD_VALUE: return self::HARD_LITERAL;
            case self::LUXURY_VALUE: return self::LUXURY_LITERAL;
            default: return '';
        }
    }
    
    public function getSaleVehicleProductReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':car_make_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        
        $sql = "SELECT r.transaction_number, r.transaction_date, p.code, p.name, d.quantity, d.sale_price, d.total_price, c.name AS customer
                FROM " . Vehicle::model()->tableName() . " v
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON v.id = r.vehicle_id
                INNER JOIN " . RegistrationProduct::model()->tableName() . " d ON r.id = d.registration_transaction_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
                WHERE substr(r.transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND v.car_make_id = :car_make_id" . $branchConditionSql . "
                ORDER BY r.transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}