<?php

/**
 * This is the model class for table "{{transaction_purchase_order}}".
 *
 * The followings are the available columns in table '{{transaction_purchase_order}}':
 * @property integer $id
 * @property string $purchase_order_no
 * @property string $purchase_order_date
 * @property string $status_document
 * @property integer $supplier_id
 * @property string $payment_type
 * @property string $estimate_date_arrival
 * @property integer $requester_id
 * @property integer $main_branch_id
 * @property integer $approved_id
 * @property integer $total_quantity
 * @property string $price_before_discount
 * @property string $discount
 * @property string $subtotal
 * @property integer $ppn
 * @property string $ppn_price
 * @property string $total_price
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 * @property TransactionPurchaseOrderApproval[] $transactionPurchaseOrderApprovals
 * @property TransactionPurchaseOrderDetail[] $transactionPurchaseOrderDetails
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionReturnOrder[] $transactionReturnOrders
 */
class TransactionPurchaseOrder extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{transaction_purchase_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_no, purchase_order_date, status_document, payment_type, total_quantity, price_before_discount, discount, subtotal, ppn, ppn_price, total_price', 'required'),
			array('supplier_id, requester_id, main_branch_id, approved_id, total_quantity, ppn', 'numerical', 'integerOnly'=>true),
			array('purchase_order_no, status_document', 'length', 'max'=>30),
			array('payment_type', 'length', 'max'=>20),
			array('price_before_discount, discount, subtotal, ppn_price, total_price', 'length', 'max'=>18),
			array('estimate_date_arrival', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, purchase_order_no, purchase_order_date, status_document, supplier_id, payment_type, estimate_date_arrival, requester_id, main_branch_id, approved_id, total_quantity, price_before_discount, discount, subtotal, ppn, ppn_price, total_price', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'transactionPurchaseOrderApprovals' => array(self::HAS_MANY, 'TransactionPurchaseOrderApproval', 'purchase_order_id'),
			'transactionPurchaseOrderDetails' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetail', 'purchase_order_id'),
			'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'purchase_order_id'),
			'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'purchase_order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_order_no' => 'Purchase Order No',
			'purchase_order_date' => 'Purchase Order Date',
			'status_document' => 'Status Document',
			'supplier_id' => 'Supplier',
			'payment_type' => 'Payment Type',
			'estimate_date_arrival' => 'Estimate Date Arrival',
			'requester_id' => 'Requester',
			'main_branch_id' => 'Main Branch',
			'approved_id' => 'Approved',
			'total_quantity' => 'Total Quantity',
			'price_before_discount' => 'Price Before Discount',
			'discount' => 'Discount',
			'subtotal' => 'Subtotal',
			'ppn' => 'Ppn',
			'ppn_price' => 'Ppn Price',
			'total_price' => 'Total Price',
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
		$criteria->compare('purchase_order_no',$this->purchase_order_no,true);
		$criteria->compare('purchase_order_date',$this->purchase_order_date,true);
		$criteria->compare('status_document',$this->status_document,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('estimate_date_arrival',$this->estimate_date_arrival,true);
		$criteria->compare('requester_id',$this->requester_id);
		$criteria->compare('main_branch_id',$this->main_branch_id);
		$criteria->compare('approved_id',$this->approved_id);
		$criteria->compare('total_quantity',$this->total_quantity);
		$criteria->compare('price_before_discount',$this->price_before_discount,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('ppn',$this->ppn);
		$criteria->compare('ppn_price',$this->ppn_price,true);
		$criteria->compare('total_price',$this->total_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionPurchaseOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
