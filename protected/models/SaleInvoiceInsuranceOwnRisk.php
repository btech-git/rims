<?php

/**
 * This is the model class for table "{{sale_invoice_insurance_own_risk}}".
 *
 * The followings are the available columns in table '{{sale_invoice_insurance_own_risk}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $amount_invoice
 * @property string $amount_payment
 * @property string $payment_remaining
 * @property string $note
 * @property integer $registration_transaction_id
 * @property integer $customer_id
 * @property integer $vehicle_id
 * @property integer $insurance_company_id
 * @property integer $user_id_created
 * @property integer $user_id_updated
 * @property integer $user_id_cancelled
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property string $cancelled_datetime
 * @property integer $branch_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property Customer $customer
 * @property Vehicle $vehicle
 * @property InsuranceCompany $insuranceCompany
 * @property Users $userIdCreated
 * @property Users $userIdUpdated
 * @property Users $userIdCancelled
 * @property Branch $branch
 */
class SaleInvoiceInsuranceOwnRisk extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'IOR';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sale_invoice_insurance_own_risk}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, registration_transaction_id, customer_id, vehicle_id, insurance_company_id, user_id_created, created_datetime', 'required'),
            array('registration_transaction_id, customer_id, vehicle_id, insurance_company_id, user_id_created, user_id_updated, user_id_cancelled, branch_id', 'numerical', 'integerOnly' => true),
            array('transaction_number, status', 'length', 'max' => 60),
            array('amount_invoice, amount_payment, payment_remaining', 'length', 'max' => 18),
            array('note, updated_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, amount_invoice, amount_payment, payment_remaining, note, registration_transaction_id, customer_id, vehicle_id, insurance_company_id, user_id_created, user_id_updated, user_id_cancelled, created_datetime, updated_datetime, cancelled_datetime, branch_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'paymentInDetails' => array(self::HAS_MANY, 'PaymentInDetail', 'sale_invoice_insurance_own_risk_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'amount_invoice' => 'Amount Invoice',
            'amount_payment' => 'Amount Payment',
            'payment_remaining' => 'Payment Remaining',
            'note' => 'Note',
            'registration_transaction_id' => 'Registration Transaction',
            'customer_id' => 'Customer',
            'vehicle_id' => 'Vehicle',
            'insurance_company_id' => 'Insurance Company',
            'user_id_created' => 'User Id Created',
            'user_id_updated' => 'User Id Updated',
            'user_id_cancelled' => 'User Id Cancelled',
            'created_datetime' => 'Created Datetime',
            'updated_datetime' => 'Updated Datetime',
            'cancelled_datetime' => 'Cancelled Datetime',
            'branch_id' => 'Branch',
            'status' => 'Status',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('amount_invoice', $this->amount_invoice, true);
        $criteria->compare('amount_payment', $this->amount_payment, true);
        $criteria->compare('payment_remaining', $this->payment_remaining, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        
        $saleInvoiceInsuranceOwnRisk = SaleInvoiceInsuranceOwnRisk::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($saleInvoiceInsuranceOwnRisk == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $saleInvoiceInsuranceOwnRisk->branch->code;
            $this->transaction_number = $saleInvoiceInsuranceOwnRisk->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $branchCode, SaleInvoiceInsuranceOwnRisk::CONSTANT, $currentMonth, $currentYear);
    }
    
    public function setCodeNumberByRevision($codeNumberColumnName) {
        list($leftCode, $middleCode, $rightCode) = explode('/', $this->$codeNumberColumnName);
        list($branchCode, $constant) = explode('.', $leftCode);
        list($year, $month) = explode('.', $middleCode);
        list($ordinal, $revisionCode) = explode('.', $rightCode);
        $month = $this->normalizeCnMonthBy($month);
        
        $arr = array('I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $month = $month ? $month - 1 : 0;
        $revisionOrdinal = ord($revisionCode) + 1;
        $this->$codeNumberColumnName = sprintf('%s.%s/%04d.%s/%04d.%c', $branchCode, $constant, $year, $arr[$month], $ordinal, $revisionOrdinal);
    }

}