<?php

/**
 * This is the model class for table "{{sale_package_detail}}".
 *
 * The followings are the available columns in table '{{sale_package_detail}}':
 * @property integer $id
 * @property integer $quantity
 * @property string $price
 * @property integer $product_id
 * @property integer $service_id
 * @property integer $is_inactive
 * @property integer $sale_package_header_id
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property SalePackageHeader $salePackageHeader
 * @property Service $service
 */
class SalePackageDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sale_package_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sale_package_header_id', 'required'),
			array('quantity, product_id, service_id, is_inactive, sale_package_header_id', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, quantity, price, product_id, service_id, is_inactive, sale_package_header_id', 'safe', 'on'=>'search'),
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
			'salePackageHeader' => array(self::BELONGS_TO, 'SalePackageHeader', 'sale_package_header_id'),
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
			'quantity' => 'Quantity',
			'price' => 'Price',
			'product_id' => 'Product',
			'service_id' => 'Service',
			'is_inactive' => 'Is Inactive',
			'sale_package_header_id' => 'Sale Package Header',
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
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('is_inactive',$this->is_inactive);
		$criteria->compare('sale_package_header_id',$this->sale_package_header_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalePackageDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
