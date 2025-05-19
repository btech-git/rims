<?php

/**
 * This is the model class for table "{{invoice_header}}".
 *
 * The followings are the available columns in table '{{invoice_header}}':
 * @property integer $id
 * @property string $invoice_number
 * @property string $invoice_date
 * @property string $due_date
 * @property string $payment_date_estimate
 * @property integer $coa_bank_id_estimate
 * @property integer $reference_type
 * @property integer $sales_order_id
 * @property integer $registration_transaction_id
 * @property integer $customer_id
 * @property integer $vehicle_id
 * @property integer $ppn
 * @property integer $pph
 * @property integer $branch_id
 * @property integer $user_id
 * @property integer $supervisor_id
 * @property string $status
 * @property string $service_price
 * @property string $product_price
 * @property string $quick_service_price
 * @property integer $total_product
 * @property integer $total_service
 * @property integer $total_quick_service
 * @property string $pph_total
 * @property string $ppn_total
 * @property string $total_discount
 * @property string $total_price
 * @property string $in_words
 * @property string $note
 * @property string $payment_amount
 * @property string $payment_left
 * @property integer $tax_percentage
 * @property string $created_datetime
 * @property string $cancelled_datetime
 * @property integer $user_id_cancelled
 * @property string $edited_datetime
 * @property integer $user_id_edited
 * @property integer $user_id_printed
 * @property integer $insurance_company_id
 * @property integer $number_of_print
 *
 * The followings are the available model relations:
 * @property InvoiceDetail[] $invoiceDetails
 * @property TransactionSalesOrder $salesOrder
 * @property RegistrationTransaction $registrationTransaction
 * @property Customer $customer
 * @property Vehicle $vehicle
 * @property Branch $branch
 * @property CoaBank $coaBankIdEstimate
 * @property PaymentIn[] $invoiceHeaders
 * @property InsuranceCompany $insuranceCompany
 * @property UserIdCancelled $userIdCancelled
 * @property UserIdEdited $userIdEdited
 * @property UserIdEdited $userIdPrinted
 */
class InvoiceHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'INV';

    public $customer_name;
    public $invoice_date_to;
    public $due_date_to;
    public $customer_type;
    public $plate_number;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{invoice_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invoice_number, invoice_date, due_date, reference_type, branch_id, user_id, status, total_discount, total_price, tax_percentage, number_of_print', 'required'),
            array('reference_type, sales_order_id, registration_transaction_id, customer_id, vehicle_id, ppn, pph, branch_id, user_id, supervisor_id, total_product, total_service, total_quick_service, coa_bank_id_estimate, tax_percentage, user_id_cancelled, insurance_company_id, number_of_print, user_id_edited, user_id_printed', 'numerical', 'integerOnly' => true),
            array('invoice_number', 'length', 'max' => 50),
            array('status', 'length', 'max' => 30),
            array('service_price, product_price, quick_service_price, pph_total, ppn_total, total_discount, total_price, payment_amount, payment_left', 'length', 'max' => 18),
            array('in_words, note, payment_date_estimate', 'safe'),
            array('invoice_number', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, invoice_number, invoice_date, due_date, number_of_print, reference_type, sales_order_id, registration_transaction_id, customer_id, vehicle_id, ppn, pph, branch_id, user_id, supervisor_id, status, service_price, product_price, quick_service_price, total_product, insurance_company_id, total_service, total_quick_service, pph_total, ppn_total, total_discount, total_price, in_words, note, customer_name, invoice_date_to, due_date_to, payment_amount, payment_left,customer_type, payment_date_estimate, coa_bank_id_estimate, plate_number, tax_percentage, created_datetime, cancelled_datetime, user_id_cancelled, edited_datetime, user_id_edited, user_id_printed', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoiceDetails' => array(self::HAS_MANY, 'InvoiceDetail', 'invoice_id'),
            'salesOrder' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'sales_order_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdCancelled' => array(self::BELONGS_TO, 'User', 'user_id_cancelled'),
            'userIdEdited' => array(self::BELONGS_TO, 'User', 'user_id_edited'),
            'userIdPrinted' => array(self::BELONGS_TO, 'User', 'user_id_printed'),
            'coaBankIdEstimate' => array(self::BELONGS_TO, 'CompanyBank', 'coa_bank_id_estimate'),
            'paymentIns' => array(self::HAS_MANY, 'PaymentIn', 'invoice_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
            'paymentInDetails' => array(self::HAS_MANY, 'PaymentInDetail', 'invoice_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'invoice_number' => 'Invoice Number',
            'invoice_date' => 'Invoice Date',
            'due_date' => 'Due Date',
            'payment_date_estimate' => 'Payment Date',
            'coa_bank_id_estimate' => 'Company Bank',
            'invoice_date_to' => 'Invoice Date To',
            'due_date_to' => 'Due Date To',
            'reference_type' => 'Reference Type',
            'sales_order_id' => 'Sales Order',
            'registration_transaction_id' => 'Registration Transaction',
            'customer_id' => 'Customer',
            'vehicle_id' => 'Vehicle',
            'ppn' => 'Ppn',
            'pph' => 'Pph',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'supervisor_id' => 'Supervisor',
            'status' => 'Status',
            'service_price' => 'Service Price',
            'product_price' => 'Product Price',
            'quick_service_price' => 'Quick Service Price',
            'total_product' => 'Total Product',
            'total_service' => 'Total Service',
            'total_quick_service' => 'Total Quick Service',
            'pph_total' => 'Pph Total',
            'ppn_total' => 'Ppn Total',
            'total_price' => 'Total Price',
            'in_words' => 'In Words',
            'note' => 'Note',
            'payment_amount' => 'Payment Amount',
            'payment_left' => 'Payment Left',
            'tax_percentage' => 'PPn %',
            'insurance_company_id' => 'Insurance Company',
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
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.reference_type', $this->reference_type);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.pph', $this->pph);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.service_price', $this->service_price, true);
        $criteria->compare('t.product_price', $this->product_price, true);
        $criteria->compare('t.quick_service_price', $this->quick_service_price, true);
        $criteria->compare('t.total_product', $this->total_product);
        $criteria->compare('t.total_service', $this->total_service);
        $criteria->compare('t.total_quick_service', $this->total_quick_service);
        $criteria->compare('t.pph_total', $this->pph_total, true);
        $criteria->compare('t.ppn_total', $this->ppn_total, true);
        $criteria->compare('t.total_discount', $this->total_discount, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('t.number_of_print', $this->number_of_print);

        if ($this->invoice_date != NULL OR $this->invoice_date_to != NULL) {
            $criteria->addBetweenCondition('invoice_date', $this->invoice_date, $this->invoice_date_to);
            $criteria->addBetweenCondition('due_date', $this->invoice_date, $this->invoice_date_to);
        }

        $criteria->together = 'true';
        $criteria->with = array('customer');
        $criteria->addSearchCondition('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function searchByAdmin() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.reference_type', $this->reference_type);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status, FALSE);
        $criteria->compare('service_price', $this->service_price, true);
        $criteria->compare('product_price', $this->product_price, true);
        $criteria->compare('quick_service_price', $this->quick_service_price, true);
        $criteria->compare('total_product', $this->total_product);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('total_quick_service', $this->total_quick_service);
        $criteria->compare('pph_total', $this->pph_total, true);
        $criteria->compare('ppn_total', $this->ppn_total, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('in_words', $this->in_words, true);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('note', $this->note, true);

//        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        if ($this->invoice_date != NULL OR $this->invoice_date_to != NULL) {
            $criteria->addBetweenCondition('invoice_date', $this->invoice_date, $this->invoice_date_to);
            $criteria->addBetweenCondition('due_date', $this->invoice_date, $this->invoice_date_to);
        }

        $criteria->together = 'true';
        $criteria->with = array('customer', 'vehicle');
        $criteria->addSearchCondition('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);
        $criteria->addSearchCondition('vehicle.plate_number', $this->plate_number   , true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function searchForPaymentIn() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.payment_left > 0";
        
        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.reference_type', $this->reference_type);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.pph', $this->pph);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.service_price', $this->service_price, true);
        $criteria->compare('t.product_price', $this->product_price, true);
        $criteria->compare('t.quick_service_price', $this->quick_service_price, true);
        $criteria->compare('t.total_product', $this->total_product);
        $criteria->compare('t.total_service', $this->total_service);
        $criteria->compare('t.total_quick_service', $this->total_quick_service);
        $criteria->compare('t.pph_total', $this->pph_total, true);
        $criteria->compare('t.ppn_total', $this->ppn_total, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

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
    
    public function searchByReport() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.reference_type', $this->reference_type);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.pph', $this->pph);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.service_price', $this->service_price, true);
        $criteria->compare('t.product_price', $this->product_price, true);
        $criteria->compare('t.quick_service_price', $this->quick_service_price, true);
        $criteria->compare('t.total_product', $this->total_product);
        $criteria->compare('t.total_service', $this->total_service);
        $criteria->compare('t.total_quick_service', $this->total_quick_service);
        $criteria->compare('t.pph_total', $this->pph_total, true);
        $criteria->compare('t.ppn_total', $this->ppn_total, true);
        $criteria->compare('t.total_discount', $this->total_discount, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('t.number_of_print', $this->number_of_print);

        if ($this->invoice_date != NULL OR $this->invoice_date_to != NULL) {
            $criteria->addBetweenCondition('invoice_date', $this->invoice_date, $this->invoice_date_to);
            $criteria->addBetweenCondition('due_date', $this->invoice_date, $this->invoice_date_to);
        }

        $criteria->together = 'true';
        $criteria->with = array('customer');
        $criteria->addSearchCondition('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));
    }

    public function getSubTotal() {
        return $this->service_price + $this->product_price + $this->quick_service_price;
    }

    public function getProductPriceAfterTax() {
        return $this->product_price * ( 1 + $this->tax_percentage / 100);
    }
    
    public function getServicePriceAfterTax() {
        return $this->service_price * ( 1 + $this->tax_percentage / 100);
    }
    
    public function getSubTotalAfterTax() {
        return $this->productPriceAfterTax + $this->servicePriceAfterTax;
    }
    
    public function getSubTotalBeforeDiscount() {
        $total = '0.00'; 
        
        foreach ($this->invoiceDetails as $detail) {
            $total += $detail->quantity * $detail->unit_price;
        }
        
        return $total;
    }

    public function getTotalPayment() {
        $total = 0.00;
        
        foreach ($this->paymentInDetails as $detail) {
            $total += $detail->amount + $detail->tax_service_amount;
        }
        
        return $total;
    }
    
    public function getTotalRemaining() {
        
        return $this->total_price - $this->payment_amount;
    }

    public function getRemainingDueDate() {
        $date = date('Y-m-d');

        $date1 = new DateTime($date);
        $date2 = new DateTime($this->due_date);

        $diff = $date2->diff($date1)->format("%r%a");

        return (int)$diff;
    }

    public function getReferenceTypeLiteral() {
        return $this->reference_type  == 1 ? 'Sales Order' : 'Retail Sales';
    }
    
    public static function totalReceivables() {
        
        $sql = "SELECT SUM(payment_left) AS remaining
                FROM " . InvoiceHeader::model()->tableName() . "
                WHERE payment_left > 0 AND invoice_date > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'";
                
        $value = Yii::app()->db->createCommand($sql)->queryScalar(array());

        return ($value === false) ? 0 : $value;
    }
    
    public function searchByPendingJournal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_number', $this->invoice_number, true);
        $criteria->compare('t.reference_type', $this->reference_type);
        $criteria->compare('t.sales_order_id', $this->sales_order_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('t.payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('t.ppn', $this->ppn);
        $criteria->compare('t.pph', $this->pph);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.service_price', $this->service_price, true);
        $criteria->compare('t.product_price', $this->product_price, true);
        $criteria->compare('t.quick_service_price', $this->quick_service_price, true);
        $criteria->compare('t.total_product', $this->total_product);
        $criteria->compare('t.total_service', $this->total_service);
        $criteria->compare('t.total_quick_service', $this->total_quick_service);
        $criteria->compare('t.pph_total', $this->pph_total, true);
        $criteria->compare('t.ppn_total', $this->ppn_total, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

        $criteria->addCondition("substring(t.invoice_number, 1, (length(t.invoice_number) - 2)) NOT IN (
            SELECT substring(kode_transaksi, 1, (length(kode_transaksi) - 2))  
            FROM " . JurnalUmum::model()->tableName() . "
        ) AND t.status NOT LIKE 'CANCEL%'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public static function getSaleReportByProductCategory($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT c.customer_type, DATE(h.invoice_date) AS transaction_date, p.product_master_category_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY c.customer_type, DATE(h.invoice_date), p.product_master_category_id
                ORDER BY c.customer_type DESC, transaction_date ASC, p.product_master_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportByServiceType($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT c.customer_type, DATE(h.invoice_date) AS transaction_date, s.service_category_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                INNER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY c.customer_type, DATE(h.invoice_date), s.service_category_id
                ORDER BY c.customer_type DESC, transaction_date ASC, s.service_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportSummary($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT c.customer_type, DATE(h.invoice_date) AS transaction_date, SUM(h.ppn_total) AS ppn_total, SUM(h.pph_total) AS pph_total, SUM(h.total_price) AS total_price, SUM(h.total_product) AS total_product, SUM(h.total_service) AS total_service, SUM(h.total_discount) AS total_discount
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY c.customer_type, DATE(h.invoice_date)
                ORDER BY c.customer_type DESC, transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportByProductCategoryAll($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, p.product_master_category_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY DATE(h.invoice_date), p.product_master_category_id
                ORDER BY transaction_date ASC, p.product_master_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportByServiceTypeAll($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, s.service_category_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY DATE(h.invoice_date), s.service_category_id
                ORDER BY transaction_date ASC, s.service_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportSummaryAll($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, SUM(h.ppn_total) AS ppn_total, SUM(h.pph_total) AS pph_total, SUM(h.total_price) AS total_price, SUM(h.total_product) AS total_product, SUM(h.total_service) AS total_service, SUM(h.total_discount) AS total_discount
                FROM " . InvoiceHeader::model()->tableName() . " h 
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY DATE(h.invoice_date)
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getCompanySaleReportByProductCategory($year, $month) {
        
        $sql = "SELECT h.branch_id, p.product_master_category_id, MAX(b.company_id) AS company_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                INNER JOIN " . Company::model()->tableName() . " c ON c.id = b.company_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.status NOT LIKE '%CANCEL%'
                GROUP BY h.branch_id, p.product_master_category_id
                ORDER BY company_id ASC, h.branch_id ASC, p.product_master_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
            ':month' => $month,
        ));

        return $resultSet;
    }
    
    public static function getCompanySaleReportByServiceType($year, $month) {
        
        $sql = "SELECT h.branch_id, s.service_category_id, MAX(b.company_id) AS company_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                INNER JOIN " . Company::model()->tableName() . " c ON c.id = b.company_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.status NOT LIKE '%CANCEL%'
                GROUP BY h.branch_id, s.service_category_id
                ORDER BY company_id ASC, h.branch_id ASC, s.service_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
            ':month' => $month,
        ));

        return $resultSet;
    }
    
    public static function getCompanySaleReportSummary($year, $month) {
        
        $sql = "SELECT h.branch_id, MAX(b.company_id) AS company_id, SUM(h.ppn_total) AS ppn_total, SUM(h.pph_total) AS pph_total, SUM(h.total_price) AS total_price, SUM(h.total_product) AS total_product, SUM(h.total_service) AS total_service, SUM(h.total_discount) AS total_discount
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                INNER JOIN " . Company::model()->tableName() . " c ON c.id = b.company_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.status NOT LIKE '%CANCEL%'
                GROUP BY h.branch_id
                ORDER BY company_id ASC, h.branch_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
            ':month' => $month,
        ));

        return $resultSet;
    }
    
    public static function getMonthlyProductSaleData($startDate, $endDate, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $masterCategoryId, $subMasterCategoryId, $subCategoryId) {
        $branchConditionSql = '';
        $brandConditionSql = ''; 
        $categoryConditionSql = '';
        $brandCategoryConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($subBrandSeriesId)) {
            $brandConditionSql = ' AND p.sub_brand_series_id = :sub_brand_series_id';
            $params[':sub_brand_series_id'] = $subBrandSeriesId;
        } else if (!empty($subBrandId)) {
            $brandConditionSql = ' AND p.sub_brand_id = :sub_brand_id';
            $params[':sub_brand_id'] = $subBrandId;
        } else if (!empty($brandId)) {
            $brandConditionSql = ' AND p.brand_id = :brand_id';
            $params[':brand_id'] = $brandId;
        }
        
        if (!empty($subCategoryId)) {
            $categoryConditionSql = ' AND p.product_sub_category_id = :product_sub_category_id';
            $params[':product_sub_category_id'] = $subCategoryId;
        } else if (!empty($subMasterCategoryId)) {
            $categoryConditionSql = ' AND p.product_sub_master_category_id = :product_sub_master_category_id';
            $params[':product_sub_master_category_id'] = $subMasterCategoryId;
        } else if (!empty($masterCategoryId)) {
            $categoryConditionSql = ' AND p.product_master_category_id = :product_master_category_id';
            $params[':product_master_category_id'] = $masterCategoryId;
        }
        
        if (empty($brandConditionSql) && empty($categoryConditionSql)) {
            $brandCategoryConditionSql = ' AND FALSE';
        } else {
            $brandCategoryConditionSql = $brandConditionSql . $categoryConditionSql;
        }
        
        $sql = "SELECT h.invoice_date, d.product_id, MIN(p.name) AS product_name, SUM(d.quantity) AS total_quantity, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE h.invoice_date BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . $brandCategoryConditionSql . "
                GROUP BY h.invoice_date, d.product_id
                ORDER BY h.invoice_date ASC, d.product_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getMonthlyServiceSaleData($startDate, $endDate, $branchId, $categoryId, $typeId) {
        $branchConditionSql = '';
        $typeConditionSql = ''; 
        $categoryConditionSql = '';
        $typeCategoryConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($typeId)) {
            $typeConditionSql = ' AND s.service_type_id = :service_type_id';
            $params[':service_type_id'] = $typeId;
        }
        
        if (!empty($categoryId)) {
            $categoryConditionSql = ' AND s.service_category_id = :service_category_id';
            $params[':service_category_id'] = $categoryId;
        }
        
        if (empty($typeConditionSql) && empty($categoryConditionSql)) {
            $typeCategoryConditionSql = ' AND FALSE';
        } else {
            $typeCategoryConditionSql = $typeConditionSql . $categoryConditionSql;
        }
        
        $sql = "SELECT h.invoice_date, d.service_id, MIN(s.name) AS service_name, COUNT(d.service_id) AS total_quantity, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
                WHERE h.invoice_date BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . $typeCategoryConditionSql . "
                GROUP BY h.invoice_date, d.service_id
                ORDER BY h.invoice_date ASC, d.service_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleByProductSubMasterCategoryReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT c.customer_type, DATE(h.invoice_date) AS transaction_date, p.product_sub_master_category_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY c.customer_type, DATE(h.invoice_date), p.product_sub_master_category_id
                ORDER BY c.customer_type DESC, transaction_date ASC, p.product_sub_master_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleByProductSubMasterCategoryReportSummary($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT c.customer_type, DATE(h.invoice_date) AS transaction_date, SUM(h.ppn_total) AS ppn_total, SUM(h.pph_total) AS pph_total, SUM(h.total_price) AS total_price, SUM(h.total_product) AS total_product, SUM(h.total_discount) AS total_discount
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY c.customer_type, DATE(h.invoice_date)
                ORDER BY c.customer_type DESC, transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleByProductSubMasterCategoryReportAll($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, p.product_sub_master_category_id, SUM(d.total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY DATE(h.invoice_date), p.product_sub_master_category_id
                ORDER BY transaction_date ASC, p.product_sub_master_category_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleByProductSubMasterCategoryReportSummaryAll($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, SUM(h.ppn_total) AS ppn_total, SUM(h.pph_total) AS pph_total, SUM(h.total_price) AS total_price, SUM(h.total_product) AS total_product, SUM(h.total_discount) AS total_discount
                FROM " . InvoiceHeader::model()->tableName() . " h 
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
                GROUP BY DATE(h.invoice_date)
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportByProduct($startDate, $endDate, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $masterCategoryId, $subMasterCategoryId, $subCategoryId) {
        $branchConditionSql = '';
        $brandConditionSql = '';
        $subBrandConditionSql = '';
        $subBrandSeriesConditionSql = '';
        $masterCategoryConditionSql = '';
        $subMasterCategoryConditionSql = '';
        $subCategoryConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($brandId)) {
            $brandConditionSql = ' AND p.brand_id = :brand_id';
            $params[':brand_id'] = $brandId;
        }
        
        if (!empty($subBrandId)) {
            $subBrandConditionSql = ' AND p.sub_brand_id = :sub_brand_id';
            $params[':sub_brand_id'] = $subBrandId;
        }
        
        if (!empty($subBrandSeriesId)) {
            $subBrandSeriesConditionSql = ' AND p.sub_brand_series_id = :sub_brand_series_id';
            $params[':sub_brand_series_id'] = $subBrandSeriesId;
        }
        
        if (!empty($masterCategoryId)) {
            $masterCategoryConditionSql = ' AND p.product_master_category_id = :product_master_category_id';
            $params[':product_master_category_id'] = $masterCategoryId;
        }
        
        if (!empty($subMasterCategoryId)) {
            $subMasterCategoryConditionSql = ' AND p.product_sub_master_category_id = :product_sub_master_category_id';
            $params[':product_sub_master_category_id'] = $subMasterCategoryId;
        }
        
        if (!empty($subCategoryId)) {
            $subCategoryConditionSql = ' AND p.product_sub_category_id = :product_sub_category_id';
            $params[':product_sub_category_id'] = $subCategoryId;
        }
        
        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, d.product_id, SUM(d.total_price) AS total_price, SUM(d.quantity) AS total_quantity
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . $brandConditionSql . $subBrandConditionSql . $subBrandSeriesConditionSql . $masterCategoryConditionSql . $subMasterCategoryConditionSql . $subCategoryConditionSql . "
                GROUP BY DATE(h.invoice_date), d.product_id
                ORDER BY transaction_date ASC, d.product_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleReportByService($startDate, $endDate, $branchId, $categoryId, $typeId) {
        $branchConditionSql = '';
        $categoryConditionSql = '';
        $typeConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($categoryId)) {
            $categoryConditionSql = ' AND s.service_category_id = :service_category_id';
            $params[':service_category_id'] = $categoryId;
        }

        if (!empty($typeId)) {
            $typeConditionSql = ' AND s.service_type_id = :service_type_id';
            $params[':service_type_id'] = $typeId;
        }

        $sql = "SELECT DATE(h.invoice_date) AS transaction_date, d.service_id, SUM(d.total_price) AS total_price, COUNT(d.service_id) AS total_quantity
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
                WHERE DATE(h.invoice_date) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . $categoryConditionSql . $typeConditionSql . "
                GROUP BY DATE(h.invoice_date), d.service_id
                ORDER BY transaction_date ASC, d.service_id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getTotalDiscountProduct() {
        $total = 0; 
        
        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id)) {
                $total += $detail->discount;
            }
        }
        
        return $total;
    }
    
    public function getTotalDiscountService() {
        $total = 0; 
        
        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->service_id)) {
                $total += $detail->discount;
            }
        }
        
        return $total;
    }
    
    public function getTotalDiscountProductService() {
        $total = 0; 
        
        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id)) {
                $total += $detail->discount;
            }
        }
        
        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->service_id)) {
                $total += $detail->discount;
            }
        }
        
        return $total;
    }
    
    public static function getYearlySaleSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, SUM(total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%'
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getYearlyCompanySaleSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, SUM(total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%' AND c.customer_type = 'Company'
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getYearlyIndividualSaleSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, SUM(total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%' AND c.customer_type = 'Individual'
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getYearlyVehicleSaleSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, COUNT(vehicle_id) AS total_vehicle
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%'
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getSaleInvoiceNonTaxMonthlyReport($year, $month, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':month' => $month,
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, i.customer_id, MAX(c.name) AS customer_name, COUNT(*) AS quantity_invoice, SUM(i.service_price) AS service_price, SUM(i.product_price) AS product_price, SUM(i.product_price + i.service_price) AS sub_total, SUM(i.ppn_total) AS total_tax, SUM(i.pph_total) AS total_tax_income, SUM(i.total_price) AS total_price 
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(i.invoice_date) = :year AND MONTH(i.invoice_date) = :month AND i.status NOT LIKE '%CANCELLED%' AND i.tax_percentage = 0 AND i.ppn_total = 0" . $branchConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), i.customer_id
                ORDER BY year_month_value ASC, c.name ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getYearlySaleTaxSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, SUM(total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%' AND i.tax_percentage > 0 AND i.ppn_total > 0
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getSaleInvoiceTaxYearlyReport($year, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, COUNT(*) AS quantity_invoice, SUM(i.service_price) AS service_price, SUM(i.product_price) AS product_price, SUM(i.product_price + i.service_price) AS sub_total, SUM(i.ppn_total) AS total_tax, SUM(i.pph_total) AS total_tax_income, SUM(i.total_price) AS total_price 
                FROM " . InvoiceHeader::model()->tableName() . " i 
                WHERE YEAR(i.invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%' AND i.tax_percentage > 0 AND i.ppn_total > 0" . $branchConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date)
                ORDER BY year_month_value ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleInvoiceCustomerTaxMonthlyReport($year, $month, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':month' => $month,
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, i.customer_id, MAX(c.name) AS customer_name, COUNT(*) AS quantity_invoice, SUM(i.service_price) AS service_price, SUM(i.product_price) AS product_price, SUM(i.product_price + i.service_price) AS sub_total, SUM(i.ppn_total) AS total_tax, SUM(i.pph_total) AS total_tax_income, SUM(i.total_price) AS total_price 
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(i.invoice_date) = :year AND MONTH(i.invoice_date) = :month AND i.status NOT LIKE '%CANCELLED%' AND i.tax_percentage > 0 AND i.ppn_total > 0" . $branchConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), i.customer_id
                ORDER BY year_month_value ASC, c.name ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getYearlyCompanySaleTaxSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, SUM(total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%' AND c.customer_type = 'Company' AND i.tax_percentage > 0 AND i.ppn_total > 0
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getYearlyIndividualSaleTaxSummary($year) {
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, branch_id, MIN(b.name) AS branch_name, SUM(total_price) AS total_price
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = i.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%' AND c.customer_type = 'Individual' AND i.tax_percentage > 0 AND i.ppn_total > 0
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), branch_id
                ORDER BY year_month_value ASC, branch_id ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));

        return $resultSet;
    }
    
    public static function getIndividualCashDailySummary($transactionDate) {
        
        $sql = "SELECT r.branch_id, SUM(r.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " r
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
                WHERE c.customer_type = 'Individual' AND r.invoice_date LIKE :transaction_date
                GROUP BY r.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':transaction_date' => $transactionDate . '%',
        ));

        return $resultSet;
    }
    
    public static function getCompanyCashDailySummary($transactionDate) {
        
        $sql = "SELECT r.branch_id, SUM(r.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " r
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
                WHERE c.customer_type = 'Company' AND r.invoice_date LIKE :transaction_date
                GROUP BY r.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':transaction_date' => $transactionDate . '%',
        ));

        return $resultSet;
    }
}
