<?php

/**
 * This is the model class for table "{{pay_out_detail}}".
 *
 * The followings are the available columns in table '{{pay_out_detail}}':
 * @property integer $id
 * @property string $total_invoice
 * @property string $amount
 * @property string $memo
 * @property integer $payment_out_id
 * @property integer $receive_item_id
 * @property integer $work_order_expense_header_id
 *
 * The followings are the available model relations:
 * @property TransactionReceiveItem $receiveItem
 * @property WorkOrderExpenseHeader $workOrderExpenseHeader
 * @property PaymentOut $paymentOut
 */
class PayOutDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentOutDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{pay_out_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_out_id', 'required'),
            array('payment_out_id, receive_item_id, work_order_expense_header_id', 'numerical', 'integerOnly' => true),
            array('total_invoice, amount', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, total_invoice, memo, payment_out_id, receive_item_id, work_order_expense_header_id, amount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'receiveItem' => array(self::BELONGS_TO, 'TransactionReceiveItem', 'receive_item_id'),
            'paymentOut' => array(self::BELONGS_TO, 'PaymentOut', 'payment_out_id'),
            'workOrderExpenseHeader' => array(self::BELONGS_TO, 'WorkOrderExpenseHeader', 'work_order_expense_header_id'),
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
            'payment_out_id' => 'Payment Out',
            'receive_item_id' => 'Receive Item',
            'work_order_expense_header_id' => 'Sub Pekerjaan Luar',
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
        $criteria->compare('total_invoice', $this->total_invoice, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('payment_out_id', $this->payment_out_id);
        $criteria->compare('receive_item_id', $this->receive_item_id);
        $criteria->compare('work_order_expense_header_id', $this->work_order_expense_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
