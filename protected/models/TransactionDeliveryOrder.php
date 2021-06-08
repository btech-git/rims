<?php

/**
 * This is the model class for table "{{transaction_delivery_order}}".
 *
 * The followings are the available columns in table '{{transaction_delivery_order}}':
 * @property integer $id
 * @property string $delivery_order_no
 * @property string $delivery_date
 * @property string $posting_date
 * @property integer $sender_id
 * @property integer $sender_branch_id
 * @property string $request_type
 * @property integer $sales_order_id
 * @property integer $sent_request_id
 * @property integer $consignment_out_id
 * @property string $request_date
 * @property string $estimate_arrival_date
 * @property integer $destination_branch
 * @property integer $customer_id
 * @property integer $transfer_request_id
 *
 * The followings are the available model relations:
 * @property MovementOutHeader[] $movementOutHeaders
 * @property TransactionSentRequest $sentRequest
 * @property Customer $customer
 * @property TransactionSalesOrder $salesOrder
 * @property Branch $destinationBranch
 * @property ConsignmentOutHeader $consignmentOut
 * @property TransactionTransferRequest $transferRequest
 * @property Branch $senderBranch
 * @property Users $sender
 * @property TransactionDeliveryOrderDetail[] $transactionDeliveryOrderDetails
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property TransactionReturnOrder[] $transactionReturnOrders
 */
