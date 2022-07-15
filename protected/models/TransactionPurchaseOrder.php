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
 * @property string $payment_amount
 * @property string $payment_left
 * @property integer $company_bank_id
 * @property string $payment_status
 * @property integer $coa_id
 * @property string $payment_date_estimate
 * @property integer $coa_bank_id_estimate
 * @property integer $purchase_type
 * @property string $created_datetime
 * @property integer $tax_percentage
 *
 * The followings are the available model relations:
 * @property PaymentOut[] $paymentOuts
 * @property Supplier $supplier
 * @property CompanyBank $companyBank
 * @property Coa $coa
 * @property TransactionPurchaseOrderApproval[] $transactionPurchaseOrderApprovals
 * @property TransactionPurchaseOrderDetail[] $transactionPurchaseOrderDetails
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionReturnOrder[] $transactionReturnOrders
 * @property CoaBank $coaBankIdEstimate
 */
class TransactionPurchaseOrder extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'PO';

    /**
     * @return string the associated database table name
     */
    public $supplier_name;
    public $coa_name;
    public $coa_supplier;
    public $main_branch_name;
    public $approved_name;
    public $requester_name;

    const SPAREPART = 1;
    const TIRE = 2;
    const GENERAL = 3;
    const SPAREPART_LITERAL = 'Spare Part';
    const TIRE_LITERAL = 'Ban';
    const GENERAL_LITERAL = 'Umum / Oli';

    const ADD_TAX = 1;
    const NON_TAX = 2;
    const INCLUDE_TAX = 3;
    const ADD_TAX_LITERAL = 'Add PPN';
    const NON_TAX_LITERAL = 'Non PPN';
    const INCLUDE_TAX_LITERAL = 'Include PPN';

    public function tableName() {
        return '{{transaction_purchase_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('purchase_order_no, purchase_order_date, status_document, payment_type, purchase_type, tax_percentage', 'required'),
            array('supplier_id, requester_id, main_branch_id, approved_id, total_quantity, ppn, company_bank_id, purchase_type, coa_bank_id_estimate, tax_percentage', 'numerical', 'integerOnly' => true),
            array('purchase_order_no, status_document', 'length', 'max' => 30),
            array('payment_type', 'length', 'max' => 20),
            array('price_before_discount, discount, subtotal, ppn_price, total_price, payment_amount, payment_left', 'length', 'max' => 18),
            array('estimate_date_arrival, payment_date_estimate', 'safe'),
            array('payment_status', 'length', 'max' => 50),
            array('purchase_order_no', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, purchase_order_no, purchase_order_date, status_document, supplier_id, payment_type, estimate_date_arrival, requester_id, main_branch_id, approved_id, total_quantity, price_before_discount, discount, subtotal, ppn, ppn_price, total_price,supplier_name,coa_supplier,coa_name, payment_date_estimate, main_branch_name, approved_name, requester_name, purchase_type, coa_bank_id_estimate, created_datetime, tax_percentage', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentOuts' => array(self::HAS_MANY, 'PaymentOut', 'purchase_order_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'companyBank' => array(self::BELONGS_TO, 'CompanyBank', 'company_bank_id'),
            'transactionPurchaseOrderApprovals' => array(self::HAS_MANY, 'TransactionPurchaseOrderApproval', 'purchase_order_id'),
            'transactionPurchaseOrderDetails' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetail', 'purchase_order_id'),
            'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'purchase_order_id'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'purchase_order_id'),
            'user' => array(self::BELONGS_TO, 'User', 'requester_id'),
            'approval' => array(self::BELONGS_TO, 'User', 'approved_id'),
            'mainBranch' => array(self::BELONGS_TO, 'Branch', 'main_branch_id'),
//            'requesterBranch' => array(self::BELONGS_TO, 'Branch', 'requester_branch_id'),
            'coaBankIdEstimate' => array(self::BELONGS_TO, 'Coa', 'coa_bank_id_estimate'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
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
            'payment_amount' => 'Payment Amount',
            'payment_left' => 'Payment Left',
            'company_bank_id' => 'Company Bank',
            'payment_status' => 'Payment Status',
            'payment_date_estimate' => 'Estimate Payment Date',
            'purchase_type' => 'Purchase Type',
            'coa_bank_id_estimate' => 'Coa Bank',
            'tax_percentage' => 'PPn %',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('t.purchase_order_date', $this->purchase_order_date, true);
        $criteria->compare('t.status_document', $this->status_document, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.estimate_date_arrival', $this->estimate_date_arrival, true);
        $criteria->compare('t.requester_id', $this->requester_id);
        $criteria->compare('t.main_branch_id', $this->main_branch_id);
        $criteria->compare('t.approved_id', $this->approved_id);
        $criteria->compare('t.total_quantity', $this->total_quantity);
        $criteria->compare('t.price_before_discount', $this->price_before_discount, true);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.subtotal', $this->subtotal, true);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.ppn_price', $this->ppn_price, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.payment_left', $this->payment_left, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('t.payment_status', $this->payment_status, true);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.purchase_type', $this->purchase_type, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

        $criteria->together = 'true';
        $criteria->with = array('supplier');
        $criteria->compare('supplier.name', $this->supplier_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'purchase_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByAdmin() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('t.purchase_order_date', $this->purchase_order_date, true);
        $criteria->compare('t.status_document', $this->status_document, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.estimate_date_arrival', $this->estimate_date_arrival, true);
        $criteria->compare('t.requester_id', $this->requester_id);
        $criteria->compare('t.approved_id', $this->approved_id);
        $criteria->compare('t.total_quantity', $this->total_quantity);
        $criteria->compare('t.price_before_discount', $this->price_before_discount, true);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.subtotal', $this->subtotal, true);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.ppn_price', $this->ppn_price, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.payment_left', $this->payment_left, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('t.payment_status', $this->payment_status, true);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.purchase_type', $this->purchase_type, true);
        $criteria->compare('t.main_branch_id', $this->main_branch_id);

//        $criteria->addCondition("t.main_branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        $criteria->together = 'true';
        $criteria->with = array('supplier', 'mainBranch');
        $criteria->compare('supplier.name', $this->supplier_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'purchase_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionPurchaseOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByReceive() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.purchase_order_quantity_left), 0) AS quantity_remaining
            FROM " . TransactionPurchaseOrderDetail::model()->tableName() . " d
            WHERE t.id = d.purchase_order_id
            GROUP BY d.purchase_order_id
            HAVING quantity_remaining > 0
        )";

        $criteria->compare('id', $this->id);
        $criteria->compare('purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('purchase_order_date', $this->purchase_order_date, true);
        
        $criteria->together = 'true';
        $criteria->with = array('supplier');
        $criteria->compare('supplier.name', $this->supplier_name, true);

        $criteria->addCondition("status_document = 'Approved'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.purchase_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByDailyCashReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.purchase_order_no', $this->purchase_order_no, true);
        $criteria->compare('t.status_document', $this->status_document, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.estimate_date_arrival', $this->estimate_date_arrival, true);
        $criteria->compare('t.requester_id', $this->requester_id);
        $criteria->compare('t.main_branch_id', $this->main_branch_id);
        $criteria->compare('t.approved_id', $this->approved_id);
        $criteria->compare('t.total_quantity', $this->total_quantity);
        $criteria->compare('t.price_before_discount', $this->price_before_discount, true);
        $criteria->compare('t.discount', $this->discount, true);
        $criteria->compare('t.subtotal', $this->subtotal, true);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.ppn_price', $this->ppn_price, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.payment_left', $this->payment_left, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('t.payment_status', $this->payment_status, true);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.purchase_type', $this->purchase_type, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

        $criteria->addCondition("t.approved_id IS NOT NULL AND t.main_branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'purchase_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function getPurchaseStatus($status) {
        switch ($status) {
            case self::SPAREPART: return self::SPAREPART_LITERAL;
            case self::TIRE: return self::TIRE_LITERAL;
            case self::GENERAL: return self::GENERAL_LITERAL;
            default: return '';
        }
    }

    public function getTaxStatus() {
        switch ($this->ppn) {
            case self::ADD_TAX: return self::ADD_TAX_LITERAL;
            case self::NON_TAX: return self::NON_TAX_LITERAL;
            case self::INCLUDE_TAX: return self::INCLUDE_TAX_LITERAL;
            default: return '';
        }
    }

    public function getTotalRemainingQuantityReceived() {
        $totalRemaining = 0;

        foreach ($this->transactionPurchaseOrderDetails as $detail) {
            $totalRemaining += $detail->totalQuantityReceived;
        }

        return ($totalRemaining > 0) ? 'Partial' : 'Pending';
    }

    public function getTotalPayment() {
        $total = 0.00;
        
        foreach ($this->paymentOuts as $detail) {
            $total += $detail->payment_amount;
        }
        
        return $total;
    }
    
    public function getTotalRemaining() {
        
        return $this->total_price - $this->getTotalPayment();
    }

}
