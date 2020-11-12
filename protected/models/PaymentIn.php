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
 *
 * The followings are the available model relations:
 * @property InvoiceHeader $invoice
 * @property Customer $customer
 * @property Vehicle $vehicle
 * @property Users $user
 * @property Branch $branch
 * @property CompanyBank $companyBank
 * @property PaymentInImages[] $paymentInImages
 * @property PaymentInApproval[] $paymentInApprovals
 * @property PaymentType $paymentType
 */
class PaymentIn extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'Pin';

    /**
     * @return string the associated database table name
     */
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

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
            array('invoice_id, payment_number, payment_time, payment_date, payment_amount, notes, customer_id, user_id, branch_id, status', 'required'),
            array('invoice_id, customer_id, vehicle_id, user_id, branch_id, company_bank_id, cash_payment_type, bank_id, payment_type_id', 'numerical', 'integerOnly' => true),
            array('payment_number', 'length', 'max' => 50),
            array('payment_amount', 'length', 'max' => 18),
            array('payment_type, status', 'length', 'max' => 30),
            array('nomor_giro', 'length', 'max' => 20),
            array('payment_number', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, invoice_id, payment_number, payment_date, payment_amount, notes, customer_id, vehicle_id, payment_type, user_id, branch_id,invoice_status, status, nomor_giro, company_bank_id, cash_payment_type, bank_id, invoice_number, customer_name, payment_type_id', 'safe', 'on' => 'search'),
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
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'companyBank' => array(self::BELONGS_TO, 'CompanyBank', 'company_bank_id'),
            'paymentInImages' => array(self::HAS_MANY, 'PaymentInImages', 'payment_in_id'),
            'paymentInApprovals' => array(self::HAS_MANY, 'PaymentInApproval', 'payment_in_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
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
        $criteria->compare('payment_number', $this->payment_number, true);
        $criteria->compare('payment_date', $this->payment_date, true);
        $criteria->compare('payment_time', $this->payment_time, true);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('nomor_giro', $this->nomor_giro, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('bank_id', $this->bank_id);
        $criteria->compare('payment_type_id', $this->payment_type_id);

        $criteria->together = 'true';
        $criteria->with = array('invoice', 'customer');
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

//    public function getTotalAmountWholesale($branchId, $transactionDate) {
//        $sql = "SELECT payment_date, branch_id, customer_id, COALESCE(SUM(payment_amount), 0) AS total_amount
//                FROM " . PaymentIn::model()->tableName() . "
//                WHERE branch_id = :branch_id AND payment_date = :payment_date
//                GROUP BY payment_date, branch_id, customer_id";
//
//        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
//            ':branch_id' => $branchId,
//            ':payment_date' => $transactionDate,
//        ));
//
//        return ($value === false) ? 0 : $value;
//    }

//    public function getTotalAmountRetail($transactionDate) {
//        $sql = "SELECT payment_date, branch_id, payment_type_id, COALESCE(SUM(payment_amount), 0) AS total_amount
//                FROM " . PaymentIn::model()->tableName() . "
//                WHERE payment_date = :payment_date
//                GROUP BY payment_date, branch_id, payment_type_id";
//
//        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
//            ':payment_date' => $transactionDate,
//        ));
//
//        return ($value === false) ? 0 : $value;
//    }
}
