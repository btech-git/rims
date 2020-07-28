<?php

/**
 * This is the model class for table "{{transaction_receive_item}}".
 *
 * The followings are the available columns in table '{{transaction_receive_item}}':
 * @property integer $id
 * @property string $receive_item_no
 * @property string $receive_item_date
 * @property string $arrival_date
 * @property integer $recipient_id
 * @property integer $recipient_branch_id
 * @property string $request_type
 * @property string $request_date
 * @property string $estimate_arrival_date
 * @property integer $destination_branch
 * @property integer $supplier_id
 * @property integer $purchase_order_id
 * @property integer $transfer_request_id
 * @property integer $consignment_in_id
 * @property integer $delivery_order_id
 * @property string $invoice_number
 * @property string $invoice_date
 * @property integer $movement_out_id
 *
 * The followings are the available model relations:
 * @property MovementInHeader[] $movementInHeaders
 * @property Branch $recipientBranch
 * @property Branch $destinationBranch
 * @property Supplier $supplier
 * @property TransactionPurchaseOrder $purchaseOrder
 * @property TransactionTransferRequest $transferRequest
 * @property ConsignmentInHeader $consignmentIn
 * @property TransactionDeliveryOrder $deliveryOrder
 * @property MovementOutHeader $movementOut
 * @property TransactionReceiveItemDetail[] $transactionReceiveItemDetails
 * @property TransactionReturnOrder[] $transactionReturnOrders
 */
class TransactionReceiveItem extends MonthlyTransactionActiveRecord
{
    const CONSTANT = 'RCI';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransactionReceiveItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public $purchase_order_no;
	public $transfer_request_no;
	public $delivery_order_no;
	public $consignment_in_no;
	public $movement_out_no;
	public $supplier_name;
	public $destination_branch_name;
	public $branch_name;
	public $coa_id;
	public $coa_name;
	public $payment_type;
    
