<?php

/**
 * This is the model class for table "{{transaction_detail_order}}".
 *
 * The followings are the available columns in table '{{transaction_detail_order}}':
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $purchase_order_detail_id
 * @property integer $purchase_request_id
 * @property integer $purchase_request_detail_id
 * @property integer $purchase_order_quantity
 * @property integer $purchase_order_quantity_left
 * @property integer $receive_quantity
 * @property integer $receive_quantity_left
 * @property string $purchase_order_estimate_arrival_date
 * @property string $unit_price
 * @property string $total_price
 * @property integer $supplier_id
 * @property integer $product_id
 *
 * The followings are the available model relations:
 * @property TransactionPurchaseOrder $purchaseOrder
 * @property TransactionRequestOrder $purchaseRequest
 * @property TransactionRequestOrderDetail $purchaseRequestDetail
 * @property Supplier $supplier
 * @property Product $product
 */
class TransactionDetailOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransactionDetailOrder the static model class
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
		return '{{transaction_detail_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_id, purchase_order_detail_id, purchase_request_id, purchase_request_detail_id, purchase_order_quantity, purchase_order_quantity_left, receive_quantity, receive_quantity_left, supplier_id, product_id', 'numerical', 'integerOnly'=>true),
			array('unit_price, total_price', 'length', 'max'=>18),
			array('purchase_order_estimate_arrival_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, purchase_order_id, purchase_order_detail_id, purchase_request_id, purchase_request_detail_id, purchase_order_quantity, purchase_order_quantity_left, receive_quantity, receive_quantity_left, purchase_order_estimate_arrival_date, unit_price, total_price, supplier_id, product_id', 'safe', 'on'=>'search'),
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
			'purchaseOrder' => array(self::BELONGS_TO, 'TransactionPurchaseOrder', 'purchase_order_id'),
			'purchaseRequest' => array(self::BELONGS_TO, 'TransactionRequestOrder', 'purchase_request_id'),
			'purchaseRequestDetail' => array(self::BELONGS_TO, 'TransactionRequestOrderDetail', 'purchase_request_detail_id'),
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
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
			'purchase_order_id' => 'Purchase Order',
			'purchase_order_detail_id' => 'Purchase Order Detail',
			'purchase_request_id' => 'Purchase Request',
			'purchase_request_detail_id' => 'Purchase Request Detail',
			'purchase_order_quantity' => 'Purchase Order Quantity',
			'purchase_order_quantity_left' => 'Purchase Order Quantity Left',
			'receive_quantity' => 'Receive Quantity',
			'receive_quantity_left' => 'Receive Quantity Left',
			'purchase_order_estimate_arrival_date' => 'Purchase Order Estimate Arrival Date',
			'unit_price' => 'Unit Price',
			'total_price' => 'Total Price',
			'supplier_id' => 'Supplier',
			'product_id' => 'Product',
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
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('purchase_order_detail_id',$this->purchase_order_detail_id);
		$criteria->compare('purchase_request_id',$this->purchase_request_id);
		$criteria->compare('purchase_request_detail_id',$this->purchase_request_detail_id);
		$criteria->compare('purchase_order_quantity',$this->purchase_order_quantity);
		$criteria->compare('purchase_order_quantity_left',$this->purchase_order_quantity_left);
		$criteria->compare('receive_quantity',$this->receive_quantity);
		$criteria->compare('receive_quantity_left',$this->receive_quantity_left);
		$criteria->compare('purchase_order_estimate_arrival_date',$this->purchase_order_estimate_arrival_date,true);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('total_price',$this->total_price,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('product_id',$this->product_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}