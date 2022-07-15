<?php

/**
 * This is the model class for table "{{work_order_expense_header}}".
 *
 * The followings are the available columns in table '{{work_order_expense_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $note
 * @property integer $registration_transaction_id
 * @property integer $branch_id
 * @property integer $user_id
 * @property string $status
 * @property string $created_datetime
 * @property string $grand_total
 * @property string $total_payment
 * @property string $payment_remaining
 * @property integer $supplier_id
 *
 * The followings are the available model relations:
 * @property WorkOrderExpenseDetail[] $workOrderExpenseDetails
 * @property RegistrationTransaction $registrationTransaction
 * @property Branch $branch
 * @property Users $user
 * @property Supplier $supplier
 */
class WorkOrderExpenseHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'WOE';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{work_order_expense_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, registration_transaction_id, branch_id, user_id, status', 'required'),
            array('registration_transaction_id, branch_id, user_id, supplier_id', 'numerical', 'integerOnly' => true),
            array('transaction_number, status', 'length', 'max' => 50),
            array('grand_total, total_payment, payment_remaining', 'length', 'max' => 18),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, note, registration_transaction_id, branch_id, user_id, status, created_datetime, grand_total, total_payment, payment_remaining, supplier_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'workOrderExpenseDetails' => array(self::HAS_MANY, 'WorkOrderExpenseDetail', 'work_order_expense_header_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
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
            'note' => 'Note',
            'registration_transaction_id' => 'Registration Transaction',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'status' => 'Status',
            'grand_total' => 'Grand Total',
            'total_payment' => 'Total Payment',
            'payment_remaining' => 'Remaining',
            'supplier_id' => 'Supplier',
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
        $criteria->compare('note', $this->note, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('total_payment', $this->total_payment, true);
        $criteria->compare('payment_remaining', $this->payment_remaining, true);
        $criteria->compare('supplier_id', $this->supplier_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkOrderExpenseHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalDetail() {
        $total = 0.00;
        
        foreach($this->workOrderExpenseDetails as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
    
    public function searchForPaymentOut() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "t.payment_remaining > 0 AND t.status = 'Approved'";
        
        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
//        $criteria->compare('status', $this->status, true);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('total_payment', $this->total_payment, true);
//        $criteria->compare('payment_remaining', $this->payment_remaining, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