	public function tableName()
	{
		return '{{transaction_receive_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('receive_item_no, receive_item_date', 'required'),
			array('recipient_id, recipient_branch_id, destination_branch, supplier_id, purchase_order_id, transfer_request_id, consignment_in_id, delivery_order_id, movement_out_id', 'numerical', 'integerOnly'=>true),
			array('receive_item_no, request_type', 'length', 'max'=>30),
			array('invoice_number', 'length', 'max'=>50),
			array('receive_item_date, arrival_date, request_date, estimate_arrival_date, invoice_date, purchase_order_no, transfer_request_no, delivery_order_no, consignment_in_no, movement_out_no', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, receive_item_no, receive_item_date, arrival_date, recipient_id, recipient_branch_id, request_type, request_date, estimate_arrival_date, destination_branch, supplier_id, purchase_order_id, transfer_request_id, consignment_in_id,branch_name, delivery_order_id, supplier_name,invoice_number, invoice_date, movement_out_id, transfer_request_no, delivery_order_no, consignment_in_no, movement_out_no', 'safe', 'on'=>'search'),
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
			'movementInHeaders' => array(self::HAS_MANY, 'MovementInHeader', 'receive_item_id'),
			'recipientBranch' => array(self::BELONGS_TO, 'Branch', 'recipient_branch_id'),
			'destinationBranch' => array(self::BELONGS_TO, 'Branch', 'destination_branch'),
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'user' => array(self::BELONGS_TO, 'User', 'recipient_id'),
			'purchaseOrder' => array(self::BELONGS_TO, 'TransactionPurchaseOrder', 'purchase_order_id'),
			'transferRequest' => array(self::BELONGS_TO, 'TransactionTransferRequest', 'transfer_request_id'),
			'consignmentIn' => array(self::BELONGS_TO, 'ConsignmentInHeader', 'consignment_in_id'),
			'deliveryOrder' => array(self::BELONGS_TO, 'TransactionDeliveryOrder', 'delivery_order_id'),
			'movementOut' => array(self::BELONGS_TO, 'MovementOutHeader', 'movement_out_id'),
			'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'receive_item_id'),
			'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'receive_item_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'receive_item_no' => 'Receive Item No',
			'receive_item_date' => 'Receive Item Date',
			'arrival_date' => 'Arrival Date',
			'recipient_id' => 'Recipient',
			'recipient_branch_id' => 'Recipient Branch',
			'request_type' => 'Request Type',
			'request_date' => 'Request Date',
			'estimate_arrival_date' => 'Estimate Arrival Date',
			'destination_branch' => 'Destination Branch',
			'supplier_id' => 'Supplier',
			'purchase_order_id' => 'Purchase Order',
			'transfer_request_id' => 'Transfer Request',
			'consignment_in_id' => 'Consignment In',
			'delivery_order_id' => 'Delivery Order',
			'invoice_number' => 'Invoice Number',
			'invoice_date' => 'Invoice Date',
			'movement_out_id' => 'Movement Out',
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
		$criteria->compare('receive_item_no',$this->receive_item_no,true);
		$criteria->compare('receive_item_date',$this->receive_item_date,true);
		$criteria->compare('arrival_date',$this->arrival_date,true);
		$criteria->compare('recipient_id',$this->recipient_id);
		$criteria->compare('recipient_branch_id',$this->recipient_branch_id);
		$criteria->compare('request_type',$this->request_type,true);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('estimate_arrival_date',$this->estimate_arrival_date,true);
		$criteria->compare('destination_branch',$this->destination_branch);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('transfer_request_id',$this->transfer_request_id);
		$criteria->compare('consignment_in_id',$this->consignment_in_id);
		$criteria->compare('delivery_order_id',$this->delivery_order_id);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('movement_out_id',$this->movement_out_id);

		$criteria->together = 'true';
		$criteria->with = array('recipientBranch','supplier', 'purchaseOrder', 'transferRequest', 'consignmentIn', 'deliveryOrder', 'movementOut');
		$criteria->compare('recipientBranch.name', $this->branch_name, true);
		$criteria->compare('supplier.name', $this->supplier_name, true);
		$criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_no, true);
		$criteria->compare('transferRequest.transfer_request_no', $this->transfer_request_no, true);
		$criteria->compare('consignmentIn.consignment_in_no', $this->consignment_in_no, true);
		$criteria->compare('deliveryOrder.delivery_order_no', $this->delivery_order_no, true);
		$criteria->compare('movementOut.movement_out_no', $this->movement_out_no, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
                'defaultOrder' => 'arrival_date DESC',
                'attributes' => array(
	                'branch_name' => array(
	                    'asc' => 'recipientBranch.name ASC',
	                    'desc' => 'recipientBranch.name DESC',
	                ),
	                'supplier_name' => array(
	                    'asc' => 'supplier.name ASC',
	                    'desc' => 'supplier.name DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),

		));
	}
    
	public function searchByMovementIn()
	{
		//search purchase header which purchased quantity is not fully received yet
		$criteria = new CDbCriteria;
		
		$criteria->condition = "EXISTS (
			SELECT COALESCE(SUM(d.quantity_movement_left), 0) AS quantity_remaining
			FROM " . TransactionReceiveItemDetail::model()->tableName() . " d
			WHERE t.id = d.receive_item_id
			GROUP BY d.receive_item_id
			HAVING quantity_remaining > 0
		)";
		
		$criteria->compare('id',$this->id);
		$criteria->compare('receive_item_no',$this->receive_item_no,true);
		$criteria->compare('receive_item_date',$this->receive_item_date,true);
		$criteria->compare('arrival_date',$this->arrival_date,true);
		$criteria->compare('recipient_id',$this->recipient_id);
		$criteria->compare('recipient_branch_id',$this->recipient_branch_id);
		$criteria->compare('request_type',$this->request_type,true);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('estimate_arrival_date',$this->estimate_arrival_date,true);
		$criteria->compare('destination_branch',$this->destination_branch);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('transfer_request_id',$this->transfer_request_id);
		$criteria->compare('consignment_in_id',$this->consignment_in_id);
		$criteria->compare('delivery_order_id',$this->delivery_order_id);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('invoice_date',$this->invoice_date,true);
		$criteria->compare('movement_out_id',$this->movement_out_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
    	        'defaultOrder' => 'receive_item_date DESC',
    	    ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),
		));
	}
}