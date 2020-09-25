<?php

/**
 * This is the model class for table "{{service_group}}".
 *
 * The followings are the available columns in table '{{service_group}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $standard_flat_rate
 *
 * The followings are the available model relations:
 * @property ServicePricelist[] $servicePricelists
 * @property ServiceVehicle[] $serviceVehicles
 * @property VehicleCarModel[] $vehicleCarModels
 */
class ServiceGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>20),
			array('standard_flat_rate', 'length', 'max'=>18),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, standard_flat_rate', 'safe', 'on'=>'search'),
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
			'servicePricelists' => array(self::HAS_MANY, 'ServicePricelist', 'service_group_id'),
			'serviceVehicles' => array(self::HAS_MANY, 'ServiceVehicle', 'service_group_id'),
			'vehicleCarModels' => array(self::HAS_MANY, 'VehicleCarModel', 'service_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'standard_flat_rate' => 'Standard Flat Rate',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('standard_flat_rate',$this->standard_flat_rate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}