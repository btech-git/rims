<?php

/**
 * This is the model class for table "{{vehicle_system_check_tire_detail}}".
 *
 * The followings are the available columns in table '{{vehicle_system_check_tire_detail}}':
 * @property integer $id
 * @property string $front_left_before_service
 * @property string $front_left_after_service
 * @property string $front_right_before_service
 * @property string $front_right_after_service
 * @property string $rear_left_before_service
 * @property string $rear_left_after_service
 * @property string $rear_right_before_service
 * @property string $rear_right_after_service
 * @property integer $vehicle_system_check_header_id
 * @property integer $component_inspection_id
 *
 * The followings are the available model relations:
 * @property VehicleSystemCheckHeader $vehicleSystemCheckHeader
 * @property ComponentInspection $componentInspection
 */
class VehicleSystemCheckTireDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_system_check_tire_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('vehicle_system_check_header_id, component_inspection_id', 'required'),
            array('vehicle_system_check_header_id, component_inspection_id', 'numerical', 'integerOnly' => true),
            array('front_left_before_service, front_left_after_service, front_right_before_service, front_right_after_service, rear_left_before_service, rear_left_after_service, rear_right_before_service, rear_right_after_service', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, front_left_before_service, front_left_after_service, front_right_before_service, front_right_after_service, rear_left_before_service, rear_left_after_service, rear_right_before_service, rear_right_after_service, vehicle_system_check_header_id, component_inspection_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vehicleSystemCheckHeader' => array(self::BELONGS_TO, 'VehicleSystemCheckHeader', 'vehicle_system_check_header_id'),
            'componentInspection' => array(self::BELONGS_TO, 'ComponentInspection', 'component_inspection_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'front_left_before_service' => 'Front Left Before Service',
            'front_left_after_service' => 'Front Left After Service',
            'front_right_before_service' => 'Front Right Before Service',
            'front_right_after_service' => 'Front Right After Service',
            'rear_left_before_service' => 'Rear Left Before Service',
            'rear_left_after_service' => 'Rear Left After Service',
            'rear_right_before_service' => 'Rear Right Before Service',
            'rear_right_after_service' => 'Rear Right After Service',
            'vehicle_system_check_header_id' => 'Vehicle System Check Header',
            'component_inspection_id' => 'Component Inspection',
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
        $criteria->compare('front_left_before_service', $this->front_left_before_service, true);
        $criteria->compare('front_left_after_service', $this->front_left_after_service, true);
        $criteria->compare('front_right_before_service', $this->front_right_before_service, true);
        $criteria->compare('front_right_after_service', $this->front_right_after_service, true);
        $criteria->compare('rear_left_before_service', $this->rear_left_before_service, true);
        $criteria->compare('rear_left_after_service', $this->rear_left_after_service, true);
        $criteria->compare('rear_right_before_service', $this->rear_right_before_service, true);
        $criteria->compare('rear_right_after_service', $this->rear_right_after_service, true);
        $criteria->compare('vehicle_system_check_header_id', $this->vehicle_system_check_header_id);
        $criteria->compare('component_inspection_id', $this->component_inspection_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VehicleSystemCheckTireDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
