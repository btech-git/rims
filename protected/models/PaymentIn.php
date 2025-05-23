<?php

/**
 * This is the model class for table "{{payment_in}}".
 *
 * The followings are the available columns in table '{{payment_in}}':
 * @property integer $id
 * @property integer $invoice_id
 * @property string $payment_number
 * @property string $payment_date
 * @property string $payment_time
 * @property string $payment_amount
 * @property string $notes
 * @property integer $customer_id
 * @property integer $vehicle_id
 * @property string $payment_type
 * @property integer $user_id
 * @property integer $branch_id
 * @property string $status
 * @property integer $company_bank_id
 * @property integer $payment_type_id
 * @property integer $is_tax_service
 * @property string $tax_service_amount
 * @property string $created_datetime
 * @property string $cancelled_datetime
 * @property integer $user_id_cancelled
 * @property string $edited_datetime
 * @property integer $user_id_edited
 * @property string $downpayment_amount
 * @property string $discount_product_amount
 * @property string $discount_service_amount
 * @property string $bank_administration_fee
 * @property string $merimen_fee
 * @property integer $insurance_company_id
 * @property string $bank_fee_amount
 *
 * The followings are the available model relations:
 * @property InvoiceHeader $invoice
 * @property Customer $customer
 * @property Vehicle $vehicle
 * @property Users $user
 * @property UserIdCancelled $userIdCancelled
 * @property UserIdEdited $userIdEdited
 * @property Branch $branch
 * @property CompanyBank $companyBank
 * @property PaymentInImages[] $paymentInImages
 * @property PaymentInApproval[] $paymentInApprovals
 * @property PaymentType $paymentType
 * @property PaymentInDetails[] $paymentInDetails
 * @property InsuranceCompany $insuranceCompany
 */
