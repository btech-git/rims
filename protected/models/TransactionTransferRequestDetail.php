<?php

/**
 * This is the model class for table "{{transaction_transfer_request_detail}}".
 *
 * The followings are the available columns in table '{{transaction_transfer_request_detail}}':
 * @property integer $id
 * @property integer $transfer_request_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $unit_id
 * @property integer $amount
 * @property integer $receive_quantity
 * @property integer $transfer_request_quantity_left
 * @property integer $quantity_delivery
 * @property integer $quantity_delivery_left
 *
 * The followings are the available model relations:
 * @property TransactionDeliveryOrderDetail[] $transactionDeliveryOrderDetails
 * @property TransactionReceiveItemDetail[] $transactionReceiveItemDetails
 * @property TransactionTransferRequest $transferRequest
 * @property Product $product
 */
class TransactionTransferRequestDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $product_name;

    public function tableName() {
        return '{{transaction_transfer_request_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transfer_request_id, product_id, quantity, unit_price', 'required'),
            array('transfer_request_id, product_id, quantity, unit_id, amount, receive_quantity, transfer_request_quantity_left, quantity_delivery, quantity_delivery_left', 'numerical', 'integerOnly' => true),
            array('unit_price', 'length', 'max' => 18),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transfer_request_id, product_id, quantity, unit_price, unit_id, amount, receive_quantity, transfer_request_quantity_left, quantity_delivery, quantity_delivery_left', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transactionDeliveryOrderDetails' => array(self::HAS_MANY, 'TransactionDeliveryOrderDetail', 'transfer_request_detail_id'),
            'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'transfer_request_detail_id'),
            'transferRequest' => array(self::BELONGS_TO, 'TransactionTransferRequest', 'transfer_request_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transfer_request_id' => 'Transfer Request',
            'product_id' => 'Product',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'unit_id' => 'Unit',
            'amount' => 'Amount',
            'receive_quantity' => 'Receive Quantity',
            'transfer_request_quantity_left' => 'Transfer Request Quantity Left',
            'quantity_delivery' => 'Quantity Delivery',
            'quantity_delivery_left' => 'Quantity Delivery Left',
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
        $criteria->compare('transfer_request_id', $this->transfer_request_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('receive_quantity', $this->receive_quantity);
        $criteria->compare('transfer_request_quantity_left', $this->transfer_request_quantity_left);
        $criteria->compare('quantity_delivery', $this->quantity_delivery);
        $criteria->compare('quantity_delivery_left', $this->quantity_delivery_left);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionTransferRequestDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotal() {
        return $this->quantity * $this->unit_price;
    }

    public function getQuantityReceiveRemaining() {
        $quantityRemaining = 0;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $quantityRemaining += $detail->qty_received;
        }

        return $this->quantity - $quantityRemaining;
    }

    public function getRemainingQuantityDelivery() {
        $quantityRemaining = 0;

        foreach ($this->transactionDeliveryOrderDetails as $detail)
            $quantityRemaining += $detail->quantity_delivery;

        return $this->quantity - $quantityRemaining;
    }

}
