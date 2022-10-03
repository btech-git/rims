<?php

/**
 * This is the model class for table "{{transaction_delivery_order_detail}}".
 *
 * The followings are the available columns in table '{{transaction_delivery_order_detail}}':
 * @property integer $id
 * @property integer $delivery_order_id
 * @property integer $sales_order_detail_id
 * @property integer $sent_request_detail_id
 * @property integer $consignment_out_detail_id
 * @property integer $product_id
 * @property string $quantity_request
 * @property string $quantity_delivery
 * @property string $quantity_request_left
 * @property string $note
 * @property string $barcode_product
 * @property integer $temp_quantity
 * @property string $quantity_movement
 * @property string $quantity_movement_left
 * @property integer $transfer_request_detail_id
 * @property string $quantity_receive
 * @property string $quantity_receive_left
 *
 * The followings are the available model relations:
 * @property MovementOutDetail[] $movementOutDetails
 * @property TransactionDeliveryOrder $deliveryOrder
 * @property Product $product
 * @property TransactionSalesOrderDetail $salesOrderDetail
 * @property TransactionSentRequestDetail $sentRequestDetail
 * @property ConsignmentOutDetail $consignmentOutDetail
 * @property TransactionTransferRequestDetail $transferRequestDetail
 * @property TransactionReceiveItemDetail[] $transactionReceiveItemDetails
 * @property TransactionReturnItemDetail[] $transactionReturnItemDetails
 */
class TransactionDeliveryOrderDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionDeliveryOrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public $product_name;
    public $delivery_order_no;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_delivery_order_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, quantity_request, quantity_delivery', 'required'),
            array('delivery_order_id, sales_order_detail_id, sent_request_detail_id, consignment_out_detail_id, product_id, temp_quantity, transfer_request_detail_id', 'numerical', 'integerOnly' => true),
            array('barcode_product', 'length', 'max' => 50),
            array('quantity_request, quantity_delivery, quantity_request_left, quantity_receive, quantity_receive_left', 'length', 'max' => 10),
            array('note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, delivery_order_id, sales_order_detail_id, sent_request_detail_id, consignment_out_detail_id, product_id, quantity_request, quantity_delivery, quantity_request_left, note, barcode_product, temp_quantity, delivery_order_no, product_name,transfer_request_detail_id, quantity_receive, quantity_receive_left', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementOutDetails' => array(self::HAS_MANY, 'MovementOutDetail', 'delivery_order_detail_id'),
            'deliveryOrder' => array(self::BELONGS_TO, 'TransactionDeliveryOrder', 'delivery_order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'salesOrderDetail' => array(self::BELONGS_TO, 'TransactionSalesOrderDetail', 'sales_order_detail_id'),
            'sentRequestDetail' => array(self::BELONGS_TO, 'TransactionSentRequestDetail', 'sent_request_detail_id'),
            'consignmentOutDetail' => array(self::BELONGS_TO, 'ConsignmentOutDetail', 'consignment_out_detail_id'),
            'transferRequestDetail' => array(self::BELONGS_TO, 'TransactionTransferRequestDetail', 'transfer_request_detail_id'),
            'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'delivery_order_detail_id'),
                // 'transactionReturnItemDetails' => array(self::HAS_MANY, 'TransactionReturnItemDetail', 'delivery_order_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'delivery_order_id' => 'Delivery Order',
            'sales_order_detail_id' => 'Sales Order Detail',
            'sent_request_detail_id' => 'Sent Request Detail',
            'consignment_out_detail_id' => 'Consignment Out Detail',
            'product_id' => 'Product',
            'quantity_request' => 'Quantity Request',
            'quantity_delivery' => 'Quantity Delivery',
            'quantity_request_left' => 'Quantity Request Left',
            'note' => 'Note',
            'barcode_product' => 'Barcode Product',
            'temp_quantity' => 'Temp Quantity',
            'quantity_movement' => 'Quantity Movement',
            'quantity_movement_left' => 'Quantity Movement Left',
            'transfer_request_detail_id' => 'Transfer Request Detail',
            'quantity_receive' => 'Quantity Receive',
            'quantity_receive_left' => 'Quantity Receive Left',
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
        $criteria->compare('delivery_order_id', $this->delivery_order_id);
        $criteria->compare('sales_order_detail_id', $this->sales_order_detail_id);
        $criteria->compare('sent_request_detail_id', $this->sent_request_detail_id);
        $criteria->compare('consignment_out_detail_id', $this->consignment_out_detail_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('quantity_request', $this->quantity_request);
        $criteria->compare('quantity_delivery', $this->quantity_delivery);
        $criteria->compare('quantity_request_left', $this->quantity_request_left);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('barcode_product', $this->barcode_product, true);
        $criteria->compare('temp_quantity', $this->temp_quantity);
        $criteria->compare('quantity_movement', $this->quantity_movement);
        $criteria->compare('quantity_movement_left', $this->quantity_movement_left);
        $criteria->compare('transfer_request_detail_id', $this->transfer_request_detail_id);
        $criteria->compare('quantity_receive', $this->quantity_receive);
        $criteria->compare('quantity_receive_left', $this->quantity_receive_left);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalQuantityReceived() {
        $total = 0;

        foreach ($this->transactionReceiveItemDetails as $detail)
            $total += $detail->qty_received;

        return $total;
    }
    
    public function getUnitPrice() {
        $unitPrice = 0;
        
        if (!empty($this->sales_order_detail_id)) {
            $unitPrice = $this->salesOrderDetail->unit_price;
        } elseif (!empty($this->sent_request_detail_id)) {
            $unitPrice = $this->sentRequestDetail->unit_price;
        } elseif (!empty($this->consignment_out_detail_id)) {
            $unitPrice = $this->consignmentOutDetail->sale_price;
        } elseif (!empty($this->transfer_request_detail_id)) {
            $unitPrice = $this->transferRequestDetail->unit_price;
        } else {
            $unitPrice = 0;
        }
        
        return $unitPrice;
    }
    
    public function getTotalSaleDelivered() {
        
        return $this->quantity_delivery * $this->getUnitPrice();
    }
}
