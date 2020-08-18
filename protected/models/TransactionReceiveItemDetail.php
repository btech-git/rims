<?php

/**
 * This is the model class for table "{{transaction_receive_item_detail}}".
 *
 * The followings are the available columns in table '{{transaction_receive_item_detail}}':
 * @property integer $id
 * @property integer $receive_item_id
 * @property integer $purchase_order_detail_id
 * @property integer $transfer_request_detail_id
 * @property integer $consignment_in_detail_id
 * @property integer $product_id
 * @property integer $qty_request
 * @property integer $qty_received
 * @property string $note
 * @property integer $qty_request_left
 * @property string $barcode_product
 * @property integer $quantity_movement
 * @property integer $quantity_movement_left
 * @property integer $delivery_order_detail_id
 * @property integer $quantity_delivered
 * @property integer $quantity_delivered_left
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property TransactionReceiveItem $receiveItem
 * @property TransactionPurchaseOrderDetail $purchaseOrderDetail
 * @property TransactionTransferRequestDetail $transferRequestDetail
 * @property ConsignmentInDetail $consignmentInDetail
 * @property TransactionDeliveryOrderDetail $deliveryOrderDetail
 */
class TransactionReceiveItemDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReceiveItemDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $product_name;
    public $receive_item_no;
    //public $all_quantity;
    public $temp_quantity;

    public function tableName() {
        return '{{transaction_receive_item_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('receive_item_id, purchase_order_detail_id, transfer_request_detail_id, consignment_in_detail_id, product_id, qty_request, qty_received, qty_request_left, delivery_order_detail_id, quantity_delivered, quantity_delivered_left', 'numerical', 'integerOnly' => true),
            array('barcode_product', 'length', 'max' => 30),
            array('note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, receive_item_id, purchase_order_detail_id, transfer_request_detail_id, consignment_in_detail_id, product_id, qty_request, qty_received, note, qty_request_left, barcode_product, receive_item_no, product_name, delivery_order_detail_id, quantity_delivered, quantity_delivered_left', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'receiveItem' => array(self::BELONGS_TO, 'TransactionReceiveItem', 'receive_item_id'),
            'purchaseOrderDetail' => array(self::BELONGS_TO, 'TransactionPurchaseOrderDetail', 'purchase_order_detail_id'),
            'transferRequestDetail' => array(self::BELONGS_TO, 'TransactionTransferRequestDetail', 'transfer_request_detail_id'),
            'consignmentInDetail' => array(self::BELONGS_TO, 'ConsignmentInDetail', 'consignment_in_detail_id'),
            'deliveryOrderDetail' => array(self::BELONGS_TO, 'TransactionDeliveryOrderDetail', 'delivery_order_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'receive_item_id' => 'Receive Item',
            'purchase_order_detail_id' => 'Purchase Order Detail',
            'transfer_request_detail_id' => 'Transfer Request Detail',
            'consignment_in_detail_id' => 'Consignment In Detail',
            'product_id' => 'Product',
            'qty_request' => 'Qty Request',
            'qty_received' => 'Qty Received',
            'note' => 'Note',
            'qty_request_left' => 'Qty Request Left',
            'barcode_product' => 'Barcode Product',
            'quantity_movement' => 'Quantity Movement',
            'quantity_movement_left' => 'Quantity Movement Left',
            'delivery_order_detail_id' => 'Delivery Order Detail',
            'quantity_delivered' => 'Quantity Delivered',
            'quantity_delivered_left' => 'Quantity Delivered Left',
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
        $criteria->compare('receive_item_id', $this->receive_item_id);
        $criteria->compare('purchase_order_detail_id', $this->purchase_order_detail_id);
        $criteria->compare('transfer_request_detail_id', $this->transfer_request_detail_id);
        $criteria->compare('consignment_in_detail_id', $this->consignment_in_detail_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty_request', $this->qty_request);
        $criteria->compare('qty_received', $this->qty_received);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('qty_request_left', $this->qty_request_left);
        $criteria->compare('barcode_product', $this->barcode_product, true);
        $criteria->compare('quantity_movement', $this->quantity_movement);
        $criteria->compare('quantity_movement_left', $this->quantity_movement_left);
        $criteria->compare('delivery_order_detail_id', $this->delivery_order_detail_id);
        $criteria->compare('quantity_delivered', $this->quantity_delivered);
        $criteria->compare('quantity_delivered_left', $this->quantity_delivered_left);
        $criteria->compare('delivery_order_detail_id', $this->delivery_order_detail_id);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalPrice() {
        $unitPrice = empty($this->purchase_order_detail_id) ? $this->consignmentInDetail->price : $this->purchaseOrderDetail->unit_price;
        
        return $this->qty_received * $unitPrice;
    }
}
