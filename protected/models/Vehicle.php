<?php

/**
 * This is the model class for table "{{vehicle}}".
 *
 * The followings are the available columns in table '{{vehicle}}':
 * @property integer $id
 * @property string $plate_number
 * @property integer $plate_number_prefix_id
 * @property string $plate_number_ordinal
 * @property string $plate_number_suffix
 * @property string $machine_number
 * @property string $frame_number
 * @property integer $car_make_id
 * @property integer $car_model_id
 * @property integer $car_sub_model_id
 * @property integer $car_sub_model_detail_id
 * @property integer $color_id
 * @property string $year
 * @property integer $customer_id
 * @property integer $customer_pic_id
 * @property string $chasis_code
 * @property string $transmission
 * @property string $fuel_type
 * @property integer $power
 * @property string $drivetrain
 * @property string $notes
 * @property integer $insurance_company_id
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction[] $registrationTransactions
 * @property VehicleCarMake $carMake
 * @property VehicleCarModel $carModel
 * @property VehicleCarSubModel $carSubModel
 * @property VehicleCarSubModelDetail $carSubModelDetail
 * @property Colors $color
 * @property Customer $customer
 * @property CustomerPic $customerPic
 * @property VehicleInspection[] $vehicleInspections
 * @property Customer $insuranceCompany
 */
class Vehicle extends CActiveRecord {

