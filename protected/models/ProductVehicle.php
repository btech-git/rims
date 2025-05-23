<?php

/**
 * This is the model class for table "{{product_vehicle}}".
 *
 * The followings are the available columns in table '{{product_vehicle}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $vehicle_car_make_id
 * @property integer $vehicle_car_model_id
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property VehicleCarMake $vehicleCarMake
 * @property VehicleCarModel $vehicleCarModel
 */
class ProductVehicle extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product_vehicle}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, vehicle_car_make_id, vehicle_car_model_id', 'required'),
            array('product_id, vehicle_car_make_id, vehicle_car_model_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, vehicle_car_make_id, vehicle_car_model_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'vehicleCarMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'vehicle_car_make_id'),
            'vehicleCarModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'vehicle_car_model_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'vehicle_car_make_id' => 'Vehicle Car Make',
            'vehicle_car_model_id' => 'Vehicle Car Model',
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
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('vehicle_car_make_id', $this->vehicle_car_make_id);
        $criteria->compare('vehicle_car_model_id', $this->vehicle_car_model_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductVehicle the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
