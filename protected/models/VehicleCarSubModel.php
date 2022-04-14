<?php

/**
 * This is the model class for table "{{vehicle_car_sub_model}}".
 *
 * The followings are the available columns in table '{{vehicle_car_sub_model}}':
 * @property integer $id
 * @property integer $car_make_id
 * @property integer $car_model_id
 * @property string $name
 * @property integer $is_approved
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property ServicePricelist[] $servicePricelists
 * @property Vehicle[] $vehicles
 * @property VehicleCarMake $carMake
 * @property VehicleCarModel $carModel
 * @property VehicleCarSubModelDetail[] $vehicleCarSubModelDetails
 * @property User $user
 */
class VehicleCarSubModel extends CActiveRecord {

    public $car_make;
    public $car_model;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_car_sub_model}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('car_make_id, car_model_id, name, user_id', 'required'),
            array('car_make_id, car_model_id, is_approved, user_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, car_make_id, car_model_id, name,car_make,car_model, is_approved, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'servicePricelists' => array(self::HAS_MANY, 'ServicePricelist', 'car_sub_detail_id'),
            'vehicles' => array(self::HAS_MANY, 'Vehicle', 'car_sub_model_id'),
            'carMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'car_make_id'),
            'carModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'car_model_id'),
            'vehicleCarSubModelDetails' => array(self::HAS_MANY, 'VehicleCarSubModelDetail', 'car_sub_model_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'car_make_id' => 'Car Make',
            'car_model_id' => 'Car Model',
            'name' => 'Name',
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
        $criteria->compare('t.car_make_id', $this->car_make_id);
        $criteria->compare('t.car_model_id', $this->car_model_id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id', $this->user_id);

        $criteria->together = 'true';
        $criteria->with = array('carMake', 'carModel');
        $criteria->compare('carMake.name', $this->car_make, true);
        $criteria->compare('carModel.name', $this->car_model, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.name ASC',
                'attributes' => array(
                    'car_make' => array(
                        'asc' => 'carMake.name ASC',
                        'desc' => 'carMake.name DESC',
                    ),
                    'car_model' => array(
                        'asc' => 'carModel.name ASC',
                        'desc' => 'carModel.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VehicleCarSubModel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
