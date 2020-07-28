<?php

/**
 * This is the model class for table "{{vehicle_inspection_detail}}".
 *
 * The followings are the available columns in table '{{vehicle_inspection_detail}}':
 * @property integer $id
 * @property integer $vehicle_inspection_id
 * @property integer $section_id
 * @property integer $module_id
 * @property integer $checklist_type_id
 * @property integer $checklist_module_id
 * @property string $value
 *
 * The followings are the available model relations:
 * @property VehicleInspection $vehicleInspection
 * @property InspectionSection $section
 * @property InspectionModule $module
 * @property InspectionChecklistType $checklistType
 * @property InspectionChecklistModule $checklistModule
 */
class VehicleInspectionDetail extends CActiveRecord
{
	public $checklist_module_radio;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{vehicle_inspection_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section_id, module_id, checklist_type_id, checklist_module_id', 'required'),
			array('vehicle_inspection_id, section_id, module_id, checklist_type_id, checklist_module_id, checklist_module_radio', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vehicle_inspection_id, section_id, module_id, checklist_type_id, checklist_module_id, value, checklist_module_radio', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'vehicleInspection' => array(self::BELONGS_TO, 'VehicleInspection', 'vehicle_inspection_id'),
			'section' => array(self::BELONGS_TO, 'InspectionSection', 'section_id'),
			'module' => array(self::BELONGS_TO, 'InspectionModule', 'module_id'),
			'checklistType' => array(self::BELONGS_TO, 'InspectionChecklistType', 'checklist_type_id'),
			'checklistModule' => array(self::BELONGS_TO, 'InspectionChecklistModule', 'checklist_module_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vehicle_inspection_id' => 'Vehicle Inspection',
			'section_id' => 'Section',
			'module_id' => 'Module',
			'checklist_type_id' => 'Checklist Type',
			'checklist_module_id' => 'Checklist Module',
			'value' => 'Value',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_inspection_id',$this->vehicle_inspection_id);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('checklist_type_id',$this->checklist_type_id);
		$criteria->compare('checklist_module_id',$this->checklist_module_id);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VehicleInspectionDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
