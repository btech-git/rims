<?php

/**
 * This is the model class for table "{{product_specification_oil}}".
 *
 * The followings are the available columns in table '{{product_specification_oil}}':
 * @property integer $id
 * @property integer $product_id
 * @property string $category_usage
 * @property string $oil_type
 * @property integer $transmission
 * @property string $code_serial
 * @property integer $sub_brand_id
 * @property integer $sub_brand_series_id
 * @property string $fuel
 * @property integer $dot_code
 * @property string $viscosity_low_t
 * @property string $viscosity_high
 * @property string $api_code
 * @property string $size_measurements
 * @property string $size
 * @property string $name
 * @property string $description
 * @property string $car_use
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property SubBrand $subBrand
 * @property SubBrandSeries $subBrandSeries
 */
class ProductSpecificationOil extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_specification_oil}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id', 'required'),
			array('product_id, transmission, sub_brand_id, sub_brand_series_id, dot_code', 'numerical', 'integerOnly'=>true),
			array('category_usage, oil_type, code_serial, fuel', 'length', 'max'=>30),
			array('viscosity_low_t, viscosity_high, api_code, size_measurements, size', 'length', 'max'=>10),
			array('name', 'length', 'max'=>50),
			array('description, car_use', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, category_usage, oil_type, transmission, code_serial, sub_brand_id, sub_brand_series_id, fuel, dot_code, viscosity_low_t, viscosity_high, api_code, size_measurements, size, name, description, car_use', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'subBrand' => array(self::BELONGS_TO, 'SubBrand', 'sub_brand_id'),
			'subBrandSeries' => array(self::BELONGS_TO, 'SubBrandSeries', 'sub_brand_series_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'category_usage' => 'Category Usage',
			'oil_type' => 'Oil Type',
			'transmission' => 'Transmission',
			'code_serial' => 'Code Serial',
			'sub_brand_id' => 'Sub Brand',
			'sub_brand_series_id' => 'Sub Brand Series',
			'fuel' => 'Fuel',
			'dot_code' => 'Dot Code',
			'viscosity_low_t' => 'Viscosity Low T',
			'viscosity_high' => 'Viscosity High',
			'api_code' => 'Api Code',
			'size_measurements' => 'Size Measurements',
			'size' => 'Size',
			'name' => 'Name',
			'description' => 'Description',
			'car_use' => 'Car Use',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('category_usage',$this->category_usage,true);
		$criteria->compare('oil_type',$this->oil_type,true);
		$criteria->compare('transmission',$this->transmission);
		$criteria->compare('code_serial',$this->code_serial,true);
		$criteria->compare('sub_brand_id',$this->sub_brand_id);
		$criteria->compare('sub_brand_series_id',$this->sub_brand_series_id);
		$criteria->compare('fuel',$this->fuel,true);
		$criteria->compare('dot_code',$this->dot_code);
		$criteria->compare('viscosity_low_t',$this->viscosity_low_t,true);
		$criteria->compare('viscosity_high',$this->viscosity_high,true);
		$criteria->compare('api_code',$this->api_code,true);
		$criteria->compare('size_measurements',$this->size_measurements,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('car_use',$this->car_use,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSpecificationOil the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
