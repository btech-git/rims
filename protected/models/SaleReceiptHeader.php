<?php

/**
 * This is the model class for table "{{sale_receipt_header}}".
 *
 * The followings are the available columns in table '{{sale_receipt_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $due_date
 * @property string $status
 * @property string $note
 * @property string $total_invoice_amount
 * @property integer $customer_id
 * @property integer $branch_id
 * @property integer $user_id_created
 * @property string $created_datetime
 * @property integer $user_id_updated
 * @property string $updated_datetime
 * @property integer $user_id_cancelled
 * @property string $cancelled_datetime
 *
 * The followings are the available model relations:
 * @property SaleReceiptDetail[] $saleReceiptDetails
 * @property Branch $branch
 * @property Customer $customer
 * @property Users $userIdCreated
 * @property Users $userIdUpdated
 * @property Users $userIdCancelled
 */
class SaleReceiptHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'SRC';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sale_receipt_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, due_date, status, customer_id, branch_id, user_id_created, created_datetime', 'required'),
            array('customer_id, branch_id, user_id_created, user_id_updated, user_id_cancelled', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('status', 'length', 'max' => 20),
            array('total_invoice_amount', 'length', 'max' => 18),
            array('note, updated_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, due_date, status, note, total_invoice_amount, customer_id, branch_id, user_id_created, created_datetime, user_id_updated, updated_datetime, user_id_cancelled, cancelled_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'saleReceiptDetails' => array(self::HAS_MANY, 'SaleReceiptDetail', 'sale_receipt_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
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
            'due_date' => 'Due Date',
            'status' => 'Status',
            'note' => 'Note',
            'total_invoice_amount' => 'Total Invoice Amount',
            'customer_id' => 'Customer',
            'branch_id' => 'Branch',
            'user_id_created' => 'User Id Created',
            'created_datetime' => 'Created Datetime',
            'user_id_updated' => 'User Id Updated',
            'updated_datetime' => 'Updated Datetime',
            'user_id_cancelled' => 'User Id Cancelled',
            'cancelled_datetime' => 'Cancelled Datetime',
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
        $criteria->compare('due_date', $this->due_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('total_invoice_amount', $this->total_invoice_amount, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SaleReceiptHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
