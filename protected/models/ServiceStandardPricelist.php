<?php

/**
 * This is the model class for table "{{service_standard_pricelist}}".
 *
 * The followings are the available columns in table '{{service_standard_pricelist}}':
 * @property integer $id
 * @property integer $service_id
 * @property string $difficulty
 * @property string $difficulty_value
 * @property string $regular
 * @property string $luxury
 * @property string $luxury_value
 * @property string $luxury_calc
 * @property string $standard_rate_per_hour
 * @property string $flat_rate_hour
 * @property string $price
 * @property string $common_price
 *
 * The followings are the available model relations:
 * @property Service $service
 */
class ServiceStandardPricelist extends CActiveRecord
{
	public $service_name;
	public $service_code;
	public $service_category_code;
	public $service_type_code;
	public $findkeyword;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceStandardPricelist the static model class
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
		return '{{service_standard_pricelist}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id', 'required'),
			array('service_id', 'numerical', 'integerOnly'=>true),
			array('difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, standard_rate_per_hour, flat_rate_hour, price, common_price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, standard_rate_per_hour, flat_rate_hour, price, common_price, service_name, service_category_code, service_type_code, service_code, findkeyword', 'safe', 'on'=>'search'),
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
			'difficulty' => 'Difficulty',
			'difficulty_value' => 'Difficulty Value',
			'regular' => 'Regular',
			'luxury' => 'Luxury',
			'luxury_value' => 'Luxury Value',
			'luxury_calc' => 'Luxury Calc',
			'standard_rate_per_hour' => 'Standard Rate Per Hour',
			'flat_rate_hour' => 'Flat Rate Hour',
			'price' => 'Price',
			'common_price' => 'Common Price',
			'service_code' => 'Service code',
			'service_name' => 'Service',
			'service_category_code' => 'Service Category',
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
		$criteria->compare('difficulty',$this->difficulty,true);
		$criteria->compare('difficulty_value',$this->difficulty_value,true);
		$criteria->compare('regular',$this->regular,true);
		$criteria->compare('luxury',$this->luxury,true);
		$criteria->compare('luxury_value',$this->luxury_value,true);
		$criteria->compare('luxury_calc',$this->luxury_calc,true);
		$criteria->compare('standard_rate_per_hour',$this->standard_rate_per_hour,true);
		$criteria->compare('flat_rate_hour',$this->flat_rate_hour,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('common_price',$this->common_price,true);
		
		$criteria->together = 'true';
		$criteria->with = array('service'=>array('with'=>array('serviceCategory','serviceType')));
		$criteria->compare('serviceCategory.name', $this->service_category_code, true);
		$criteria->compare('serviceType.name', $this->service_type_code, true);
		$criteria->compare('service.name', $this->service_name, true);
		$criteria->compare('service.code', $this->service_code, true);


        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {

	        $criteria->compare('serviceCategory.name',$key,true,'OR');
	        $criteria->compare('serviceType.name',$key,true,'OR');
	        $criteria->compare('service.name',$key,true,'OR');
	        $criteria->compare('service.code',$key, true, 'OR');

			$criteria->compare('t.difficulty',$key,true,'OR');
			$criteria->compare('t.luxury',$key,true,'OR');
			$criteria->compare('t.price',$key,true,'OR');
			$criteria->compare('t.common_price',$key,true,'OR');
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 'service.name',
            'attributes' => array(
	                'service_category_code' => array(
	                    'asc' => 'serviceCategory.name ASC',
	                    'desc' => 'serviceCategory.name DESC',
	                ),
	                'service_type_code' => array(
	                    'asc' => 'serviceType.name ASC',
	                    'desc' => 'serviceType.name DESC',
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