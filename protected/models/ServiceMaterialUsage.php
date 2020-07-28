<?php

/**
 * This is the model class for table "{{service_material_usage}}".
 *
 * The followings are the available columns in table '{{service_material_usage}}':
 * @property integer $id
 * @property integer $service_id
 * @property integer $product_id
 * @property integer $amount
 * @property string $price
 * @property integer $brand
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property Product $product
 */
class ServiceMaterialUsage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceMaterialUsage the static model class
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
		return '{{service_material_usage}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, product_id, amount, price, brand', 'required'),
			array('service_id, product_id, amount, brand', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, product_id, amount, price, brand', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
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
			'product_id' => 'Product',
			'amount' => 'Amount',
			'price' => 'Price',
			'brand' => 'Brand',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('brand',$this->brand);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}