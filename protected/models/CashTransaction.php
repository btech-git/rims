<?php

/**
 * This is the model class for table "{{cash_transaction}}".
 *
 * The followings are the available columns in table '{{cash_transaction}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $transaction_type
 * @property integer $coa_id
 * @property string $debit_amounet
 * @property string $credit_amount
 * @property integer $payment_typ_id
 * @property integer $branch_id
 * @property integer $user_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Coa $coa
 * @property PaymentType $paymentType
 * @property Branch $branch
 * @property Users $user
 * @property CashTransactionApproval[] $cashTransactionApprovals
 * @property CashTransactionDetail[] $cashTransactionDetails
 * @property CashTransactionImages[] $cashTransactionImages
 */
class CashTransaction extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'CASH';

    /**
     * @return string the associated database table name
     */
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    public $coa_code;
    public $coa_name;
    public $coa_opening_balance;
    public $coa_debit;
    public $coa_credit;
    public $images;

    public function tableName() {
        return '{{cash_transaction}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, transaction_type, coa_id, debit_amount, credit_amount, branch_id, user_id, payment_type_id', 'required'),
            array('coa_id, branch_id, user_id, payment_type_id', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 50),
            array('transaction_type', 'length', 'max' => 20),
            array('debit_amount, credit_amount', 'length', 'max' => 18),
            array('status', 'length', 'max' => 30),
            array('transaction_number', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, transaction_type, coa_id, debit_amount, credit_amount, payment_type_id, branch_id, user_id, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
            'cashTransactionApprovals' => array(self::HAS_MANY, 'CashTransactionApproval', 'cash_transaction_id'),
            'cashTransactionDetails' => array(self::HAS_MANY, 'CashTransactionDetail', 'cash_transaction_id'),
            'cashTransactionImages' => array(self::HAS_MANY, 'CashTransactionImages', 'cash_transaction_id'),
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
            'transaction_time' => 'Transaction Time',
            'transaction_type' => 'Transaction Type',
            'coa_id' => 'Coa',
            'debit_amount' => 'Debit Amount',
            'credit_amount' => 'Credit Amount',
            'branch_id' => 'Branch',
            'payment_type_id' => 'Payment Type',
            'user_id' => 'User',
            'status' => 'Status',
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('debit_amount', $this->debit_amount, true);
        $criteria->compare('credit_amount', $this->credit_amount, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('payment_type_id', $this->payment_type_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByDailyCashReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('debit_amount', $this->debit_amount, true);
        $criteria->compare('credit_amount', $this->credit_amount, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
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
     * @return CashTransaction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalDebitAmount($branchId, $transactionDate) {
        $sql = "SELECT transaction_date, branch_id, transaction_type, COALESCE(SUM(debit_amount), 0) AS total_amount
                FROM " . CashTransaction::model()->tableName() . "
                WHERE branch_id = :branch_id AND transaction_date = :transaction_date AND transaction_type = 'In'
                GROUP BY transaction_date, branch_id, transaction_type";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':branch_id' => $branchId,
            ':transaction_date' => $transactionDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotalCreditAmount($branchId, $transactionDate) {
        $sql = "SELECT transaction_date, transaction_type, COALESCE(SUM(credit_amount), 0) AS total_amount
                FROM " . CashTransaction::model()->tableName() . "
                WHERE branch_id = :branch_id AND transaction_date = :transaction_date AND transaction_type = 'Out'
                GROUP BY transaction_date, transaction_type";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':branch_id' => $branchId,
            ':transaction_date' => $transactionDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotalAmount($branchId, $transactionDate) {
        $sql = "SELECT transaction_date, COALESCE(SUM(debit_amount), 0) AS total_amount
                FROM " . CashTransaction::model()->tableName() . "
                WHERE branch_id = :branch_id AND transaction_date = :transaction_date
                GROUP BY transaction_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':branch_id' => $branchId,
            ':transaction_date' => $transactionDate,
        ));

        return ($value === false) ? 0 : $value;
    }

}
