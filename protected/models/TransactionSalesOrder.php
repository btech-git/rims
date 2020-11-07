<?php

/**
 * This is the model class for table "{{transaction_sales_order}}".
 *
 * The followings are the available columns in table '{{transaction_sales_order}}':
 * @property integer $id
 * @property string $sale_order_no
 * @property string $sale_order_date
 * @property string $status_document
 * @property string $payment_type
 * @property string $estimate_arrival_date
 * @property integer $requester_id
 * @property integer $requester_branch_id
 * @property integer $approved_id
 * @property integer $approved_branch_id
 * @property integer $customer_id
 * @property integer $total_quantity
 * @property string $total_price
 * @property string $estimate_payment_date
 * @property integer $company_bank_id
 * @property integer $coa_id
 * @property string $price_before_discount
 * @property string $subtotal
 * @property string $discount
 * @property integer $ppn
 * @property string $ppn_price
 * @property string $note
 *
 * The followings are the available model relations:
 * @property InvoiceHeader[] $invoiceHeaders
 * @property TransactionDeliveryOrder[] $transactionDeliveryOrders
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property TransactionSalesOrderDetail[] $transactionSalesOrderDetails
 * @property Branch $requesterBranch
 * @property Branch $approvedBranch
 * @property Customer $customer
 * @property CompanyBank $companyBank
 * @property Coa $coa
 * @property TransactionSalesOrderApproval[] $transactionSalesOrderApprovals
 * @property TransactionSalesOrderDetail[] $transactionSalesOrderDetails
 */
class TransactionSalesOrder extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'SO';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionSalesOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $customer_name;
    public $coa_name;
    public $coa_code;
    public $coa_customer;
    public $cust_type;
    public $requester_name;

    public function tableName() {
        return '{{transaction_sales_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sale_order_no, sale_order_date, status_document, payment_type, requester_id, requester_branch_id, customer_id, total_quantity, total_price', 'required'),
            array('requester_id, requester_branch_id, approved_id, approved_branch_id, customer_id, total_quantity, company_bank_id, ppn', 'numerical', 'integerOnly' => true),
            array('sale_order_no, status_document, payment_type', 'length', 'max' => 30),
            array('total_price, price_before_discount, subtotal, discount, ppn_price', 'length', 'max' => 18),
            array('estimate_arrival_date, estimate_payment_date, note', 'safe'),
            array('sale_order_no', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sale_order_no, sale_order_date, status_document, payment_type, estimate_arrival_date, requester_id, requester_branch_id, approved_id, approved_branch_id, customer_id, total_quantity, total_price, estimate_payment_date, company_bank_id, price_before_discount, subtotal, discount, ppn_price, ppn, customer_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoiceHeaders' => array(self::HAS_MANY, 'InvoiceHeader', 'sales_order_id'),
            'transactionDeliveryOrders' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'sales_order_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'sales_order_id'),
            'transactionSalesOrderDetails' => array(self::HAS_MANY, 'TransactionSalesOrderDetail', 'sales_order_id'),
            'requesterBranch' => array(self::BELONGS_TO, 'Branch', 'requester_branch_id'),
            'approvedBranch' => array(self::BELONGS_TO, 'Branch', 'approved_branch_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'companyBank' => array(self::BELONGS_TO, 'CompanyBank', 'company_bank_id'),
            //'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'transactionSalesOrderApprovals' => array(self::HAS_MANY, 'TransactionSalesOrderApproval', 'sales_order_id'),
            'transactionSalesOrderDetails' => array(self::HAS_MANY, 'TransactionSalesOrderDetail', 'sales_order_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'requester_id'),
            'approval' => array(self::BELONGS_TO, 'Users', 'approved_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sale_order_no' => 'Sale Order No',
            'sale_order_date' => 'Sale Order Date',
            'status_document' => 'Status Document',
            'payment_type' => 'Payment Type',
            'estimate_arrival_date' => 'Estimate Shipment Date',
            'requester_id' => 'Requester',
            'requester_branch_id' => 'Requester Branch',
            'approved_id' => 'Approved',
            'approved_branch_id' => 'Approved Branch',
            'customer_id' => 'Customer',
            'total_quantity' => 'Total Quantity',
            'total_price' => 'Total Price',
            'estimate_payment_date' => 'Estimate Payment Date',
            'company_bank_id' => 'Company Bank',
            'price_before_discount' => 'Price Before Discount',
            'subtotal' => 'Subtotal',
            'discount' => 'Discount',
            'ppn' => 'Ppn',
            'ppn_price' => 'Ppn Price',
            'note' => 'Note',
                //'coa_id' => 'Coa',
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
        $criteria->compare('sale_order_no', $this->sale_order_no, true);
        $criteria->compare('sale_order_date', $this->sale_order_date, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('approved_id', $this->approved_id);
        $criteria->compare('approved_branch_id', $this->approved_branch_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('estimate_payment_date', $this->estimate_payment_date, true);
        $criteria->compare('company_bank_id', $this->company_bank_id);
        //$criteria->compare('coa_id',$this->coa_id);
        //$criteria->compare('coa_id',$this->coa_id);
        $criteria->compare('price_before_discount', $this->price_before_discount, true);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('t.note', $this->note, true);

        $criteria->together = 'true';
        $criteria->with = array('customer');
        $criteria->compare('customer.name', $this->customer_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sale_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByPendingDelivery() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
			SELECT COALESCE(SUM(d.sales_order_quantity_left), 0) AS quantity_remaining
			FROM " . TransactionSalesOrderDetail::model()->tableName() . " d
			WHERE t.id = d.sales_order_id AND status_document = 'Approved'
			GROUP BY d.sales_order_id
			HAVING quantity_remaining > 0
		)";

        $criteria->compare('id', $this->id);
        $criteria->compare('sale_order_no', $this->sale_order_no, true);
        $criteria->compare('sale_order_date', $this->sale_order_date, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('approved_id', $this->approved_id);
        $criteria->compare('approved_branch_id', $this->approved_branch_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('estimate_payment_date', $this->estimate_payment_date, true);
        $criteria->compare('company_bank_id', $this->company_bank_id);
        $criteria->compare('price_before_discount', $this->price_before_discount, true);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('t.note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sale_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByDelivery() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
			SELECT COALESCE(SUM(d.sales_order_quantity_left), 0) AS quantity_remaining
			FROM " . TransactionSalesOrderDetail::model()->tableName() . " d
			WHERE t.id = d.sales_order_id
			GROUP BY d.sales_order_id
			HAVING quantity_remaining > 0
		)";

        $criteria->compare('id', $this->id);
        $criteria->compare('sale_order_no', $this->sale_order_no, true);
        $criteria->compare('sale_order_date', $this->sale_order_date, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('approved_id', $this->approved_id);
        $criteria->compare('approved_branch_id', $this->approved_branch_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('estimate_payment_date', $this->estimate_payment_date, true);
        $criteria->compare('company_bank_id', $this->company_bank_id);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('t.note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sale_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getTotalRemainingQuantityDelivered() {
        $totalRemaining = 0;

        foreach ($this->transactionSalesOrderDetails as $detail)
            $totalRemaining += $detail->remainingQuantityDelivery;

        return ($totalRemaining = 0) ? 'Completed' : 'Pending';
    }

}
