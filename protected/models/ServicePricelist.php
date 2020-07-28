<?php

/**
 * This is the model class for table "{{service_pricelist}}".
 *
 * The followings are the available columns in table '{{service_pricelist}}':
 * @property integer $id
 * @property integer $service_id
 * @property integer $car_make_id
 * @property integer $car_model_id
 * @property integer $car_sub_detail_id
 * @property string $difficulty
 * @property string $difficulty_value
 * @property string $regular
 * @property string $luxury
 * @property string $luxury_value
 * @property string $luxury_calc
 * @property string $standard_flat_rate_per_hour
 * @property string $flat_rate_hour
 * @property string $price
 * @property string $common_price
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property VehicleCarMake $carMake
 * @property VehicleCarModel $carModel
 * @property VehicleCarSubModel $carSubDetail
 */
class ServicePricelist extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServicePricelist the static model class
	 */

	public $service_code;
	public $service_name;
	public $car_make_code;
	public $car_model_code;
	public $service_category_code;
	public $car_sub_detail_code;
	public $service_type_code;
	public $findkeyword;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_pricelist}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, car_make_id', 'required'),
			array('service_id, car_make_id, car_model_id, car_sub_detail_id', 'numerical', 'integerOnly'=>true),
			array('difficulty, difficulty_value, regular, luxury_value, luxury_calc, standard_flat_rate_per_hour, price, luxury, flat_rate_hour,common_price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, car_make_id, car_model_id, car_sub_detail_id, difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, standard_flat_rate_per_hour, flat_rate_hour, price,car_make_code, car_model_code, service_name, service_category_code, car_sub_detail_code, service_type_code, service_code, findkeyword', 'safe', 'on'=>'search'),
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
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'carMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'car_make_id'),
			'carModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'car_model_id'),
			'carSubDetail' => array(self::BELONGS_TO, 'VehicleCarSubModel', 'car_sub_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_id' => 'Service',
			'car_make_id' => 'Car Make',
			'car_model_id' => 'Car Model',
			'car_sub_detail_id' => 'Car Sub Model',
			'difficulty' => 'Difficulty',
			'difficulty_value' => 'Difficulty Value',
			'regular' => 'Regular',
			'luxury' => 'Luxury',
			'luxury_value' => 'Luxury Value',
			'luxury_calc' => 'Luxury Calc',
			'standard_flat_rate_per_hour' => 'Standard Flat Rate Per Hour',
			'flat_rate_hour' => 'Flat Rate Hour',
			'price' => 'Price',
			'common_price' => 'Common Price',
			'service_code' => 'Service code',
			'service_name' => 'Service',
			'car_make_code' => 'Car Make',
			'car_model_code' => 'Car Model',
			'service_category_code' => 'Service Category',
			'car_sub_detail_code' => 'Car Sub Model',
			'service_type_code' => 'Service Type',
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
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('car_make_id',$this->car_make_id);
		$criteria->compare('car_model_id',$this->car_model_id);
		$criteria->compare('car_sub_detail_id',$this->car_sub_detail_id);
		$criteria->compare('t.difficulty',$this->difficulty,true);
		$criteria->compare('t.difficulty_value',$this->difficulty_value,true);
		$criteria->compare('t.regular',$this->regular,true);
		$criteria->compare('t.luxury',$this->luxury);
		$criteria->compare('t.luxury_value',$this->luxury_value,true);
		$criteria->compare('t.luxury_calc',$this->luxury_calc,true);
		$criteria->compare('t.standard_flat_rate_per_hour',$this->standard_flat_rate_per_hour,true);
		$criteria->compare('t.flat_rate_hour',$this->flat_rate_hour);
		$criteria->compare('t.price',$this->price,true);
		$criteria->compare('t.common_price',$this->price,true);
		// $criteria->compare('serviceType.name',$this->service_type_code,true);

		$criteria->together = 'true';
		$criteria->with = array('carMake','carModel','carSubDetail','service'=>array('with'=>array('serviceCategory','serviceType')));
		$criteria->compare('carMake.name', $this->car_make_code, true);
		$criteria->compare('serviceCategory.name', $this->service_category_code, true);
		$criteria->compare('serviceType.name', $this->service_type_code, true);
		$criteria->compare('carModel.name', $this->car_model_code, true);
		$criteria->compare('carSubDetail.name', $this->car_sub_detail_code, true);
		$criteria->compare('service.name', $this->service_name, true);
		$criteria->compare('service.code', $this->service_code, true);


        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {

	        $criteria->compare('carMake.name',$key,true,'OR');
	        $criteria->compare('serviceCategory.name',$key,true,'OR');
	        $criteria->compare('serviceType.name',$key,true,'OR');
	        $criteria->compare('carModel.name',$key,true,'OR');
	        $criteria->compare('carSubDetail.name',$key,true,'OR');
	        $criteria->compare('service.name',$key,true,'OR');
	        $criteria->compare('service.code',$key, true, 'OR');

			$criteria->compare('t.difficulty',$key,true,'OR');
			$criteria->compare('t.luxury',$key,true,'OR');
			$criteria->compare('t.price',$key,true,'OR');
			$criteria->compare('t.common_price',$key,true,'OR');
		}

		//print_r($criteria); exit; 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 'service.name',
            'attributes' => array(
	                'car_make_code' => array(
	                    'asc' => 'carMake.name ASC',
	                    'desc' => 'carMake.name DESC',
	                ),
	                'service_category_code' => array(
	                    'asc' => 'serviceCategory.name ASC',
	                    'desc' => 'serviceCategory.name DESC',
	                ),
	                'service_type_code' => array(
	                    'asc' => 'serviceType.name ASC',
	                    'desc' => 'serviceType.name DESC',
	                ),
	                'car_model_code' => array(
	                    'asc' => 'carModel.name ASC',
	                    'desc' => 'carModel.name DESC',
	                ),
	                'car_sub_detail_code' => array(
	                    'asc' => 'carSubDetail.name ASC',
	                    'desc' => 'carSubDetail.name DESC',
	                ),
	                'service_name' => array(
	                    'asc' => 'service.name ASC',
	                    'desc' => 'service.name DESC',
	                ),
	                'service_code' => array(
	                    'asc' => 'service.code ASC',
	                    'desc' => 'service.code DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),

		));
	}
}