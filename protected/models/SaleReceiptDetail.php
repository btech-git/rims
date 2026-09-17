<?php

/**
 * This is the model class for table "{{sale_receipt_detail}}".
 *
 * The followings are the available columns in table '{{sale_receipt_detail}}':
 * @property integer $id
 * @property string $invoice_amount
 * @property string $memo
 * @property integer $sale_receipt_header_id
 * @property integer $invoice_header_id
 * @property string $insurance_own_risk_amount
 * @property string $downpayment_amount
 * @property string $receivable_amount
 *
 * The followings are the available model relations:
 * @property InvoiceHeader $invoiceHeader
 * @property SaleReceiptHeader $saleReceiptHeader
 */
class SaleReceiptDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sale_receipt_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sale_receipt_header_id, invoice_header_id', 'required'),
            array('sale_receipt_header_id, invoice_header_id', 'numerical', 'integerOnly' => true),
            array('invoice_amount, insurance_own_risk_amount, downpayment_amount, receivable_amount', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, invoice_amount, memo, sale_receipt_header_id, invoice_header_id, insurance_own_risk_amount, downpayment_amount, receivable_amount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoiceHeader' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_header_id'),
            'saleReceiptHeader' => array(self::BELONGS_TO, 'SaleReceiptHeader', 'sale_receipt_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'invoice_amount' => 'Invoice Amount',
            'memo' => 'Memo',
            'sale_receipt_header_id' => 'Sale Receipt Header',
            'invoice_header_id' => 'Invoice Header',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('invoice_amount', $this->invoice_amount, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('sale_receipt_header_id', $this->sale_receipt_header_id);
        $criteria->compare('invoice_header_id', $this->invoice_header_id);
        $criteria->compare('insurance_own_risk_amount', $this->insurance_own_risk_amount, true);
        $criteria->compare('downpayment_amount', $this->downpayment_amount, true);
        $criteria->compare('receivable_amount', $this->receivable_amount, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SaleReceiptDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}