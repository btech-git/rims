<?php

/**
 * This is the model class for table "{{customer_service_rate}}".
 *
 * The followings are the available columns in table '{{customer_service_rate}}':
 * @property integer $id
 * @property integer $customer_id
 * @property integer $service_type_id
 * @property integer $service_category_id
 * @property integer $service_id
 * @property integer $car_make_id
 * @property integer $car_model_id
 * @property integer $car_sub_model_id
 * @property string $rate
 *
 * The followings are the available model relations:
 * @property Customer $customer
 * @property Service $service
 * @property VehicleCarMake $carMake
 * @property VehicleCarModel $carModel
 * @property VehicleCarSubModel $carSubModel
 * @property ServiceType $serviceType
 * @property ServiceCategory $serviceCategory
 */
class CustomerServiceRate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CustomerServiceRate the static model class
	 */

	public $customer_name;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer_service_rate}}';
	}
	public $service_name;
	public $service_category_name;
	public $service_type_name;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, service_id, car_make_id, car_model_id, car_sub_model_id, rate', 'required'),
			array('customer_id, service_type_id, service_category_id, service_id, car_make_id, car_model_id, car_sub_model_id', 'numerical', 'integerOnly'=>true),
			array('rate', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer_id, service_type_id, service_category_id, service_id, car_make_id, car_model_id, car_sub_model_id, rate', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'carMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'car_make_id'),
			'carModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'car_model_id'),
			'carSubModel' => array(self::BELONGS_TO, 'VehicleCarSubModel', 'car_sub_model_id'),
			'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'service_type_id'),
			'serviceCategory' => array(self::BELONGS_TO, 'ServiceCategory', 'service_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'service_type_id' => 'Service Type',
			'service_category_id' => 'Service Category',
			'service_id' => 'Service',
			'car_make_id' => 'Car Make',
			'car_model_id' => 'Car Model',
			'car_sub_model_id' => 'Car Sub Model',
			'rate' => 'Rate',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('service_type_id',$this->service_type_id);
		$criteria->compare('service_category_id',$this->service_category_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('car_make_id',$this->car_make_id);
		$criteria->compare('car_model_id',$this->car_model_id);
		$criteria->compare('car_sub_model_id',$this->car_sub_model_id);
		$criteria->compare('rate',$this->rate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}