class PaymentIn extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'Pin';

    /**
     * @return string the associated database table name
     */
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    const ADD_SERVICE_TAX = 1;
    const NON_SERVICE_TAX = 2;
    const INCLUDE_SERVICE_TAX = 3;

    const ADD_SERVICE_TAX_LITERAL = 'Add Pph';
    const NON_SERVICE_TAX_LITERAL = 'Non Pph';
    const INCLUDE_SERVICE_TAX_LITERAL = 'Include Pph';

    public $images;
    public $invoice_number;
    public $invoice_status;
    public $customer_name;

    public function tableName() {
        return '{{payment_in}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('notes, payment_time, payment_date, payment_amount, downpayment_amount, user_id, branch_id, status, is_tax_service, tax_service_amount, payment_type_id', 'required'),
            array('invoice_id, customer_id, vehicle_id, user_id, branch_id, company_bank_id, cash_payment_type, bank_id, payment_type_id, is_tax_service, user_id_cancelled, insurance_company_id, user_id_edited', 'numerical', 'integerOnly' => true),
            array('payment_number', 'length', 'max' => 50),
            array('payment_amount, tax_service_amount, downpayment_amount, discount_product_amount, discount_service_amount, bank_administration_fee, merimen_fee, bank_fee_amount', 'length', 'max' => 18),
            array('payment_type, status', 'length', 'max' => 30),
            array('nomor_giro', 'length', 'max' => 20),
            array('payment_number', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, invoice_id, payment_number, payment_date, created_datetime, payment_amount, notes, downpayment_amount, customer_id, vehicle_id, payment_type, user_id, branch_id, insurance_company_id, invoice_status, status, nomor_giro, company_bank_id, cash_payment_type, bank_id, invoice_number, customer_name, payment_type_id, is_tax_service, tax_service_amount, cancelled_datetime, user_id_cancelled, edited_datetime, user_id_edited, discount_product_amount, discount_service_amount, bank_administration_fee, merimen_fee, bank_fee_amount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoice' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdCancelled' => array(self::BELONGS_TO, 'User', 'user_id_cancelled'),
            'userIdEdited' => array(self::BELONGS_TO, 'User', 'user_id_edited'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'companyBank' => array(self::BELONGS_TO, 'CompanyBank', 'company_bank_id'),
            'paymentInImages' => array(self::HAS_MANY, 'PaymentInImages', 'payment_in_id'),
            'paymentInApprovals' => array(self::HAS_MANY, 'PaymentInApproval', 'payment_in_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
            'paymentInDetails' => array(self::HAS_MANY, 'PaymentInDetail', 'payment_in_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'invoice_id' => 'Invoice',
            'payment_number' => 'Payment Number',
            'payment_date' => 'Payment Date',
            'payment_time' => 'Payment Time',
            'payment_amount' => 'Payment Amount',
            'notes' => 'Notes',
            'customer_id' => 'Customer',
            'vehicle_id' => 'Vehicle',
            'payment_type' => 'Payment Type',
            'user_id' => 'User',
            'branch_id' => 'Branch',
            'status' => 'Status',
            'company_bank_id' => 'Company Bank',
            'nomor_giro' => 'Nomor Giro',
            'cash_payment_type' => 'Cash Payment Type',
            'bank_id' => 'Bank',
            'payment_type_id' => 'Payment Type',
            'is_tax_service' => 'PPh',
            'tax_service_amount' => 'PPh Amount',
            'downpayment_amount' => 'Downpayment',
            'insurance_company_id' => 'Insurance Company',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_id', $this->invoice_id);
        $criteria->compare('t.payment_number', $this->payment_number, true);
        $criteria->compare('t.payment_date', $this->payment_date, true);
        $criteria->compare('t.payment_time', $this->payment_time, true);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.notes', $this->notes, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('nomor_giro', $this->nomor_giro, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('t.bank_id', $this->bank_id);
        $criteria->compare('t.payment_type_id', $this->payment_type_id);
        $criteria->compare('is_tax_service', $this->is_tax_service);
        $criteria->compare('tax_service_amount', $this->tax_service_amount);
        $criteria->compare('downpayment_amount', $this->downpayment_amount);
        $criteria->compare('discount_product_amount', $this->discount_product_amount);
        $criteria->compare('discount_service_amount', $this->discount_service_amount);
        $criteria->compare('bank_administration_fee', $this->bank_administration_fee);
        $criteria->compare('merimen_fee', $this->merimen_fee);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);

        $criteria->together = 'true';
        $criteria->with = array('invoice');
        $criteria->compare('invoice.invoice_number', $this->invoice_number, true);
        $criteria->compare('invoice.status', $this->invoice_status, true);
        $criteria->compare('customer.name', $this->customer_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'payment_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByAdmin() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_id', $this->invoice_id);
        $criteria->compare('t.payment_number', $this->payment_number, true);
        $criteria->compare('t.payment_date', $this->payment_date, true);
        $criteria->compare('t.payment_time', $this->payment_time, true);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.notes', $this->notes, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('nomor_giro', $this->nomor_giro, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('t.bank_id', $this->bank_id);
        $criteria->compare('t.payment_type_id', $this->payment_type_id);
        $criteria->compare('is_tax_service', $this->is_tax_service);
        $criteria->compare('tax_service_amount', $this->tax_service_amount);
        $criteria->compare('downpayment_amount', $this->downpayment_amount);
        $criteria->compare('discount_product_amount', $this->discount_product_amount);
        $criteria->compare('discount_service_amount', $this->discount_service_amount);
        $criteria->compare('bank_administration_fee', $this->bank_administration_fee);
        $criteria->compare('merimen_fee', $this->merimen_fee);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);

//        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        $criteria->together = 'true';
        $criteria->with = array('invoice');
        $criteria->compare('invoice.invoice_number', $this->invoice_number, true);
        $criteria->compare('invoice.status', $this->invoice_status, true);
        $criteria->compare('customer.name', $this->customer_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'payment_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PaymentIn the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(payment_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(payment_number, '/', 2), '/', -1), '.', -1)";
        $paymentIn = PaymentIn::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($paymentIn == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $paymentIn->branch->code;
            $this->payment_number = $paymentIn->payment_number;
        }

        $this->setCodeNumberByNext('payment_number', $branchCode, PaymentIn::CONSTANT, $currentMonth, $currentYear);
    }
    
    public function getApprovalStatus() {
        $paymentInApproval = PaymentInApproval::model()->findByAttributes(array('payment_in_id' => $this->id), array('order' => 'id DESC'));
        
        return $paymentInApproval->approval_type;
    }

    public function searchByDailyCashReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_id', $this->invoice_id);
        $criteria->compare('payment_number', $this->payment_number, true);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('payment_type_id', $this->payment_type_id);
        
        $criteria->together = 'true';
        $criteria->with = array('invoice', 'customer');

        $criteria->addCondition("customer.customer_type = 'Company' AND t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function searchByRetailCashDailyReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_id', $this->invoice_id);
        $criteria->compare('payment_number', $this->payment_number, true);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('payment_type_id', $this->payment_type_id);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function getTotalDetail() {
        $total = '0.00';
        
        foreach ($this->paymentInDetails as $detail) {
            $total += $detail->amount + $detail->tax_service_amount;
        }
        
        return $total;
    }
    
    public function getTotalDetailAmount() {
        $total = '0.00';
        
        foreach ($this->paymentInDetails as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
    
    public function getTotalPayment() {
        
        return $this->payment_amount + $this->tax_service_amount + $this->downpayment_amount + $this->discount_product_amount + $this->discount_service_amount + $this->bank_administration_fee + $this->merimen_fee;
    }
    
    public function getTotalInvoice() {
        $total = '0.00';
        
        foreach ($this->paymentInDetails as $detail) {
            $total += $detail->total_invoice;
        }
        
        return $total;
    }
    
    public function getTotalServiceTax() {
        $total = '0.00';
        
        foreach ($this->paymentInDetails as $detail) {
            $total += $detail->tax_service_amount;
        }
        
        return $total;
    }
    
    public function searchByPendingJournal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.invoice_id', $this->invoice_id);
        $criteria->compare('t.payment_number', $this->payment_number, true);
        $criteria->compare('t.payment_date', $this->payment_date, true);
        $criteria->compare('t.payment_time', $this->payment_time, true);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.notes', $this->notes, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.status', 'Approved');
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('nomor_giro', $this->nomor_giro, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('t.bank_id', $this->bank_id);
        $criteria->compare('t.payment_type_id', $this->payment_type_id);
        $criteria->compare('is_tax_service', $this->is_tax_service);
        $criteria->compare('tax_service_amount', $this->tax_service_amount);

        $criteria->addCondition("substring(t.payment_number, 1, (length(t.payment_number) - 2)) NOT IN (
            SELECT substring(kode_transaksi, 1, (length(kode_transaksi) - 2))  
            FROM " . JurnalUmum::model()->tableName() . "
        )");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'payment_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public static function getPaymentByTypeList($month, $year, $branchId) {
        $branchConditionSql = '';
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        if (!empty($branchId)) {
            $branchConditionSql = " AND pi.branch_id = :branch_id";
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT pi.payment_date, pi.payment_type_id, MIN(pt.name) AS payment_type, COALESCE(SUM(pi.payment_amount), 0) AS total_amount
                FROM " . PaymentIn::model()->tableName() . " pi
                INNER JOIN " . PaymentType::model()->tableName() . " pt ON pt.id = pi.payment_type_id
                WHERE YEAR(pi.payment_date) = :year AND MONTH(pi.payment_date) = :month AND pi.status IN ('Approved') AND pt.id NOT IN (2, 12)" . $branchConditionSql . "
                GROUP BY pi.payment_date, pi.payment_type_id
                ORDER BY pi.payment_date";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
