<?php

/**
 * This is the model class for table "{{product_specification_battery}}".
 *
 * The followings are the available columns in table '{{product_specification_battery}}':
 * @property integer $id
 * @property integer $product_id
 * @property string $category
 * @property string $type
 * @property string $parts_serial_number
 * @property integer $sub_brand_id
 * @property integer $sub_brand_series_id
 * @property integer $voltage
 * @property integer $amp
 * @property integer $capacity
 * @property string $description
 * @property string $car_type
 * @property integer $size
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property SubBrand $subBrand
 * @property SubBrandSeries $subBrandSeries
 */
class ProductSpecificationBattery extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_specification_battery}}';
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
			array('product_id, sub_brand_id, sub_brand_series_id, voltage, amp, capacity, size', 'numerical', 'integerOnly'=>true),
			array('category, type, parts_serial_number, car_type', 'length', 'max'=>30),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, category, type, parts_serial_number, sub_brand_id, sub_brand_series_id, voltage, amp, capacity, description, car_type, size', 'safe', 'on'=>'search'),
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
			'category' => 'Category',
			'type' => 'Type',
			'parts_serial_number' => 'Parts Serial Number',
			'sub_brand_id' => 'Sub Brand',
			'sub_brand_series_id' => 'Sub Brand Series',
			'voltage' => 'Voltage',
			'amp' => 'Amp',
			'capacity' => 'Capacity',
			'description' => 'Description',
			'car_type' => 'Car Type',
			'size' => 'Size',
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
		$criteria->compare('category',$this->category,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('parts_serial_number',$this->parts_serial_number,true);
		$criteria->compare('sub_brand_id',$this->sub_brand_id);
		$criteria->compare('sub_brand_series_id',$this->sub_brand_series_id);
		$criteria->compare('voltage',$this->voltage);
		$criteria->compare('amp',$this->amp);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('car_type',$this->car_type,true);
		$criteria->compare('size',$this->size);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSpecificationBattery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
