<?php

/**
 * This is the model class for table "{{transaction_purchase_order_detail_request}}".
 *
 * The followings are the available columns in table '{{transaction_purchase_order_detail_request}}':
 * @property integer $id
 * @property integer $purchase_order_detail_id
 * @property integer $purchase_request_id
 * @property integer $purchase_request_detail_id
 * @property integer $purchase_request_quantity
 * @property string $estimate_date_arrival
 * @property integer $purchase_request_branch_id
 * @property integer $purchase_order_quantity
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property TransactionPurchaseOrderDetail $purchaseOrderDetail
 * @property TransactionRequestOrder $purchaseRequest
 * @property TransactionRequestOrderDetail $purchaseRequestDetail
 * @property Branch $purchaseRequestBranch
 */
class TransactionPurchaseOrderDetailRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransactionPurchaseOrderDetailRequest the static model class
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
		return '{{transaction_purchase_order_detail_request}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_detail_id', 'required'),
			array('purchase_order_detail_id, purchase_request_id, purchase_request_detail_id, purchase_request_quantity, purchase_request_branch_id, purchase_order_quantity', 'numerical', 'integerOnly'=>true),
			array('estimate_date_arrival, notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, purchase_order_detail_id, purchase_request_id, purchase_request_detail_id, purchase_request_quantity, estimate_date_arrival, purchase_request_branch_id, purchase_order_quantity, notes', 'safe', 'on'=>'search'),
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
			'purchaseOrderDetail' => array(self::BELONGS_TO, 'TransactionPurchaseOrderDetail', 'purchase_order_detail_id'),
			'purchaseRequest' => array(self::BELONGS_TO, 'TransactionRequestOrder', 'purchase_request_id'),
			'purchaseRequestDetail' => array(self::BELONGS_TO, 'TransactionRequestOrderDetail', 'purchase_request_detail_id'),
			'purchaseRequestBranch' => array(self::BELONGS_TO, 'Branch', 'purchase_request_branch_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'purchase_order_detail_id' => 'Purchase Order Detail',
			'purchase_request_id' => 'Purchase Request',
			'purchase_request_detail_id' => 'Purchase Request Detail',
			'purchase_request_quantity' => 'Purchase Request Quantity',
			'estimate_date_arrival' => 'Estimate Date Arrival',
			'purchase_request_branch_id' => 'Purchase Request Branch',
			'purchase_order_quantity' => 'Purchase Order Quantity',
			'notes' => 'Notes',
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
		$criteria->compare('purchase_order_detail_id',$this->purchase_order_detail_id);
		$criteria->compare('purchase_request_id',$this->purchase_request_id);
		$criteria->compare('purchase_request_detail_id',$this->purchase_request_detail_id);
		$criteria->compare('purchase_request_quantity',$this->purchase_request_quantity);
		$criteria->compare('estimate_date_arrival',$this->estimate_date_arrival,true);
		$criteria->compare('purchase_request_branch_id',$this->purchase_request_branch_id);
		$criteria->compare('purchase_order_quantity',$this->purchase_order_quantity);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}