class TransactionDeliveryOrder extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'DO';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionDeliveryOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public $branch_name;
    public $customer_name;
    public $sales_order_no;
    public $consignment_out_no;
    public $sent_request_no;
    public $transfer_request_no;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_delivery_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('delivery_order_no, delivery_date, posting_date, sender_id, sender_branch_id', 'required'),
            array('sender_id, sender_branch_id, sales_order_id, sent_request_id, consignment_out_id, destination_branch, customer_id, transfer_request_id', 'numerical', 'integerOnly' => true),
            array('delivery_order_no, request_type', 'length', 'max' => 30),
            array('delivery_order_no', 'unique'),
            array('delivery_date, posting_date, request_date, estimate_arrival_date, sent_request_no, consignment_out_no, transfer_request_no', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, delivery_order_no, delivery_date, posting_date, sender_id, sender_branch_id, request_type, sales_order_id, sent_request_id, consignment_out_id, request_date, estimate_arrival_date, destination_branch, customer_id, branch_name,customer_name,sales_order_no, transfer_request_detail_id, sent_request_no, consignment_out_no, transfer_request_no', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'delivery_order_id'),
            'sentRequest' => array(self::BELONGS_TO, 'TransactionSentRequest', 'sent_request_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'salesOrder' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'sales_order_id'),
            'destinationBranch' => array(self::BELONGS_TO, 'Branch', 'destination_branch'),
            'consignmentOut' => array(self::BELONGS_TO, 'ConsignmentOutHeader', 'consignment_out_id'),
            'user' => array(self::BELONGS_TO, 'User', 'sender_id'),
            'transferRequest' => array(self::BELONGS_TO, 'TransactionTransferRequest', 'transfer_request_id'),
            'senderBranch' => array(self::BELONGS_TO, 'Branch', 'sender_branch_id'),
            'sender' => array(self::BELONGS_TO, 'Users', 'sender_id'),
            'transactionDeliveryOrderDetails' => array(self::HAS_MANY, 'TransactionDeliveryOrderDetail', 'delivery_order_id'),
            'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'delivery_order_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'delivery_order_id'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'delivery_order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'delivery_order_no' => 'Delivery Order No',
            'delivery_date' => 'Delivery Date',
            'posting_date' => 'Posting Date',
            'sender_id' => 'Sender',
            'sender_branch_id' => 'Sender Branch',
            'request_type' => 'Request Type',
            'sales_order_id' => 'Sales Order',
            'sent_request_id' => 'Sent Request',
            'consignment_out_id' => 'Consignment Out',
            'request_date' => 'Request Date',
            'estimate_arrival_date' => 'Estimate Arrival Date',
            'destination_branch' => 'Destination Branch',
            'customer_id' => 'Customer',
            'transfer_request_id' => 'Transfer Request',
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
        $criteria->compare('t.delivery_order_no', $this->delivery_order_no, true);
        $criteria->compare('t.delivery_date', $this->delivery_date, true);
        $criteria->compare('t.posting_date', $this->posting_date, true);
        $criteria->compare('t.sender_id', $this->sender_id);
        $criteria->compare('t.sender_branch_id', $this->sender_branch_id);
        $criteria->compare('t.request_type', $this->request_type, true);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.sent_request_id', $this->sent_request_id);
        $criteria->compare('t.consignment_out_id', $this->consignment_out_id);
        $criteria->compare('t.request_date', $this->request_date, true);
        $criteria->compare('t.estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('t.destination_branch', $this->destination_branch);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.transfer_request_id', $this->transfer_request_id);

        $criteria->together = 'true';
        $criteria->with = array('senderBranch', 'customer', 'salesOrder', 'sentRequest', 'consignmentOut', 'transferRequest');
        $criteria->compare('senderBranch.name', $this->branch_name, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->compare('salesOrder.sales_order_no', $this->sales_order_no, true);
        $criteria->compare('sentRequest.sent_request_no', $this->sent_request_no, true);
        $criteria->compare('consignmentOut.consignment_out_no', $this->consignment_out_no, true);
        $criteria->compare('transferRequest.transfer_request_no', $this->transfer_request_no, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.delivery_date DESC',
                'attributes' => array(
                    'branch_name' => array(
                        'asc' => 'senderBranch.name ASC',
                        'desc' => 'senderBranch.name DESC',
                    ),
                    'customer_name' => array(
                        'asc' => 'customer.name ASC',
                        'desc' => 'customer.name DESC',
                    ),
                    'sales_order_no' => array(
                        'asc' => 'salesOrder.sales_order_no ASC',
                        'desc' => 'salesOrder.sales_order_no DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getTotalQuantityDelivered() {
        $total = 0;

        foreach ($this->transactionDeliveryOrderDetails as $detail)
            $total += $detail->quantity_delivery;

        return $total;
    }

    public function searchByReceive() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
                SELECT COALESCE(SUM(d.quantity_receive_left), 0) AS quantity_remaining
                FROM " . TransactionDeliveryOrderDetail::model()->tableName() . " d
                WHERE t.id = d.delivery_order_id
                GROUP BY d.delivery_order_id
                HAVING quantity_remaining > 0
        ) AND (t.transfer_request_id IS NOT NULL AND t.request_type = 'Transfer Request') OR (t.sent_request_id IS NOT NULL AND t.request_type = 'Sent Request')";

        $criteria->compare('id', $this->id);
        $criteria->compare('t.delivery_date', $this->delivery_date, true);
        $criteria->compare('t.posting_date', $this->posting_date, true);
        $criteria->compare('t.sender_id', $this->sender_id);
        $criteria->compare('t.sender_branch_id', $this->sender_branch_id);
        $criteria->compare('t.destination_branch', $this->destination_branch);
        $criteria->compare('t.delivery_order_no', $this->delivery_order_no . '%', true, 'AND', false);
        $criteria->compare('t.request_type', $this->request_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'delivery_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByMovementOut() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.quantity_movement_left), 0) AS quantity_remaining
            FROM " . TransactionDeliveryOrderDetail::model()->tableName() . " d
            WHERE t.id = d.delivery_order_id
            GROUP BY d.delivery_order_id
            HAVING quantity_remaining > 0
        )";

        $criteria->compare('id', $this->id);
        $criteria->compare('t.delivery_date', $this->delivery_date, true);
        $criteria->compare('t.posting_date', $this->posting_date, true);
        $criteria->compare('t.sender_id', $this->sender_id);
        $criteria->compare('t.sender_branch_id', $this->sender_branch_id);
        $criteria->compare('t.destination_branch', $this->destination_branch);
        $criteria->compare('t.delivery_order_no', $this->delivery_order_no . '%', true, 'AND', false);
        $criteria->compare('t.request_type', $this->request_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'delivery_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }
}
