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
 * @property string $created_datetime
 * @property integer $movement_type
 * @property string $cancelled_datetime
 * @property integer $user_id_cancelled
 * @property string $updated_datetime
 * @property integer $user_id_updated
 * @property integer $user_id_approval_invoice
 * @property integer $is_approved_invoice
 * @property string $date_approval_invoice
 * @property string $time_approval_invoice
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
 * @property PayOutDetail[] $payOutDetails
 * @property UserIdCancelled $userIdCancelled
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApprovalInvoice $userIdApprovalInvoice
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
            array('receive_item_no, receive_item_date, user_id_receive, recipient_branch_id, movement_type', 'required'),
            array('recipient_id, recipient_branch_id, destination_branch, supplier_id, movement_type, purchase_order_id, transfer_request_id, consignment_in_id, delivery_order_id, movement_out_id, user_id_receive, user_id_invoice, user_id_cancelled, user_id_updated, is_approved_invoice, user_id_approval_invoice', 'numerical', 'integerOnly' => true),
            array('receive_item_no, request_type', 'length', 'max' => 30),
            array('invoice_number, invoice_tax_number, supplier_delivery_number', 'length', 'max' => 50),
            array('invoice_sub_total, invoice_tax_nominal, invoice_grand_total, invoice_grand_total_rounded, invoice_rounding_nominal', 'length', 'max' => 18),
            array('receive_item_no', 'unique'),
            array('receive_item_date, arrival_date, request_date, estimate_arrival_date, invoice_date, invoice_due_date, purchase_order_no, transfer_request_no, delivery_order_no, consignment_in_no, movement_out_no, note, invoice_date_created, invoice_time_created, updated_datetime, cancelled_datetime, date_approval_invoice, time_approval_invoice', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, receive_item_no, receive_item_date, arrival_date, created_datetime, movement_type, recipient_id, recipient_branch_id, request_type, request_date, estimate_arrival_date, destination_branch, supplier_id, purchase_order_id, transfer_request_id, consignment_in_id,branch_name, delivery_order_id, supplier_name,invoice_number, invoice_date, movement_out_id, transfer_request_no, delivery_order_no, consignment_in_no, movement_out_no, invoice_tax_number, invoice_sub_total, invoice_tax_nominal, invoice_grand_total, note, supplier_delivery_number, invoice_grand_total_rounded, invoice_rounding_nominal, user_id_receive, user_id_invoice, invoice_date_created, invoice_time_created, cancelled_datetime, user_id_cancelled, updated_datetime, user_id_updated, is_approved_invoice, user_id_approval_invoice, date_approval_invoice, time_approval_invoice', 'safe', 'on' => 'search'),
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
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdApprovalInvoice' => array(self::BELONGS_TO, 'Users', 'user_id_approval_invoice'),
            'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'receive_item_id'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'receive_item_id'),
            'payOutDetails' => array(self::HAS_MANY, 'PayOutDetail', 'receive_item_id'),
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
            'movement_type' => 'Movement Type',
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
        $criteria->compare('t.movement_type', $this->movement_type);

        $criteria->together = 'true';
        $criteria->with = array('recipientBranch', 'supplier', 'deliveryOrder', 'purchaseOrder', 'consignmentIn', 'movementOut');
        $criteria->compare('recipientBranch.name', $this->branch_name, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_no, true);
//        $criteria->compare('transferRequest.transfer_request_no', $this->transfer_request_no, true);
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
                'pageSize' => 100,
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
        ) AND t.receive_item_date > '2023-12-31' AND t.cancelled_datetime is null";

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
                'defaultOrder' => 'receive_item_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByReport() {
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
        $criteria->compare('t.movement_type', $this->movement_type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invoice_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));
    }

    public function getTotalRetailPrice() {
        $total = 0.00;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $total += $detail->purchaseRetailPrice;
        }

        return $total;
    }

    public function getTotalPurchaseDiscount() {
        $total = 0.00;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $total += $detail->purchaseDiscount;
        }

        return $total;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $total += $detail->totalPrice;
        }

        return $total; //round($total / (1 + ($this->purchaseOrder->tax_percentage /100)), 2);
    }

    public function getTaxNominal() {
        return round($this->subTotal * $this->purchaseOrder->tax_percentage /100, 2);
    }

    public function getGrandTotal() {
        return $this->subTotal + $this->taxNominal;
    }

    public function getGrandTotalAfterRounding() {
        return $this->grandTotal + $this->invoice_rounding_nominal;
    }

    public function searchForPaymentOut() {
        $criteria = new CDbCriteria;

//        $criteria->condition = " 
//            t.id NOT IN (
//                SELECT p.receive_item_id
//                FROM " . PayOutDetail::model()->tableName() . " p
//                LEFT OUTER JOIN " . PaymentOutApproval::model()->tableName() . " a ON p.payment_out_id = a.payment_out_id
//                WHERE p.receive_item_id IS NOT null AND a.approval_type = 'Approved'
//            ) AND t.invoice_number IS NOT NULL AND t.purchase_order_id IS NOT NULL AND t.receive_item_date > '2021-12-31'
//        ";
        
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

        $criteria->together = 'true';
        $criteria->with = array('recipientBranch', 'supplier', 'purchaseOrder', 'transferRequest', 'consignmentIn', 'deliveryOrder', 'movementOut');
        $criteria->compare('recipientBranch.name', $this->branch_name, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('transferRequest.transfer_request_no', $this->transfer_request_no, true);
        $criteria->compare('consignmentIn.consignment_in_no', $this->consignment_in_no, true);
        $criteria->compare('deliveryOrder.delivery_order_no', $this->delivery_order_no, true);
        $criteria->compare('movementOut.movement_out_no', $this->movement_out_no, true);

        $criteria->addCondition("purchaseOrder.payment_left > 100.00 AND t.cancelled_datetime IS null AND t.invoice_number IS NOT null AND t.receive_item_date > '2022-12-31'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 30
            ),
            'sort' => array(
                'defaultOrder' => 't.invoice_date DESC',
            ),
        ));
    }
    
    public function getDateTimeCreated() {
        return Yii::app()->dateFormatter->format("d MMM yyyy", $this->invoice_date_created) . ' ' . $this->invoice_time_created;
    }
    
    public static function totalPayables() {
        
        $sql = "SELECT SUM(r.invoice_grand_total) AS remaining
                FROM " . TransactionReceiveItem::model()->tableName() . " r 
                INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " p ON p.id = r.purchase_order_id
                WHERE p.payment_left > 100 AND r.invoice_number IS NOT NULL AND r.receive_item_date > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'";
                
        $value = Yii::app()->db->createCommand($sql)->queryScalar(array());

        return ($value === false) ? 0 : $value;
    }

    public static function pendingJournal() {
        $sql = "SELECT p.id, p.receive_item_no, p.receive_item_date, s.name as supplier_name, b.name as branch_name, p.request_type
                FROM " . TransactionReceiveItem::model()->tableName() . " p
                INNER JOIN " . Supplier::model()->tableName() . " s ON s.id = p.supplier_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = p.recipient_branch_id
                WHERE p.receive_item_date > '2023-12-31' AND p.receive_item_no NOT IN (
                    SELECT kode_transaksi 
                    FROM " . JurnalUmum::model()->tableName() . "
                ) AND p.user_id_cancelled is null
                ORDER BY p.receive_item_date DESC";

        return $sql;
    }
    
    public function getApprovalStatus() {
        return $this->is_approved_invoice == 0 ? 'Not Approved' : 'Approved';
    }
    
    public static function getYearlyPurchaseTaxSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, recipient_branch_id, MIN(b.name) AS branch_name, SUM(invoice_grand_total) AS total_price
                FROM " . TransactionReceiveItem::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.recipient_branch_id
                WHERE YEAR(invoice_date) = :year AND i.user_id_cancelled IS null AND i.invoice_tax_nominal > 0
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), recipient_branch_id
                ORDER BY year_month_value ASC, recipient_branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getPurchaseInvoiceTaxYearlyReport($year, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.recipient_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, COUNT(DISTINCT(i.purchase_order_id)) AS quantity_order, COUNT(*) AS quantity_invoice, SUM(i.invoice_sub_total) AS sub_total, SUM(i.invoice_tax_nominal) AS total_tax, SUM(i.invoice_grand_total) AS total_price 
                FROM " . TransactionReceiveItem::model()->tableName() . " i 
                WHERE YEAR(i.invoice_date) = :year AND i.user_id_cancelled IS NULL AND i.invoice_tax_nominal > 0 AND i.invoice_number <> ''" . $branchConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date)
                ORDER BY year_month_value ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getPurchaseInvoiceSupplierTaxMonthlyReport($year, $month, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':month' => $month,
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.recipient_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, i.supplier_id, MAX(c.name) AS supplier_name, COUNT(DISTINCT(i.purchase_order_id)) AS quantity_order, COUNT(*) AS quantity_invoice, SUM(i.invoice_sub_total) AS sub_total, SUM(i.invoice_tax_nominal) AS total_tax, SUM(i.invoice_grand_total) AS total_price 
                FROM " . TransactionReceiveItem::model()->tableName() . " i 
                INNER JOIN " . Supplier::model()->tableName() . " c ON c.id = i.supplier_id
                WHERE YEAR(i.invoice_date) = :year AND MONTH(i.invoice_date) = :month AND i.user_id_cancelled IS NULL AND i.invoice_tax_nominal > 0" . $branchConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), i.supplier_id
                ORDER BY year_month_value ASC, c.name ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getPurchaseInvoiceNonTaxMonthlyReport($year, $month, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':month' => $month,
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.recipient_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, i.supplier_id, MAX(c.name) AS supplier_name, COUNT(DISTINCT(i.purchase_order_id)) AS quantity_order, 
                COUNT(*) AS quantity_invoice, SUM(i.invoice_sub_total) AS sub_total, SUM(i.invoice_tax_nominal) AS total_tax, SUM(i.invoice_grand_total) AS total_price 
                FROM " . TransactionReceiveItem::model()->tableName() . " i 
                INNER JOIN " . Supplier::model()->tableName() . " c ON c.id = i.supplier_id
                WHERE YEAR(i.invoice_date) = :year AND MONTH(i.invoice_date) = :month AND i.user_id_cancelled IS NULL AND i.invoice_tax_nominal = 0" . $branchConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), i.supplier_id
                ORDER BY year_month_value ASC, c.name ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}