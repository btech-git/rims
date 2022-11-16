<?php

/**
 * This is the model class for table "{{transaction_return_order}}".
 *
 * The followings are the available columns in table '{{transaction_return_order}}':
 * @property integer $id
 * @property string $return_order_no
 * @property string $return_order_date
 * @property integer $receive_item_id
 * @property integer $recipient_id
 * @property integer $recipient_branch_id
 * @property string $request_type
 * @property integer $purchase_order_id
 * @property integer $supplier_id
 * @property integer $transfer_request_id
 * @property integer $branch_destination_id
 * @property string $request_date
 * @property string $estimate_arrival_date
 * @property integer $delivery_order_id
 * @property integer $consignment_in_id
 * @property string $status
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property MovementOutHeader[] $movementOutHeaders
 * @property Branch $recipientBranch
 * @property ConsignmentInHeader $consignmentIn
 * @property TransactionPurchaseOrder $purchaseOrder
 * @property Supplier $supplier
 * @property TransactionTransferRequest $transferRequest
 * @property Branch $branchDestination
 * @property TransactionDeliveryOrder $deliveryOrder
 * @property TransactionReceiveItem $receiveItem
 * @property Users $recipient
 * @property TransactionReturnOrderApproval[] $transactionReturnOrderApprovals
 * @property TransactionReturnOrderDetail[] $transactionReturnOrderDetails
 * @property TransactionDeliveryOrder $deliveryOrder
 */
class TransactionReturnOrder extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'RTO';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReturnOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $receive_item_no;
    public $supplier_name;
    public $purchase_order_no;
    public $transfer_request_no;
    public $branch_destination_name;
    public $branch_name;
    public $delivery_order_no;

    public function tableName() {
        return '{{transaction_return_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('return_order_no, return_order_date, receive_item_id, recipient_id, recipient_branch_id, request_type', 'required'),
            array('receive_item_id, recipient_id, recipient_branch_id, purchase_order_id, supplier_id, transfer_request_id, branch_destination_id, delivery_order_id, consignment_in_id', 'numerical', 'integerOnly' => true),
            array('receive_item_id, recipient_id, recipient_branch_id, purchase_order_id, supplier_id, transfer_request_id, branch_destination_id, delivery_order_id', 'numerical', 'integerOnly' => true),
            array('return_order_no, request_type', 'length', 'max' => 30),
            array('status', 'length', 'max' => 20),
            array('return_order_no', 'unique'),
            array('return_order_date, request_date, estimate_arrival_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, return_order_no, return_order_date, created_datetime, receive_item_id, recipient_id, recipient_branch_id, request_type, purchase_order_id, supplier_id, transfer_request_id, branch_destination_id, request_date, estimate_arrival_date, branch_name, receive_item_no, delivery_order_id, consignment_in_id, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'return_order_id'),
            'recipientBranch' => array(self::BELONGS_TO, 'Branch', 'recipient_branch_id'),
            'consignmentIn' => array(self::BELONGS_TO, 'ConsignmentInHeader', 'consignment_in_id'),
            'purchaseOrder' => array(self::BELONGS_TO, 'TransactionPurchaseOrder', 'purchase_order_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'transferRequest' => array(self::BELONGS_TO, 'TransactionTransferRequest', 'transfer_request_id'),
            'branchDestination' => array(self::BELONGS_TO, 'Branch', 'branch_destination_id'),
            'deliveryOrder' => array(self::BELONGS_TO, 'TransactionDeliveryOrder', 'delivery_order_id'),
            'receiveItem' => array(self::BELONGS_TO, 'TransactionReceiveItem', 'receive_item_id'),
            'recipient' => array(self::BELONGS_TO, 'Users', 'recipient_id'),
            'transactionReturnOrderApprovals' => array(self::HAS_MANY, 'TransactionReturnOrderApproval', 'return_order_id'),
            'transactionReturnOrderDetails' => array(self::HAS_MANY, 'TransactionReturnOrderDetail', 'return_order_id'),
            'user' => array(self::BELONGS_TO, 'User', 'recipient_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'return_order_no' => 'Return Order No',
            'return_order_date' => 'Return Order Date',
            'receive_item_id' => 'Receive Item',
            'recipient_id' => 'Recipient',
            'recipient_branch_id' => 'Recipient Branch',
            'request_type' => 'Request Type',
            'purchase_order_id' => 'Purchase Order',
            'supplier_id' => 'Supplier',
            'transfer_request_id' => 'Transfer Request',
            'branch_destination_id' => 'Branch Destination',
            'request_date' => 'Request Date',
            'estimate_arrival_date' => 'Estimate Arrival Date',
            'delivery_order_id' => 'Delivery Order',
            'consignment_in_id' => 'Consignment In',
            'status' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.return_order_no', $this->return_order_no, true);
        $criteria->compare('t.return_order_date', $this->return_order_date, true);
        $criteria->compare('t.receive_item_id', $this->receive_item_id);
        $criteria->compare('t.recipient_id', $this->recipient_id);
        $criteria->compare('t.recipient_branch_id', $this->recipient_branch_id);
        $criteria->compare('t.request_type', $this->request_type, true);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.transfer_request_id', $this->transfer_request_id);
        $criteria->compare('t.branch_destination_id', $this->branch_destination_id);
        $criteria->compare('t.request_date', $this->request_date, true);
        $criteria->compare('t.estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('t.delivery_order_id', $this->delivery_order_id);
        $criteria->compare('t.consignment_in_id', $this->consignment_in_id);
        $criteria->compare('t.status', $this->status, true);

        $criteria->together = 'true';
        $criteria->with = array('receiveItem');
        $criteria->compare('receiveItem.receive_item_no', $this->receive_item_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'return_order_date DESC',
                'attributes' => array(
                    'branch_name' => array(
                        'asc' => 'recipientBranch.name ASC',
                        'desc' => 'recipientBranch.name DESC',
                    ),
                    'receive_item_no' => array(
                        'asc' => 'receiveItem.receive_item_no ASC',
                        'desc' => 'receiveItem.receive_item_no DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByMovementOut() {
        $criteria = new CDbCriteria;

        $criteria->condition = " 
            t.id NOT IN (
                SELECT return_order_id
                FROM " . MovementOutHeader::model()->tableName() . " 
                WHERE return_order_id IS NOT NULL
            )
        ";

        $criteria->compare('id', $this->id);
        $criteria->compare('t.return_order_no', $this->return_order_no, true);
        $criteria->compare('t.return_order_date', $this->return_order_date, true);
        $criteria->compare('t.receive_item_id', $this->receive_item_id);
        $criteria->compare('t.recipient_id', $this->recipient_id);
        $criteria->compare('t.recipient_branch_id', $this->recipient_branch_id);
        $criteria->compare('t.request_type', $this->request_type, true);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.transfer_request_id', $this->transfer_request_id);
        $criteria->compare('t.branch_destination_id', $this->branch_destination_id);
        $criteria->compare('t.request_date', $this->request_date, true);
        $criteria->compare('t.estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('t.delivery_order_id', $this->delivery_order_id);
        $criteria->compare('t.consignment_in_id', $this->consignment_in_id);
        $criteria->compare('t.status', $this->status, true);

//        $criteria->compare('status', 'Approved');
//        $criteria->addCondition("t.return_order_date > '2021-12-31'");
//        $criteria->addInCondition('t.recipient_branch_id', Yii::app()->user->branch_ids);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 50
            ),
        ));
    }
    
    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->transactionReturnOrderDetails as $detail) {
            $total += $detail->price * $detail->qty_reject;
        }

        return $total;
    }

}
