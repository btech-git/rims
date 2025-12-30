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
 * @property integer $movement_out_detail_id
 * @property integer $product_id
 * @property string $qty_request
 * @property string $qty_received
 * @property string $note
 * @property string $qty_request_left
 * @property string $barcode_product
 * @property string $quantity_movement
 * @property string $quantity_movement_left
 * @property string $quantity_delivered
 * @property string $quantity_delivered_left
 * @property integer $delivery_order_detail_id
 * @property string $quantity_return
 * @property string $total_price
 *
 * The followings are the available model relations:
 * @property MovementInDetail[] $movementInDetails
 * @property ConsignmentInDetail $consignmentInDetail
 * @property TransactionDeliveryOrderDetail $deliveryOrderDetail
 * @property MovementOutDetail $movementOutDetail
 * @property TransactionPurchaseOrderDetail $purchaseOrderDetail
 * @property TransactionReceiveItem $receiveItem
 * @property TransactionTransferRequestDetail $transferRequestDetail
 * @property Product $product
 */
class TransactionReceiveItemDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
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
            array('receive_item_id, purchase_order_detail_id, transfer_request_detail_id, consignment_in_detail_id, movement_out_detail_id, product_id, delivery_order_detail_id', 'numerical', 'integerOnly' => true),
            array('qty_request, qty_received, qty_request_left, quantity_movement, quantity_movement_left, quantity_delivered, quantity_delivered_left, quantity_return', 'length', 'max' => 10),
            array('barcode_product', 'length', 'max' => 30),
            array('total_price', 'length', 'max' => 18),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, receive_item_id, purchase_order_detail_id, transfer_request_detail_id, consignment_in_detail_id, movement_out_detail_id, product_id, qty_request, qty_received, note, qty_request_left, barcode_product, quantity_movement, quantity_movement_left, quantity_delivered, quantity_delivered_left, delivery_order_detail_id, quantity_return, total_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementInDetails' => array(self::HAS_MANY, 'MovementInDetail', 'receive_item_detail_id'),
            'consignmentInDetail' => array(self::BELONGS_TO, 'ConsignmentInDetail', 'consignment_in_detail_id'),
            'deliveryOrderDetail' => array(self::BELONGS_TO, 'TransactionDeliveryOrderDetail', 'delivery_order_detail_id'),
            'movementOutDetail' => array(self::BELONGS_TO, 'MovementOutDetail', 'movement_out_detail_id'),
            'purchaseOrderDetail' => array(self::BELONGS_TO, 'TransactionPurchaseOrderDetail', 'purchase_order_detail_id'),
            'receiveItem' => array(self::BELONGS_TO, 'TransactionReceiveItem', 'receive_item_id'),
            'transferRequestDetail' => array(self::BELONGS_TO, 'TransactionTransferRequestDetail', 'transfer_request_detail_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
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
            'movement_out_detail_id' => 'Movement Out Detail',
            'product_id' => 'Product',
            'qty_request' => 'Qty Request',
            'qty_received' => 'Qty Received',
            'note' => 'Note',
            'qty_request_left' => 'Qty Request Left',
            'barcode_product' => 'Barcode Product',
            'quantity_movement' => 'Quantity Movement',
            'quantity_movement_left' => 'Quantity Movement Left',
            'quantity_delivered' => 'Quantity Delivered',
            'quantity_delivered_left' => 'Quantity Delivered Left',
            'delivery_order_detail_id' => 'Delivery Order Detail',
            'quantity_return' => 'Quantity Return',
            'total_price' => 'Total Price',
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
        $criteria->compare('receive_item_id', $this->receive_item_id);
        $criteria->compare('purchase_order_detail_id', $this->purchase_order_detail_id);
        $criteria->compare('transfer_request_detail_id', $this->transfer_request_detail_id);
        $criteria->compare('consignment_in_detail_id', $this->consignment_in_detail_id);
        $criteria->compare('movement_out_detail_id', $this->movement_out_detail_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty_request', $this->qty_request, true);
        $criteria->compare('qty_received', $this->qty_received, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('qty_request_left', $this->qty_request_left, true);
        $criteria->compare('barcode_product', $this->barcode_product, true);
        $criteria->compare('quantity_movement', $this->quantity_movement, true);
        $criteria->compare('quantity_movement_left', $this->quantity_movement_left, true);
        $criteria->compare('quantity_delivered', $this->quantity_delivered, true);
        $criteria->compare('quantity_delivered_left', $this->quantity_delivered_left, true);
        $criteria->compare('delivery_order_detail_id', $this->delivery_order_detail_id);
        $criteria->compare('quantity_return', $this->quantity_return, true);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionReceiveItemDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getUnitPrice() {
        $unitPrice = 0;
        
        if (!empty($this->purchase_order_detail_id)) {
            $unitPrice = $this->purchaseOrderDetail->unit_price;
        } elseif (!empty($this->transfer_request_detail_id)) {
            $unitPrice = $this->transferRequestDetail->unit_price;
        } elseif (!empty($this->consignment_in_detail_id)) {
            $unitPrice = $this->consignmentInDetail->price;
        } elseif (!empty($this->movement_out_detail_id)) {
            $unitPrice = 0;
        } else {
            $unitPrice = 0;
        }
        
        return $unitPrice;
    }
    
    public function getTotalPurchaseReceived() {
        
        return $this->qty_received * $this->getUnitPrice();
    }
    
    public function getPurchaseRetailPrice() {
        
        $retailPrice = !empty($this->purchase_order_detail_id) ? $this->purchaseOrderDetail->retail_price : "0.00";
        
        return $retailPrice * $this->qty_received;
    }
    
    public function getPurchaseDiscount() {
        
        $discountAmount = !empty($this->purchase_order_detail_id) ? $this->purchaseOrderDetail->totalDiscount : "0.00";
        
        return $discountAmount * $this->qty_received;
    }
    
    public function getTotalPrice() {
        $total = 0.00; 
        
        if (!empty($this->purchase_order_detail_id)) {
            $total = $this->purchaseOrderDetail->price_before_tax;
        } elseif (!empty($this->consignment_in_detail_id)) {
            $total = $this->consignmentInDetail->price;
        } else {
            $total = $this->product->hpp;
        }
        
        return $this->qty_received * $total;
    }
    
    public function getQuantityMovement() {
        $total = 0;
        
        foreach ($this->movementInDetails as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }
    
    public function getQuantityMovementLeft() {
        return $this->qty_received - $this->quantity_movement;
    }
}
