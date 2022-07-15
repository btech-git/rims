<?php

/**
 * This is the model class for table "{{transaction_return_item}}".
 *
 * The followings are the available columns in table '{{transaction_return_item}}':
 * @property integer $id
 * @property string $return_item_no
 * @property string $return_item_date
 * @property integer $delivery_order_id
 * @property integer $recipient_id
 * @property integer $recipient_branch_id
 * @property string $request_type
 * @property integer $sent_request_id
 * @property string $request_date
 * @property string $estimate_arrival_date
 * @property integer $destination_branch
 * @property integer $sales_order_id
 * @property integer $customer_id
 * @property integer $consignment_out_id
 * @property integer $transfer_request_id
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property MovementInHeader[] $movementInHeaders
 * @property TransactionDeliveryOrder $deliveryOrder
 * @property Users $recipient
 * @property Branch $recipientBranch
 * @property TransactionSentRequest $sentRequest
 * @property Branch $destinationBranch
 * @property TransactionSalesOrder $salesOrder
 * @property Customer $customer
 * @property ConsignmentOutHeader $consignmentOut
 * @property TransactionTransferRequest $transferRequest
 * @property TransactionReturnItemDetail[] $transactionReturnItemDetails
 * @property TransactionSalesOrder $salesOrder
 * @property TransactionDeliveryOrder $deliveryOrder
 */
class TransactionReturnItem extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'RTI';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReturnItem the static model class
     */
    public $customer_name;
    public $delivery_order_no;
    public $branch_name;
    public $destination_branch_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_return_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('return_item_no, return_item_date, delivery_order_id, recipient_id, recipient_branch_id, request_type', 'required'),
            array('delivery_order_id, recipient_id, recipient_branch_id, sent_request_id, destination_branch, sales_order_id, customer_id, consignment_out_id, transfer_request_id', 'numerical', 'integerOnly' => true),
            array('return_item_no, request_type', 'length', 'max' => 30),
            array('return_item_date, request_date, estimate_arrival_date, delivery_order_no', 'safe'),
            array('status', 'length', 'max' => 20),
            array('return_item_no', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, return_item_no, return_item_date, created_datetime, delivery_order_id, recipient_id, recipient_branch_id, request_type, sent_request_id, request_date, estimate_arrival_date, destination_branch, customer_id, branch_name, status, delivery_order_no', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementInHeaders' => array(self::HAS_MANY, 'MovementInHeader', 'return_item_id'),
            'deliveryOrder' => array(self::BELONGS_TO, 'TransactionDeliveryOrder', 'delivery_order_id'),
            'recipient' => array(self::BELONGS_TO, 'Users', 'recipient_id'),
            'recipientBranch' => array(self::BELONGS_TO, 'Branch', 'recipient_branch_id'),
            'sentRequest' => array(self::BELONGS_TO, 'TransactionSentRequest', 'sent_request_id'),
            'destinationBranch' => array(self::BELONGS_TO, 'Branch', 'destination_branch'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'user' => array(self::BELONGS_TO, 'User', 'recipient_id'),
            'salesOrder' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'sales_order_id'),
            'transactionReturnItemApprovals' => array(self::HAS_MANY, 'TransactionReturnItemApproval', 'return_item_id'),
            'transactionReturnItemDetails' => array(self::HAS_MANY, 'TransactionReturnItemDetail', 'return_item_id'),
            'consignmentOut' => array(self::BELONGS_TO, 'ConsignmentOutHeader', 'consignment_out_id'),
            'transferRequest' => array(self::BELONGS_TO, 'TransactionTransferRequest', 'transfer_request_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'return_item_no' => 'Return Item No',
            'return_item_date' => 'Return Item Date',
            'delivery_order_id' => 'Delivery Order',
            'recipient_id' => 'Recipient',
            'recipient_branch_id' => 'Recipient Branch',
            'request_type' => 'Request Type',
            'sent_request_id' => 'Sent Request',
            'request_date' => 'Request Date',
            'estimate_arrival_date' => 'Estimate Arrival Date',
            'destination_branch' => 'Destination Branch',
            'sales_order_id' => 'Sales Order',
            'customer_id' => 'Customer',
            'consignment_out_id' => 'Consignment Out',
            'transfer_request_id' => 'Transfer Request',
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.return_item_no', $this->return_item_no, true);
        $criteria->compare('t.return_item_date', $this->return_item_date, true);
        $criteria->compare('t.delivery_order_id', $this->delivery_order_id);
        $criteria->compare('t.recipient_id', $this->recipient_id);
        $criteria->compare('t.recipient_branch_id', $this->recipient_branch_id);
        $criteria->compare('t.request_type', $this->request_type, true);
        $criteria->compare('t.sent_request_id', $this->sent_request_id);
        $criteria->compare('t.request_date', $this->request_date, true);
        $criteria->compare('t.estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('t.destination_branch', $this->destination_branch);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.consignment_out_id', $this->consignment_out_id);
        $criteria->compare('t.transfer_request_id', $this->transfer_request_id);
        $criteria->compare('t.status', $this->status, true);

        $criteria->together = 'true';
        $criteria->with = array('recipientBranch', 'customer', 'deliveryOrder');
        $criteria->compare('recipientBranch.name', $this->branch_name, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->compare('deliveryOrder.delivery_order_no', $this->delivery_order_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'return_item_date DESC',
                'attributes' => array(
                    'branch_name' => array(
                        'asc' => 'recipientBranch.name ASC',
                        'desc' => 'recipientBranch.name DESC',
                    ),
                    'customer_name' => array(
                        'asc' => 'customer.name ASC',
                        'desc' => 'customer.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getTotalDetail() {
        $total = 0.00;

        foreach ($this->transactionReturnItemDetails as $detail) {
            $total += $detail->price * $detail->quantity;
        }

        return $total;
    }

    public function searchByMovementIn() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.quantity_movement_left), 0) AS quantity_remaining
            FROM " . TransactionReturnItemDetail::model()->tableName() . " d
            WHERE t.id = d.return_item_id
            GROUP BY d.return_item_id
            HAVING quantity_remaining > 0
        )";

        $criteria->compare('id', $this->id);
        $criteria->compare('return_item_no', $this->return_item_no, true);
        $criteria->compare('return_item_date', $this->return_item_date, true);
        $criteria->compare('delivery_order_id', $this->delivery_order_id);
        $criteria->compare('recipient_id', $this->recipient_id);
        $criteria->compare('recipient_branch_id', $this->recipient_branch_id);
        $criteria->compare('request_type', $this->request_type, true);
        $criteria->compare('sent_request_id', $this->sent_request_id);
        $criteria->compare('request_date', $this->request_date, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('destination_branch', $this->destination_branch);
        $criteria->compare('sales_order_id', $this->sales_order_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('consignment_out_id', $this->consignment_out_id);
        $criteria->compare('transfer_request_id', $this->transfer_request_id);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'return_item_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }
}
