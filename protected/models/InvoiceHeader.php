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
 * @property string $total_price
 * @property string $in_words
 * @property string $note
 * @property string $payment_amount
 * @property string $payment_left
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
 */
class InvoiceHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'INV';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InvoiceHeader the static model class
     */
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
            array('invoice_number, invoice_date, due_date, reference_type, branch_id, user_id, status, total_price', 'required'),
            array('reference_type, sales_order_id, registration_transaction_id, customer_id, vehicle_id, ppn, pph, branch_id, user_id, supervisor_id, total_product, total_service, total_quick_service, coa_bank_id_estimate', 'numerical', 'integerOnly' => true),
            array('invoice_number', 'length', 'max' => 50),
            array('status', 'length', 'max' => 30),
            array('service_price, product_price, quick_service_price, pph_total, ppn_total, total_price, payment_amount, payment_left', 'length', 'max' => 18),
            array('in_words, note, payment_date_estimate', 'safe'),
            array('invoice_number', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, invoice_number, invoice_date, due_date, reference_type, sales_order_id, registration_transaction_id, customer_id, vehicle_id, ppn, pph, branch_id, user_id, supervisor_id, status, service_price, product_price, quick_service_price, total_product, total_service, total_quick_service, pph_total, ppn_total, total_price, in_words, note, customer_name, invoice_date_to, due_date_to, payment_amount, payment_left,customer_type, payment_date_estimate, coa_bank_id_estimate, plate_number', 'safe', 'on' => 'search'),
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
            'coaBankIdEstimate' => array(self::BELONGS_TO, 'CompanyBank', 'coa_bank_id_estimate'),
            'paymentIns' => array(self::HAS_MANY, 'PaymentIn', 'invoice_id'),
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
        $criteria->compare('invoice_number', $this->invoice_number, true);
        // $criteria->compare('invoice_date',$this->invoice_date,true);
        // $criteria->compare('due_date',$this->due_date,true);
        $criteria->compare('reference_type', $this->reference_type);
        $criteria->compare('sales_order_id', $this->sales_order_id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('coa_bank_id_estimate', $this->coa_bank_id_estimate);
        $criteria->compare('payment_date_estimate', $this->payment_date_estimate);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
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
        $criteria->compare('note', $this->note, true);

        if ($this->invoice_date != NULL OR $this->invoice_date != NULL) {
            $criteria->addBetweenCondition('invoice_date', $this->invoice_date, $this->invoice_date_to);
            $criteria->addBetweenCondition('due_date', $this->invoice_date, $this->invoice_date_to);
        }

        // $criteria->addCondition('invoice_date < :startDateInvoice AND invoice_date > :endDateInvoice');
        // $criteria->params = array(':startDateInvoice' => $this->invoice_date, ':endDateInvoice' => $this->invoice_date_to);
        // $criteria->addCondition('due_date < :startDateDue OR due_date > :endDateDue', 'OR');
        // $criteria->params = array(':startDateDue' => $this->due_date, ':endDateDue' => $this->due_date_to);


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
                'pageSize' => 10,
            ),
        ));
    }

    public function getSubTotal() {
        return $this->service_price + $this->product_price + $this->quick_service_price;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(invoice_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(invoice_number, '/', 2), '/', -1), '.', -1)";
        $invoiceHeader = InvoiceHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($invoiceHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $invoiceHeader->branch->code;
            $this->invoice_number = $invoiceHeader->invoice_number;
        }

        $this->setCodeNumberByNext('invoice_number', $branchCode, InvoiceHeader::CONSTANT, $currentMonth, $currentYear);
    }
    
    public function getTotalPayment() {
        $total = 0.00;
        
        foreach ($this->paymentIns as $detail) {
            $total += $detail->payment_amount;
        }
        
        return $total;
    }
    
    public function getTotalRemaining() {
        
        return $this->total_price - $this->getTotalPayment();
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
}
