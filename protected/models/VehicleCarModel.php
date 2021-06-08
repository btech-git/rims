<?php

/**
 * This is the model class for table "{{vehicle_car_model}}".
 *
 * The followings are the available columns in table '{{vehicle_car_model}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $car_make_id
 * @property integer $service_group_id
 * @property string $status
 * @property integer $is_approved
 *
 * The followings are the available model relations:
 * @property ChasisCode[] $chasisCodes
 * @property Product[] $products
 * @property ProductVehicle[] $productVehicles
 * @property ServicePricelist[] $servicePricelists
 * @property ServiceGroup $serviceGroup
 * @property Vehicle[] $vehicles
 * @property VehicleCarMake $carMake
 * @property VehicleCarSubModel[] $vehicleCarSubModels
 * @property VehicleCarSubModelDetail[] $vehicleCarSubModelDetails
 */
class VehicleCarModel extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $car_make;

    public function tableName() {
        return '{{vehicle_car_model}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, car_make_id, service_group_id, status', 'required'),
            array('car_make_id, service_group_id, is_approved', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('description', 'length', 'max' => 60),
            array('status', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, description, car_make_id, service_group_id, car_make, status, is_approved', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'chasisCodes' => array(self::HAS_MANY, 'ChasisCode', 'car_model_id'),
            'products' => array(self::HAS_MANY, 'Product', 'vehicle_car_model_id'),
            'productVehicles' => array(self::HAS_MANY, 'ProductVehicle', 'vehicle_car_model_id'),
            'servicePricelists' => array(self::HAS_MANY, 'ServicePricelist', 'car_model_id'),
            'vehicles' => array(self::HAS_MANY, 'Vehicle', 'car_model_id'),
            'carMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'car_make_id'),
            'serviceGroup' => array(self::BELONGS_TO, 'ServiceGroup', 'service_group_id'),
            'vehicleCarSubModels' => array(self::HAS_MANY, 'VehicleCarSubModel', 'car_model_id'),
            'vehicleCarSubModelDetails' => array(self::HAS_MANY, 'VehicleCarSubModelDetail', 'car_model_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'car_make_id' => 'Car Make',
            'service_group_id' => 'Service Group',
            'status' => 'Status',
            'is_approved' => 'Approval',
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
        $criteria->compare('description', $this->description, true);
        $criteria->compare('t.car_make_id', $this->car_make_id);
        $criteria->compare('t.service_group_id', $this->service_group_id);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);

        $criteria->together = 'true';
        $criteria->with = array('carMake');
        $criteria->compare('carMake.name', $this->car_make, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.name',
                'attributes' => array(
                    'car_make' => array(
                        'asc' => 'carMake.name ASC',
                        'desc' => 'carMake.name DESC',
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
     * @return VehicleCarModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}