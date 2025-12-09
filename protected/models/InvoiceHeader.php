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
 * @property integer $is_new_customer
 * @property string $warranty_date
 * @property string $warranty_feedback
 * @property string $warranty_input_date_time
 * @property integer $warranty_input_user_id
 * @property string $follow_up_date
 * @property string $follow_up_feedback
 * @property string $follow_up_input_date_time
 * @property integer $follow_up_input_user_id
 * @property string $package_price
 * @property string $transaction_tax_number
 * @property string $grand_total_coretax
 * @property string $tax_amount_coretax
 * @property string $coretax_receipt_number
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
 * @property WarrantyInputUser $warrantyInputUser
 * @property FollowUpInputUser $followUpInputUser
 */
class InvoiceHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'INV';

    public $customer_name;
    public $invoice_date_to;
    public $due_date_to;
    public $customer_type;
    public $plate_number;
    public $search_product;
    public $search_service;

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
            array('invoice_number, invoice_date, due_date, reference_type, branch_id, user_id, status, total_discount, total_price, tax_percentage, number_of_print, package_price, grand_total_coretax, tax_amount_coretax', 'required'),
            array('reference_type, sales_order_id, registration_transaction_id, customer_id, vehicle_id, ppn, pph, branch_id, user_id, supervisor_id, total_product, total_service, total_quick_service, coa_bank_id_estimate, tax_percentage, user_id_cancelled, insurance_company_id, number_of_print, user_id_edited, user_id_printed, is_new_customer, warranty_input_user_id, follow_up_input_user_id', 'numerical', 'integerOnly' => true),
            array('invoice_number, transaction_tax_number, coretax_receipt_number', 'length', 'max' => 60),
            array('status', 'length', 'max' => 30),
            array('service_price, product_price, quick_service_price, pph_total, ppn_total, total_discount, total_price, payment_amount, payment_left, package_price, grand_total_coretax, tax_amount_coretax', 'length', 'max' => 18),
            array('in_words, note, payment_date_estimate, warranty_date, follow_up_date, warranty_feedback, follow_up_feedback, warranty_input_date_time, follow_up_input_date_time', 'safe'),
            array('invoice_number', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, invoice_number, invoice_date, due_date, number_of_print, reference_type, sales_order_id, registration_transaction_id, search_service, search_product, customer_id, vehicle_id, ppn, pph, branch_id, user_id, supervisor_id, status, service_price, product_price, quick_service_price, total_product, warranty_date, follow_up_date, insurance_company_id, total_service, total_quick_service, pph_total, ppn_total, total_discount, total_price, in_words, note, customer_name, invoice_date_to, due_date_to, payment_amount, payment_left,customer_type, payment_date_estimate, coa_bank_id_estimate, plate_number, tax_percentage, created_datetime, cancelled_datetime, user_id_cancelled, edited_datetime, user_id_edited, user_id_printed, is_new_customer, warranty_input_user_id, follow_up_input_user_id, warranty_feedback, follow_up_feedback, warranty_input_date_time, follow_up_input_date_time, package_price, grand_total_coretax, tax_amount_coretax, coretax_receipt_number', 'safe', 'on' => 'search'),
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
            'warrantyInputUser' => array(self::BELONGS_TO, 'User', 'warranty_input_user_id'),
            'followUpInputUser' => array(self::BELONGS_TO, 'User', 'follow_up_input_user_id'),
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
            'is_new_customer' => 'New Customer',
            'transaction_tax_number' => 'F. Pajak #',
            'coretax_receipt_number' => 'Bupot #',
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
        $criteria->compare('t.is_new_customer', $this->is_new_customer);

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
        return $this->service_price + $this->product_price + $this->package_price;
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
                WHERE payment_left > 0 AND invoice_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'";
                
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
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM invoice_date) AS year_month_value, COUNT(*) AS quantity_invoice, SUM(i.service_price) AS service_price, 
                SUM(i.product_price) AS product_price, SUM(i.product_price + i.service_price) AS sub_total, SUM(i.ppn_total) AS total_tax, 
                SUM(i.pph_total) AS total_tax_income, SUM(i.total_price) AS total_price 
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
    
    public function searchByFollowUp() {
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
        $criteria->compare('t.total_discount', $this->total_discount, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('t.number_of_print', $this->number_of_print);
        $criteria->compare('t.is_new_customer', $this->is_new_customer);

        $criteria->together = 'true';
        $criteria->with = array('customer', 'vehicle', 'registrationTransaction');
        
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
    
    public function getWarrantyFollowUpDate() {
        return date('Y-m-d', strtotime('+3 days', strtotime($this->invoice_date))); 
    }
    
    public function getServiceFollowUpDate() {
        return date('Y-m-d', strtotime('+3 months', strtotime($this->invoice_date))); 
    }
    
    public function getLastInvoiceDaysNumber() {
        $dateDiff = date_diff(date_create($this->invoice_date), date_create(date('Y-m-d')));
        
        return $dateDiff->format("%a days");
    }
    
    public function searchByPendingFollowUp() {
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
        $criteria->compare('t.total_discount', $this->total_discount, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('t.number_of_print', $this->number_of_print);
        $criteria->compare('t.is_new_customer', $this->is_new_customer);

        $criteria->together = 'true';
        $criteria->with = array('customer', 'vehicle', 'registrationTransaction');
        
        $followUpDate = date('Y-m-d', strtotime('-6 months', strtotime(date('Y-m-d')))); 
        $criteria->addCondition('t.invoice_date >= :follow_up_date AND t.follow_up_feedback IS NULL AND t.follow_up_input_user_id IS NULL AND t.status IN ("PAID", "CLEAR")');
        $criteria->params[':follow_up_date'] = $followUpDate;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'follow_up_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public function searchByPendingWarranty() {
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
        $criteria->compare('t.total_discount', $this->total_discount, true);
        $criteria->compare('t.total_price', $this->total_price, true);
        $criteria->compare('t.in_words', $this->in_words, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('t.number_of_print', $this->number_of_print);
        $criteria->compare('t.is_new_customer', $this->is_new_customer);

        $criteria->together = 'true';
        $criteria->with = array('customer', 'vehicle', 'registrationTransaction');
        
        $followUpDate = date('Y-m-d', strtotime('-3 months', strtotime(date('Y-m-d')))); 
        $criteria->addCondition('t.invoice_date >= :follow_up_date AND t.warranty_feedback IS NULL AND t.warranty_input_user_id IS NULL AND t.status IN ("PAID", "CLEAR")');
        $criteria->params[':follow_up_date'] = $followUpDate;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'warranty_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public static function getSaleInvoiceCarSubModelMonthlyData($year, $month, $branchId, $carMake, $carModel) {
        $branchConditionSql = '';
        $carMakeConditionSql = '';
        $carModelConditionSql = '';
        
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($carMake)) {
            $carMakeConditionSql = ' AND v.car_make_id = :car_make_id';
            $params[':car_make_id'] = $carMake;
        }
        
        if (!empty($carModel)) {
            $carModelConditionSql = ' AND v.car_model_id = :car_model_id';
            $params[':car_model_id'] = $carModel;
        }
        
        $sql = "SELECT s.id AS car_sub_model_id, SUBSTRING_INDEX(SUBSTRING_INDEX(t.invoice_date, ' ', 1), '-', 3) AS transaction_date, 
                MAX(s.name) AS car_sub_model_name, MAX(c.name) AS car_model_name, MAX(m.name) AS car_make_name, COUNT(*) AS total_quantity_vehicle
                FROM " . InvoiceHeader::model()->tableName() . " t
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = t.vehicle_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s ON s.id = v.car_sub_model_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " c ON c.id = s.car_model_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " m ON m.id = c.car_make_id
                WHERE YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND t.status NOT LIKE '%CANCELLED%'" . $branchConditionSql . $carMakeConditionSql . $carModelConditionSql . "
                GROUP BY s.id, SUBSTRING_INDEX(SUBSTRING_INDEX(t.invoice_date, ' ', 1), '-', 3)
                ORDER BY m.name ASC, c.name ASC, s.name ASC, transaction_date ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getSaleInvoiceCarSubModelYearlyData($year, $branchId, $carMake, $carModel) {
        $branchConditionSql = '';
        $carMakeConditionSql = '';
        $carModelConditionSql = '';
        
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($carMake)) {
            $carMakeConditionSql = ' AND v.car_make_id = :car_make_id';
            $params[':car_make_id'] = $carMake;
        }
        
        if (!empty($carModel)) {
            $carModelConditionSql = ' AND v.car_model_id = :car_model_id';
            $params[':car_model_id'] = $carModel;
        }
        
        $sql = "SELECT EXTRACT(YEAR_MONTH FROM i.invoice_date) AS year_month_value, v.car_sub_model_id AS car_sub_model_id, COUNT(*) AS total_quantity_vehicle, 
                MAX(s.name) AS car_sub_model_name, MAX(c.name) AS car_model_name, MAX(m.name) AS car_make_name
                FROM " . InvoiceHeader::model()->tableName() . " i
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s ON s.id = v.car_sub_model_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " c ON c.id = s.car_model_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " m ON m.id = c.car_make_id
                WHERE YEAR(i.invoice_date) = :year AND i.status NOT LIKE '%CANCELLED%'" . $branchConditionSql . $carMakeConditionSql . $carModelConditionSql . "
                GROUP BY EXTRACT(YEAR_MONTH FROM invoice_date), v.car_sub_model_id
                ORDER BY car_make_name ASC, car_model_name ASC, car_sub_model_name ASC, year_month_value ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getProductTireLists() {
        $products = array();

        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id) && $detail->product->product_master_category_id == 4) {
                $products[] =  $detail->product->name . ', ';
            }
        }

        return $this->search_product = implode('', $products);
    }

    public function getProductTireAmount() {
        $amount = '0.00';

        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id) && $detail->product->product_master_category_id == 4) {
                $amount +=  $detail->total_price;
            }
        }

        return $amount;
    }

    public function getProductOilLists() {
        $products = array();

        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id) && $detail->product->product_master_category_id == 6) {
                $products[] =  $detail->product->name . ', ';
            }
        }

        return $this->search_product = implode('', $products);
    }

    public function getProductOilAmount() {
        $amount = '0.00';

        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id) && $detail->product->product_master_category_id == 6) {
                $amount +=  $detail->total_price;
            }
        }

        return $amount;
    }

    public function getProductAccessoriesLists() {
        $products = array();

        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id) && $detail->product->product_master_category_id == 9) {
                $products[] =  $detail->product->name . ', ';
            }
        }

        return $this->search_product = implode('', $products);
    }

    public function getProductAccessoriesAmount() {
        $amount = '0.00';

        foreach ($this->invoiceDetails as $detail) {
            if (!empty($detail->product_id) && $detail->product->product_master_category_id == 9) {
                $amount +=  $detail->total_price;
            }
        }

        return $amount;
    }

    public function getProductLists() {
        $products = array();

        foreach ($this->invoiceDetails as $detail) {
            $products[] = empty($detail->product_id) ? '' : $detail->product->name . ', ';
        }

        return $this->search_product = implode('', $products);
    }

    public function getServiceLists() {
        $services = array();

        foreach ($this->invoiceDetails as $detail) {
            $services[] = empty($detail->service_id) ? '' : $detail->service->name . ', ';
        }

        return $this->search_service = implode('', $services);
    }
    
    public static function getDailyMultipleBranchSaleReport($startDate, $endDate) {
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT h.branch_id, MAX(b.name) AS branch_name, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE h.invoice_date BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'
                GROUP BY h.branch_id
                ORDER BY MAX(b.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlySingleBranchSaleReport($year, $month, $branchId) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
            ':branch_id' => $branchId,
        );
        
        $sql = "SELECT DAY(h.invoice_date) AS day, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.branch_id = :branch_id AND h.status NOT LIKE '%CANCEL%'
                GROUP BY DAY(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlyMultipleBranchSaleReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT h.branch_id, MAX(b.name) AS branch_name, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.status NOT LIKE '%CANCEL%'
                GROUP BY h.branch_id
                ORDER BY MAX(b.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlySingleBranchSaleReport($year, $branchId) {
        $params = array(
            ':year' => $year,
            ':branch_id' => $branchId,
        );
        
        $sql = "SELECT MONTH(h.invoice_date) AS month, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND h.branch_id = :branch_id AND h.status NOT LIKE '%CANCEL%'
                GROUP BY MONTH(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlyMultipleBranchSaleReport($year) {
        $params = array(
            ':year' => $year,
        );
        
        $sql = "SELECT h.branch_id, MAX(b.name) AS branch_name, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND h.status NOT LIKE '%CANCEL%'
                GROUP BY h.branch_id
                ORDER BY MAX(b.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getDailyMultipleEmployeeSaleReport($startDate, $endDate) {
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT r.employee_id_sales_person, MAX(e.name) AS employee_name, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_sales_person
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE h.invoice_date BETWEEN :start_date AND :end_date AND r.employee_id_sales_person IS NOT NULL AND h.status NOT LIKE '%CANCEL%' AND 
                    r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_sales_person
                ORDER BY MAX(e.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlyMultipleEmployeeSaleReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT r.employee_id_sales_person, MAX(e.name) AS employee_name, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_sales_person
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND r.employee_id_sales_person IS NOT NULL AND 
                    h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_sales_person
                ORDER BY MAX(e.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlyMultipleEmployeeSaleReport($year) {
        $params = array(
            ':year' => $year,
        );
        
        $sql = "SELECT r.employee_id_sales_person, MAX(e.name) AS employee_name, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_sales_person
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND r.employee_id_sales_person IS NOT NULL AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_sales_person
                ORDER BY MAX(e.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlySingleEmployeeSaleReport($year, $month, $employeeId) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
            ':employee_id_sales_person' => $employeeId,
        );
        
        $sql = "SELECT DAY(h.invoice_date) AS day, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_sales_person
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND r.employee_id_sales_person = :employee_id_sales_person AND 
                    h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY DAY(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlySingleEmployeeSaleReport($year, $employeeId) {
        $params = array(
            ':year' => $year,
            ':employee_id_sales_person' => $employeeId,
        );
        
        $sql = "SELECT MONTH(h.invoice_date) AS month, COUNT(h.customer_id) AS customer_quantity, 
                    COUNT(CASE WHEN h.is_new_customer = 0 THEN 1 END) AS customer_repeat_quantity, COUNT(CASE WHEN h.is_new_customer = 1 THEN 1 END) AS customer_new_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service, 
                    SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_sales_person
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND r.employee_id_sales_person = :employee_id_sales_person AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY MONTH(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getDailyMultipleMechanicTransactionReport($startDate, $endDate) {
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT r.employee_id_assign_mechanic, MAX(e.name) AS employee_name, COUNT(h.vehicle_id) AS vehicle_quantity, COUNT(r.work_order_number) AS work_order_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_assign_mechanic
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE h.invoice_date BETWEEN :start_date AND :end_date AND r.employee_id_assign_mechanic IS NOT NULL AND h.status NOT LIKE '%CANCEL%' AND 
                    r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_assign_mechanic
                ORDER BY e.name ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlyMultipleMechanicTransactionReport($year, $month) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT r.employee_id_assign_mechanic, MAX(e.name) AS employee_name, COUNT(h.vehicle_id) AS vehicle_quantity, COUNT(r.work_order_number) AS work_order_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_assign_mechanic
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND r.employee_id_assign_mechanic IS NOT NULL AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_assign_mechanic
                ORDER BY MAX(e.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlyMultipleMechanicTransactionReport($year) {
        $params = array(
            ':year' => $year,
        );
        
        $sql = "SELECT r.employee_id_assign_mechanic, MAX(e.name) AS employee_name, COUNT(h.vehicle_id) AS vehicle_quantity, COUNT(r.work_order_number) AS work_order_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_assign_mechanic
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND r.employee_id_assign_mechanic IS NOT NULL AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_assign_mechanic
                ORDER BY MAX(e.name) ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlySingleMechanicTransactionReport($year, $month, $employeeId) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
            ':employee_id_assign_mechanic' => $employeeId,
        );
        
        $sql = "SELECT DAY(h.invoice_date) AS day, COUNT(h.vehicle_id) AS vehicle_quantity, COUNT(r.work_order_number) AS work_order_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_assign_mechanic
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND r.employee_id_assign_mechanic = :employee_id_assign_mechanic AND 
                    h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY DAY(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlySingleMechanicTransactionReport($year, $employeeId) {
        $params = array(
            ':year' => $year,
            ':employee_id_assign_mechanic' => $employeeId,
        );
        
        $sql = "SELECT MONTH(h.invoice_date) AS month, COUNT(h.vehicle_id) AS vehicle_quantity, COUNT(r.work_order_number) AS work_order_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Individual' THEN 1 END) AS customer_retail_quantity, 
                    COUNT(CASE WHEN c.customer_type = 'Company' THEN 1 END) AS customer_company_quantity, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Employee::model()->tableName() . " e ON e.id = r.employee_id_assign_mechanic
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND r.employee_id_assign_mechanic = :employee_id_assign_mechanic AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY MONTH(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }  
    
    public function searchByTransactionHeaderInfo($employeeId, $startDate, $endDate, $page) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array('registrationTransaction');

        $criteria->compare('registrationTransaction.employee_id_sales_person', $employeeId);
        $criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $criteria->addCondition("t.status NOT LIKE '%CANCEL%' AND registrationTransaction.status NOT LIKE '%CANCEL%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
                'currentPage' => $page - 1,
            ),
        ));
    }

    public function searchByTransactionHeaderBranchInfo($branchId, $startDate, $endDate, $page) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.branch_id', $branchId);
        $criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $criteria->addCondition("t.status NOT LIKE '%CANCEL%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
                'currentPage' => $page - 1,
            ),
        ));
    }

    public function searchByTransactionInfo($carSubModelId, $startDate, $endDate, $page) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'vehicle'
                ),
            ),
        );

        $criteria->compare('vehicle.car_sub_model_id', $carSubModelId);
        $criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $criteria->addCondition("t.status NOT LIKE '%CANCEL%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.invoice_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
                'currentPage' => $page - 1,
            ),
        ));
    }
    
    public static function getCustomerSaleReport($startDate, $endDate, $customerId, $branchId, $taxValue, $customerType) {
        $taxValueConditionSql = '';
        $branchConditionSql = '';
        $customerConditionSql = '';
        $customerTypeConditionSql = '';
      
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($taxValue)) {
            $taxValueConditionSql = ' AND ppn = :tax_value';
            $params[':tax_value'] = $taxValue;
        }

        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($customerId)) {
            $customerConditionSql = ' AND c.id = :customer_id';
            $params[':customer_id'] = $customerId;
        }
        
        if (!empty($customerType)) {
            $customerTypeConditionSql = ' AND c.customer_type = :customer_type';
            $params[':customer_type'] = $customerType;
        }
        
        $sql = "SELECT i.customer_id, c.name AS customer_name, c.customer_type AS customer_type, i.grand_total
                FROM " . Customer::model()->tableName() . " c
                INNER JOIN (
                    SELECT customer_id, SUM(total_price) AS grand_total
                    FROM " . InvoiceHeader::model()->tableName() . " 
                    WHERE invoice_date BETWEEN :start_date AND :end_date AND status NOT LIKE '%CANCEL%'" . $branchConditionSql . $taxValueConditionSql . "
                    GROUP BY customer_id
                ) i ON c.id = i.customer_id
                WHERE c.status = 'Active'" . $customerConditionSql . $customerTypeConditionSql . "
                ORDER BY c.name ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getVehicleSaleReport($startDate, $endDate, $vehicleId, $branchId) {
        $branchConditionSql = '';
        $vehicleConditionSql = '';
      
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($vehicleId)) {
            $vehicleConditionSql = ' AND i.vehicle_id = :vehicle_id';
            $params[':vehicle_id'] = $vehicleId;
        }
        
        $sql = "SELECT i.vehicle_id, MAX(v.plate_number) AS plate_number, MAX(k.name) AS car_make, MAX(d.name) AS car_model, MAX(s.name) AS car_sub_model, 
                    MAX(c.name) AS customer_name, SUM(total_price) AS grand_total
                FROM " . InvoiceHeader::model()->tableName() . "  i 
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " k ON k.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " d ON d.id = v.car_model_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s ON s.id = v.car_sub_model_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = v.customer_id
                WHERE i.invoice_date BETWEEN :start_date AND :end_date AND i.status NOT LIKE '%CANCEL%'" . $vehicleConditionSql . $branchConditionSql . "
                GROUP BY i.vehicle_id
                ORDER BY v.plate_number ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlyCustomerInvoiceReport($year) {
      
        $sql = "SELECT i.customer_id, MONTH(i.invoice_date) AS invoice_month, MAX(c.name) AS customer_name, SUM(i.total_price) AS invoice_total
                FROM " . InvoiceHeader::model()->tableName() . "  i 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(i.invoice_date) = :year AND c.customer_type = 'Company' AND i.user_id_cancelled IS NULL
                GROUP BY i.customer_id, MONTH(i.invoice_date)
                ORDER BY customer_name ASC, invoice_month ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));
        
        return $resultSet;
    }    
    
    public static function getYearlyCustomerPaymentReport($year) {
      
        $sql = "SELECT i.customer_id, MONTH(i.payment_date) AS payment_month, MAX(c.name) AS customer_name, 
                    SUM(i.payment_amount + tax_service_amount + downpayment_amount + discount_product_amount + discount_service_amount + 
                    bank_administration_fee + merimen_fee + bank_fee_amount) AS payment_total
                FROM " . PaymentIn::model()->tableName() . "  i
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE YEAR(i.payment_date) = :year AND c.customer_type = 'Company' AND i.user_id_cancelled IS NULL
                GROUP BY i.customer_id, MONTH(i.payment_date)
                ORDER BY customer_name ASC, payment_month ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':year' => $year,
        ));
        
        return $resultSet;
    }    
    
    public static function getBeginningCustomerInvoiceReport($year) {
      
        $sql = "SELECT i.customer_id, MAX(c.name) AS customer_name, SUM(i.total_price) AS beginning_invoice_total
                FROM " . InvoiceHeader::model()->tableName() . "  i 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE i.invoice_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND i.invoice_date < :invoice_date AND c.customer_type = 'Company' AND 
                    i.user_id_cancelled IS NULL
                GROUP BY i.customer_id";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':invoice_date' => $year . '-01-01',
        ));
        
        return $resultSet;
    }    
  
    public static function getBeginningCustomerPaymentReport($year) {
      
        $sql = "SELECT i.customer_id, MAX(c.name) AS customer_name, SUM(i.payment_amount + tax_service_amount + downpayment_amount + discount_product_amount + 
                    discount_service_amount + bank_administration_fee + merimen_fee + bank_fee_amount) AS beginning_payment_total
                FROM " . PaymentIn::model()->tableName() . "  i
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                WHERE i.payment_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND i.payment_date < :payment_date AND c.customer_type = 'Company' AND 
                    i.user_id_cancelled IS NULL
                GROUP BY i.customer_id";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':payment_date' => $year . '-01-01',
        ));
        
        return $resultSet;
    }    
    
    public static function getCustomerCompanyTopSaleReport($year, $branchId) {
        $branchConditionSql = '';
      
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT h.customer_id, MAX(c.name) AS customer_name, MAX(c.customer_type) AS customer_type, MAX(c.mobile_phone) AS customer_phone, 
                    COUNT(h.id) AS invoice_quantity, SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND c.customer_type = 'Company' AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . " 
                GROUP BY h.customer_id
                ORDER BY grand_total DESC, invoice_quantity DESC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getCustomerIndividualTopSaleReport($year, $branchId) {
        $branchConditionSql = '';
      
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT h.customer_id, MAX(c.name) AS customer_name, MAX(c.customer_type) AS customer_type, MAX(c.mobile_phone) AS customer_phone, 
                    COUNT(h.id) AS invoice_quantity, SUM(h.product_price) AS total_product, SUM(h.total_price) AS grand_total, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
                WHERE YEAR(h.invoice_date) = :year AND c.customer_type = 'Individual' AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . " 
                GROUP BY h.customer_id
                ORDER BY grand_total DESC, invoice_quantity DESC
                LIMIT 50";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMultipleVehicleSaleReport($year, $branchId) {
        $branchConditionSql = '';
      
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT h.vehicle_id, MAX(v.plate_number) AS plate_number, MAX(k.name) AS car_make, MAX(d.name) AS car_model, MAX(s.name) AS car_sub_model, 
                    MAX(r.name) AS color_name, MAX(c.customer_type) AS customer_type, MAX(v.customer_id) AS customer_id, MAX(c.name) AS customer_name, 
                    MAX(c.mobile_phone) AS customer_phone, COUNT(h.id) AS invoice_quantity, SUM(h.product_price) AS total_product, 
                    SUM(h.total_price) AS grand_total, SUM(h.service_price) AS total_service
                FROM " . InvoiceHeader::model()->tableName() . " h 
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = h.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " k ON k.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " d ON d.id = v.car_model_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s ON s.id = v.car_sub_model_id
                INNER JOIN " . Colors::model()->tableName() . " r ON r.id = v.color_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = v.customer_id
                WHERE YEAR(h.invoice_date) = :year AND h.status NOT LIKE '%CANCEL%'" . $branchConditionSql . " 
                GROUP BY h.vehicle_id
                ORDER BY grand_total DESC, invoice_quantity DESC
                LIMIT 50";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getReceivableIncomingDueDate() {
        $sql = "SELECT i.id, i.invoice_number, i.invoice_date, i.due_date, c.name as customer, v.plate_number, i.total_price, i.payment_amount, i.payment_left
                FROM " . InvoiceHeader::model()->tableName() . " i 
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
                WHERE due_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND DATE_ADD(NOW(), INTERVAL 30 DAY) AND payment_left > 100 AND
                    user_id_cancelled IS NULL
                ORDER BY i.due_date ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
    
    public static function getSaleByProjectReport($startDate, $endDate, $branchId, $customerId) {
        $branchConditionSql = '';
        $customerConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($customerId)) {
            $customerConditionSql = ' AND r.customer_id = :customer_id';
            $params[':customer_id'] = $customerId;
        }
        
        $sql = "
            SELECT r.id, r.customer_id, r.invoice_number, r.invoice_date, d.product_id, p.name AS product, d.service_id, s.name AS service, d.quantity, 
                d.unit_price, d.total_price, v.plate_number AS plate_number, p.hpp, c.name AS customer_name
            FROM " . InvoiceHeader::model()->tableName() . " r
            INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON r.id = d.invoice_id
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
            LEFT OUTER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
            LEFT OUTER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
            WHERE substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCELLED%' AND c.customer_type = 'Company'" . 
                $branchConditionSql . $customerConditionSql . "
            ORDER BY r.invoice_date ASC, r.invoice_number ASC
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