    public $customer_name;
    public $customer_type;
    public $car_make;
    public $car_model;
    public $car_sub_model;
//    public $color;
    public $car_make_code;
    public $car_model_code;
    public $car_color;
    public $customer_name_checked;
    public $plate_number_checked;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('plate_number, car_make_id, car_model_id, car_sub_model_id, color_id, customer_id', 'required'),
            array('car_make_id, car_model_id, car_sub_model_id, car_sub_model_detail_id, color_id, customer_id, customer_pic_id, power, plate_number_prefix_id, insurance_company_id', 'numerical', 'integerOnly' => true),
            array('year, drivetrain, plate_number_suffix', 'length', 'max' => 10),
            array('plate_number', 'unique', 'message' => 'Plate number already exists.'),
            array('plate_number_prefix_id', 'uniqueValidator', 'attributeName' => array(
                'plate_number_prefix_id', 'plate_number_ordinal', 'plate_number_suffix'), 'on' => 'insert'
            ),
            array('machine_number, frame_number, chasis_code, transmission', 'length', 'max' => 30),
            array('plate_number, fuel_type, plate_number_ordinal', 'length', 'max' => 20),
            array('notes', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, plate_number, machine_number, frame_number, car_make_id, car_model_id, car_sub_model_id, car_sub_model_detail_id, color_id, year, customer_id, customer_pic_id, chasis_code, transmission, fuel_type, power, drivetrain, notes, car_make,color,car_color,car_model,car_sub_model,color, customer_name, customer_type, customer_name_checked, plate_number_checked, plate_number_prefix_id, plate_number_ordinal, plate_number_suffix, insurance_company_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'registrationTransactions' => array(self::HAS_MANY, 'RegistrationTransaction', 'vehicle_id'),
            'carMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'car_make_id'),
            'carModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'car_model_id'),
            'carSubModel' => array(self::BELONGS_TO, 'VehicleCarSubModel', 'car_sub_model_id'),
            'carSubModelDetail' => array(self::BELONGS_TO, 'VehicleCarSubModelDetail', 'car_sub_model_detail_id'),
            'color' => array(self::BELONGS_TO, 'Colors', 'color_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'customerPic' => array(self::BELONGS_TO, 'CustomerPic', 'customer_pic_id'),
            'vehiclePlateNumberPrefix' => array(self::BELONGS_TO, 'VehiclePlateNumberPrefix', 'plate_number_prefix_id'),
            'vehicleInspections' => array(self::HAS_MANY, 'VehicleInspection', 'vehicle_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            't.plate_number' => 'Plate Number',
            't.machine_number' => 'Machine Number',
            'frame_number' => 'Frame Number',
            't.car_make_id' => 'Car Make',
            't.car_model_id' => 'Car Model',
            't.car_sub_model_id' => 'Car Sub Model',
            't.car_sub_model_detail_id' => 'Car Sub Model Detail',
            't.color_id' => 'Color',
            'year' => 'Year',
            'customer_id' => 'Customer',
            'customer_pic_id' => 'Customer Pic',
            'chasis_code' => 'Chasis Code',
            'transmission' => 'Transmission',
            'fuel_type' => 'Fuel Type',
            'power' => 'Power',
            'drivetrain' => 'Drivetrain',
            'notes' => 'Notes',
            'insurance_company_id' => 'Insurance Company',
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
        $criteria->compare('t.plate_number', $this->plate_number, true);
        $criteria->compare('t.plate_number_prefix_id', $this->plate_number_prefix_id);
        $criteria->compare('t.plate_number_ordinal', $this->plate_number_ordinal, true);
        $criteria->compare('t.plate_number_suffix', $this->plate_number_suffix, true);
        $criteria->compare('t.machine_number', $this->machine_number, true);
        $criteria->compare('frame_number', $this->frame_number, true);
        $criteria->compare('t.car_make_id', $this->car_make_id);
        $criteria->compare('t.car_model_id', $this->car_model_id);
        $criteria->compare('t.car_sub_model_id', $this->car_sub_model_id);
        $criteria->compare('t.car_sub_model_detail_id', $this->car_sub_model_detail_id);
        $criteria->compare('t.color_id', $this->color_id);
        $criteria->compare('year', $this->year, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('customer_pic_id', $this->customer_pic_id);
        $criteria->compare('chasis_code', $this->chasis_code, true);
        $criteria->compare('transmission', $this->transmission, true);
        $criteria->compare('fuel_type', $this->fuel_type, true);
        $criteria->compare('power', $this->power);
        $criteria->compare('drivetrain', $this->drivetrain, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);

        $criteria->together = 'true';
        //$criteria->with = array('carMake','carModel','carSubModel','color');
        $criteria->with = array('carMake', 'carModel', 'carSubModel');
        $criteria->compare('carMake.name', $this->car_make, true);
        $criteria->compare('carModel.name', $this->car_model, true);
        $criteria->compare('carSubModel.name', $this->car_sub_model, true);
        //$criteria->compare('color.name', $this->color, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'plate_number',
                'attributes' => array(
                    'car_make' => array(
                        'asc' => 'carMake.name ASC',
                        'desc' => 'carMake.name DESC',
                    ),
                    'car_model' => array(
                        'asc' => 'carModel.name ASC',
                        'desc' => 'carModel.name DESC',
                    ),
                    'car_sub_model' => array(
                        'asc' => 'carSubModel.name ASC',
                        'desc' => 'carSubModel.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Vehicle the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Function to return campaign no to display in create booking grid (admin)
     */
    function getColor($data, $row) {
        $color = '';

        if ($data->color_id) {
            $colors = Colors::model()->findByPk($data->color_id);

            if ($colors['name'])
                $color = $colors['name'];
        }
        return $color;
    }

    public function searchByRegistration() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = array(
            'customer',
            'carMake',
            'carModel',
            'carSubModel',
            'carSubModelDetail',
            'color',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('t.machine_number', $this->machine_number, true);
        $criteria->compare('frame_number', $this->frame_number, true);
        $criteria->compare('t.car_make_id', $this->car_make_id);
        $criteria->compare('t.car_model_id', $this->car_model_id);
        $criteria->compare('t.car_sub_model_id', $this->car_sub_model_id);
        $criteria->compare('t.car_sub_model_detail_id', $this->car_sub_model_detail_id);
        $criteria->compare('t.color_id', $this->color_id);
        $criteria->compare('year', $this->year, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('customer_pic_id', $this->customer_pic_id);
        $criteria->compare('chasis_code', $this->chasis_code, true);
        $criteria->compare('transmission', $this->transmission, true);
        $criteria->compare('fuel_type', $this->fuel_type, true);
        $criteria->compare('power', $this->power);
        $criteria->compare('drivetrain', $this->drivetrain, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('customer.customer_type', $this->customer_type);

        if ($this->customer_name_checked) {
            $customerNameOperator = empty($this->customer_name) ? '=' : 'LIKE';
            $customerNameValue = empty($this->customer_name) ? '' : "%{$this->customer_name}%";
            $criteria->addCondition("customer.name {$customerNameOperator} :customer_name");
            $criteria->params[':customer_name'] = $customerNameValue;
        }

        if ($this->plate_number_checked) {
            $vehiclePlateNumberOperator = empty($this->plate_number) ? '=' : 'LIKE';
            $vehiclePlateNumberValue = empty($this->plate_number) ? '' : "%{$this->plate_number}%";
            $criteria->addCondition("t.plate_number {$vehiclePlateNumberOperator} :plate_number");
            $criteria->params[':plate_number'] = $vehiclePlateNumberValue;
        }

        $criteria->order = 't.plate_number ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getPlateNumberCombination() {
        $vehiclePlateNumberPrefix = VehiclePlateNumberPrefix::model()->findByPk($this->plate_number_prefix_id);
        $code = empty($vehiclePlateNumberPrefix) ? '' : $vehiclePlateNumberPrefix->code;
        
        return $code . " " .$this->plate_number_ordinal . " " . $this->plate_number_suffix; 
    }
    
    public function getCarMakeModelSubCombination() {
        return $this->carMake->name . ' ' . $this->carModel->name . ' ' . $this->carSubModel->name;
    }
}
