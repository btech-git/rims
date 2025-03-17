<?php

/**
 * This is the model class for table "{{item_request_header}}".
 *
 * The followings are the available columns in table '{{item_request_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $total_quantity
 * @property string $total_price
 * @property string $total_payment
 * @property string $remaining_payment
 * @property string $status_document
 * @property string $note
 * @property integer $branch_id
 * @property integer $user_id
 * @property integer $supplier_id
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property ItemRequestDetail[] $itemRequestDetails
 * @property Branch $branch
 * @property Users $user
 * @property Supplier $supplier
 */
class ItemRequestHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'IRQ';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{item_request_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, status_document, branch_id, user_id, created_datetime, supplier_id', 'required'),
            array('branch_id, user_id, supplier_id', 'numerical', 'integerOnly' => true),
            array('transaction_number, status_document', 'length', 'max' => 60),
            array('total_quantity', 'length', 'max' => 10),
            array('total_price, total_payment, remaining_payment', 'length', 'max' => 18),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, total_quantity, total_price, status_document, note, branch_id, user_id, total_payment, remaining_payment, supplier_id, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'itemRequestDetails' => array(self::HAS_MANY, 'ItemRequestDetail', 'item_request_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'payOutDetails' => array(self::HAS_MANY, 'PayOutDetail', 'item_request_header_id'),
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
            'total_quantity' => 'Total Quantity',
            'total_price' => 'Total Price',
            'status_document' => 'Status Document',
            'note' => 'Note',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'created_datetime' => 'Created Datetime',
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
        $criteria->compare('total_quantity', $this->total_quantity, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('created_datetime', $this->created_datetime, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchForPaymentOut() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('total_quantity', $this->total_quantity, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('created_datetime', $this->created_datetime, true);

        $criteria->addCondition("remaining_payment > 0.00");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'Pagination' => array(
                'PageSize' => 30
            ),
            'sort' => array(
                'defaultOrder' => 't.transaction_date DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemRequestHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalQuantity() {
        $total = '0.00';

        foreach ($this->itemRequestDetails as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }

    public function getTotalPrice() {
        $total = '0.00';

        foreach ($this->itemRequestDetails as $detail) {
            $total += $detail->total_price;
        }
        
        return $total;
    }

    public function getTotalPayment() {
        $total = '0.00';

        foreach ($this->payOutDetails as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
    
    public function getRemainingPayment() {
        return $this->total_price - $this->total_payment;
    }
}
