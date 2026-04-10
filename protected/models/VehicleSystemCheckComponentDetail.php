<?php

/**
 * This is the model class for table "{{vehicle_system_check_component_detail}}".
 *
 * The followings are the available columns in table '{{vehicle_system_check_component_detail}}':
 * @property integer $id
 * @property integer $component_condition_before_service
 * @property string $component_condition_after_service
 * @property integer $component_inspection_id
 * @property integer $component_inspection_group_id
 * @property integer $vehicle_system_check_header_id
 *
 * The followings are the available model relations:
 * @property VehicleSystemCheckHeader $vehicleSystemCheckHeader
 * @property ComponentInspection $componentInspection
 * @property ComponentInspectionGroup $componentInspectionGroup
 */
class VehicleSystemCheckComponentDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_system_check_component_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, component_inspection_id, vehicle_system_check_header_id', 'required'),
            array('id, component_condition_before_service, component_inspection_id, component_inspection_group_id, vehicle_system_check_header_id', 'numerical', 'integerOnly' => true),
            array('component_condition_after_service', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, component_condition_before_service, component_condition_after_service, component_inspection_id, component_inspection_group_id, vehicle_system_check_header_id', 'safe', 'on' => 'search'),
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
            'componentInspectionGroup' => array(self::BELONGS_TO, 'ComponentInspectionGroup', 'component_inspection_group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'component_condition_before_service' => 'Component Condition Before Service',
            'component_condition_after_service' => 'Component Condition After Service',
            'component_inspection_id' => 'Component Inspection',
            'component_inspection_group_id' => 'Component Inspection Group',
            'vehicle_system_check_header_id' => 'Vehicle System Check Header',
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
        $criteria->compare('component_condition_before_service', $this->component_condition_before_service);
        $criteria->compare('component_condition_after_service', $this->component_condition_after_service, true);
        $criteria->compare('component_inspection_id', $this->component_inspection_id);
        $criteria->compare('component_inspection_group_id', $this->component_inspection_group_id);
        $criteria->compare('vehicle_system_check_header_id', $this->vehicle_system_check_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return VehicleSystemCheckComponentDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
