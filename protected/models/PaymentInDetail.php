<?php

/**
 * This is the model class for table "{{payment_in_detail}}".
 *
 * The followings are the available columns in table '{{payment_in_detail}}':
 * @property integer $id
 * @property string $total_invoice
 * @property string $amount
 * @property string $memo
 * @property integer $payment_in_id
 * @property integer $invoice_header_id
 * @property integer $is_tax_service
 * @property string $tax_service_amount
 * @property string $tax_service_percentage
 * @property string $discount_amount
 * @property string $bank_administration_fee
 * @property string $merimen_fee
 * @property string $downpayment_amount
 * @property integer $registration_transaction_id
 *
 * The followings are the available model relations:
 * @property PaymentIn $paymentIn
 * @property InvoiceHeader $invoiceHeader
 * @property RegistrationTransaction $registrationTransaction
 */
class PaymentInDetail extends CActiveRecord {

    const ADD_SERVICE_TAX = 1;
    const NON_SERVICE_TAX = 2;
    const INCLUDE_SERVICE_TAX = 3;

    const ADD_SERVICE_TAX_LITERAL = 'Add Pph';
    const NON_SERVICE_TAX_LITERAL = 'Non Pph';
    const INCLUDE_SERVICE_TAX_LITERAL = 'Include Pph';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{payment_in_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_in_id', 'required'),
            array('payment_in_id, invoice_header_id, is_tax_service, registration_transaction_id', 'numerical', 'integerOnly' => true),
            array('total_invoice, amount, tax_service_amount, discount_amount, bank_administration_fee, merimen_fee, downpayment_amount', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 100),
            array('tax_service_percentage', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, total_invoice, amount, memo, payment_in_id, invoice_header_id, is_tax_service, tax_service_amount, downpayment_amount, tax_service_percentage, discount_amount, bank_administration_fee, merimen_fee, registration_transaction_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentIn' => array(self::BELONGS_TO, 'PaymentIn', 'payment_in_id'),
            'invoiceHeader' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_header_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total_invoice' => 'Total Invoice',
            'amount' => 'Amount',
            'memo' => 'Memo',
            'payment_in_id' => 'Payment In',
            'invoice_header_id' => 'Invoice Header',
            'is_tax_service' => 'Is Tax Service',
            'tax_service_amount' => 'Tax Service Amount',
            'tax_service_percentage' => 'Tax Service Percentage',
            'registration_transaction_id' => 'Registration Transaction',
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
        $criteria->compare('total_invoice', $this->total_invoice, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('payment_in_id', $this->payment_in_id);
        $criteria->compare('invoice_header_id', $this->invoice_header_id);
        $criteria->compare('is_tax_service', $this->is_tax_service);
        $criteria->compare('tax_service_amount', $this->tax_service_amount, true);
        $criteria->compare('tax_service_percentage', $this->tax_service_percentage, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PaymentInDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalAmount() {
        return $this->amount + $this->tax_service_amount + $this->discount_amount + $this->bank_administration_fee + $this->merimen_fee + $this->downpayment_amount;
    }
    
    public static function getReceivablePaymentReport($endDate, $invoiceHeaderIds) {
        $invoiceHeaderIdsSql = empty($invoiceHeaderIds) ? 'NULL' : implode(',', $invoiceHeaderIds);
        
        $sql = "SELECT d.invoice_header_id, COALESCE(SUM(d.amount + d.tax_service_amount + d.discount_amount + d.bank_administration_fee + d.merimen_fee + d.downpayment_amount), 0) AS payment_amount
                FROM " . PaymentInDetail::model()->tableName() . " d
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE d.invoice_header_id IN ({$invoiceHeaderIdsSql}) AND h.user_id_cancelled IS NULL AND h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.invoice_header_id";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':end_date' => $endDate,
        ));

        return $resultSet;
    }
}
