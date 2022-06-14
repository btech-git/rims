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
 * @property string $invoice_due_date
 * @property string $invoice_tax_number
 * @property string $invoice_sub_total
 * @property string $invoice_tax_nominal
 * @property string $invoice_grand_total
 * @property string $supplier_delivery_number
 * @property string $note
 * @property integer $movement_out_id
 * @property integer $user_id_receive
 * @property integer $user_id_invoice
 * @property string $invoice_rounding_nominal
 * @property string $invoice_grand_total_rounded
 * @property string $invoice_date_created
 * @property string $invoice_time_created
 * @property string $date_created
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
 * @property Users $userIdReceive
 * @property Users $userIdInvoice
 * @property TransactionReceiveItemDetail[] $transactionReceiveItemDetails
 * @property TransactionReturnOrder[] $transactionReturnOrders
 */
class TransactionReceiveItem extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'RCI';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReceiveItem the static model class
     */
    public static function model($className = __CLASS__) {
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

    public function tableName() {
        return '{{transaction_receive_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('receive_item_no, receive_item_date, date_created, user_id_receive', 'required'),
            array('recipient_id, recipient_branch_id, destination_branch, supplier_id, purchase_order_id, transfer_request_id, consignment_in_id, delivery_order_id, movement_out_id, user_id_receive, user_id_invoice', 'numerical', 'integerOnly' => true),
            array('receive_item_no, request_type', 'length', 'max' => 30),
            array('invoice_number, invoice_tax_number, supplier_delivery_number', 'length', 'max' => 50),
            array('invoice_sub_total, invoice_tax_nominal, invoice_grand_total, invoice_grand_total_rounded, invoice_rounding_nominal', 'length', 'max' => 18),
            array('receive_item_no', 'unique'),
            array('receive_item_date, arrival_date, request_date, estimate_arrival_date, invoice_date, invoice_due_date, purchase_order_no, transfer_request_no, delivery_order_no, consignment_in_no, movement_out_no, note, invoice_date_created, invoice_time_created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, receive_item_no, receive_item_date, arrival_date, date_created, recipient_id, recipient_branch_id, request_type, request_date, estimate_arrival_date, destination_branch, supplier_id, purchase_order_id, transfer_request_id, consignment_in_id,branch_name, delivery_order_id, supplier_name,invoice_number, invoice_date, movement_out_id, transfer_request_no, delivery_order_no, consignment_in_no, movement_out_no, invoice_tax_number, invoice_sub_total, invoice_tax_nominal, invoice_grand_total, note, supplier_delivery_number, invoice_grand_total_rounded, invoice_rounding_nominal, user_id_receive, user_id_invoice, invoice_date_created, invoice_time_created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
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
            'userIdReceive' => array(self::BELONGS_TO, 'Users', 'user_id_receive'),
            'userIdInvoice' => array(self::BELONGS_TO, 'Users', 'user_id_invoice'),
            'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'receive_item_id'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'receive_item_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
            'invoice_due_date' => 'Jatuh Tempo',
            'invoice_tax_number' => 'Faktur Pajak',
            'invoice_sub_total' => 'Sub Total',
            'invoice_tax_nominal' => 'PPn',
            'invoice_grand_total' => 'Grand Total',
            'movement_out_id' => 'Movement Out',
            'note' => 'Catatan',
            'supplier_delivery_number' => 'SJ #',
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
        $criteria->compare('t.receive_item_no', $this->receive_item_no, true);
        $criteria->compare('t.receive_item_date', $this->receive_item_date, true);
        $criteria->compare('t.arrival_date', $this->arrival_date, true);
        $criteria->compare('t.recipient_id', $this->recipient_id);
        $criteria->compare('t.recipient_branch_id', $this->recipient_branch_id);
        $criteria->compare('t.request_type', $this->request_type, true);
        $criteria->compare('t.request_date', $this->request_date, true);
        $criteria->compare('t.estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('t.destination_branch', $this->destination_branch);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.transfer_request_id', $this->transfer_request_id);
        $criteria->compare('t.consignment_in_id', $this->consignment_in_id);
        $criteria->compare('t.delivery_order_id', $this->delivery_order_id);
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.invoice_date', $this->invoice_date, true);
        $criteria->compare('t.invoice_due_date', $this->invoice_due_date, true);
        $criteria->compare('t.invoice_tax_number', $this->invoice_tax_number, true);
        $criteria->compare('t.supplier_delivery_number', $this->supplier_delivery_number, true);
        $criteria->compare('t.movement_out_id', $this->movement_out_id);
        $criteria->compare('t.note', $this->note);
        $criteria->compare('t.user_id_receive', $this->user_id_receive);
        $criteria->compare('t.user_id_invoice', $this->user_id_invoice);
        $criteria->compare('t.invoice_grand_total_rounded', $this->invoice_grand_total_rounded);
        $criteria->compare('t.invoice_rounding_nominal', $this->invoice_rounding_nominal);

        $criteria->together = 'true';
        $criteria->with = array('recipientBranch', 'supplier', 'purchaseOrder', 'transferRequest', 'consignmentIn', 'deliveryOrder', 'movementOut');
        $criteria->compare('recipientBranch.name', $this->branch_name, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('transferRequest.transfer_request_no', $this->transfer_request_no, true);
        $criteria->compare('consignmentIn.consignment_in_no', $this->consignment_in_no, true);
        $criteria->compare('deliveryOrder.delivery_order_no', $this->delivery_order_no, true);
        $criteria->compare('movementOut.movement_out_no', $this->movement_out_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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

    public function searchByMovementIn() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.quantity_movement_left), 0) AS quantity_remaining
            FROM " . TransactionReceiveItemDetail::model()->tableName() . " d
            WHERE t.id = d.receive_item_id
            GROUP BY d.receive_item_id
            HAVING quantity_remaining > 0
        )";

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.receive_item_no', $this->receive_item_no, true);
        $criteria->compare('t.receive_item_date', $this->receive_item_date, true);
        $criteria->compare('t.arrival_date', $this->arrival_date, true);
        $criteria->compare('t.recipient_id', $this->recipient_id);
        $criteria->compare('t.recipient_branch_id', $this->recipient_branch_id);
        $criteria->compare('t.request_type', $this->request_type, true);
        $criteria->compare('t.request_date', $this->request_date, true);
        $criteria->compare('t.estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('t.destination_branch', $this->destination_branch);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.transfer_request_id', $this->transfer_request_id);
        $criteria->compare('t.consignment_in_id', $this->consignment_in_id);
        $criteria->compare('t.delivery_order_id', $this->delivery_order_id);
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.invoice_date', $this->invoice_date, true);
        $criteria->compare('t.invoice_due_date', $this->invoice_due_date, true);
        $criteria->compare('t.invoice_tax_number', $this->invoice_tax_number, true);
        $criteria->compare('t.supplier_delivery_number', $this->supplier_delivery_number, true);
        $criteria->compare('t.movement_out_id', $this->movement_out_id);
        $criteria->compare('t.note', $this->note);
        $criteria->compare('t.user_id_receive', $this->user_id_receive);
        $criteria->compare('t.user_id_invoice', $this->user_id_invoice);
        $criteria->compare('t.invoice_grand_total_rounded', $this->invoice_grand_total_rounded);
        $criteria->compare('t.invoice_rounding_nominal', $this->invoice_rounding_nominal);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'receive_item_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $total += $detail->totalPrice;
        }

        return $total;
    }

    public function getTaxNominal() {
        return ((int) $this->purchaseOrder->ppn === 1) ? $this->subTotal * .1 : 0.00;
    }

    public function getGrandTotal() {
        return $this->subTotal; // + $this->taxNominal;
    }

    public function getGrandTotalAfterRounding() {
        return $this->grandTotal + $this->invoice_rounding_nominal;
    }

    public function searchForPaymentOut() {
        $criteria = new CDbCriteria;

        $criteria->condition = " 
            t.id NOT IN (
                SELECT receive_item_id
                FROM " . PayOutDetail::model()->tableName() . " 
            ) AND t.purchase_order_id IS NOT NULL
        ";
        
        $criteria->compare('id', $this->id);
        $criteria->compare('receive_item_no', $this->receive_item_no, true);
        $criteria->compare('receive_item_date', $this->receive_item_date, true);
        $criteria->compare('arrival_date', $this->arrival_date, true);
        $criteria->compare('recipient_id', $this->recipient_id);
        $criteria->compare('request_type', $this->request_type, true);
        $criteria->compare('request_date', $this->request_date, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('destination_branch', $this->destination_branch);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('transfer_request_id', $this->transfer_request_id);
        $criteria->compare('consignment_in_id', $this->consignment_in_id);
        $criteria->compare('delivery_order_id', $this->delivery_order_id);
        $criteria->compare('invoice_number', $this->invoice_number, true);
        $criteria->compare('invoice_date', $this->invoice_date, true);
        $criteria->compare('invoice_due_date', $this->invoice_due_date, true);
        $criteria->compare('invoice_grand_total', $this->invoice_grand_total, true);
        $criteria->compare('supplier_delivery_number', $this->supplier_delivery_number, true);
        $criteria->compare('movement_out_id', $this->movement_out_id);
        $criteria->compare('user_id_receive', $this->user_id_receive);
        $criteria->compare('user_id_invoice', $this->user_id_invoice);

//        $criteria->addCondition("t.recipient_branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        $criteria->together = 'true';
        $criteria->with = array('recipientBranch', 'supplier', 'purchaseOrder', 'transferRequest', 'consignmentIn', 'deliveryOrder', 'movementOut');
        $criteria->compare('recipientBranch.name', $this->branch_name, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('transferRequest.transfer_request_no', $this->transfer_request_no, true);
        $criteria->compare('consignmentIn.consignment_in_no', $this->consignment_in_no, true);
        $criteria->compare('deliveryOrder.delivery_order_no', $this->delivery_order_no, true);
        $criteria->compare('movementOut.movement_out_no', $this->movement_out_no, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 50
            ),
            'sort' => array(
                'defaultOrder' => 't.invoice_date DESC',
            ),
        ));
    }
    
    public function getDateTimeCreated() {
        return Yii::app()->dateFormatter->format("d MMM yyyy", $this->invoice_date_created) . ' ' . $this->invoice_time_created;
    }
}