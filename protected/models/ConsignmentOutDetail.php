<?php

/**
 * This is the model class for table "{{consignment_out_detail}}".
 *
 * The followings are the available columns in table '{{consignment_out_detail}}':
 * @property integer $id
 * @property string $quantity
 * @property string $qty_request_left
 * @property integer $consignment_out_id
 * @property integer $product_id
 * @property string $qty_sent
 * @property string $sale_price
 * @property string $total_price
 *
 * The followings are the available model relations:
 * @property ConsignmentOutHeader $consignmentOut
 * @property Product $product
 * @property TransactionDeliveryOrderDetail[] $transactionDeliveryOrderDetails
 */
class ConsignmentOutDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ConsignmentOutDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{consignment_out_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('consignment_out_id, product_id, qty_sent, sale_price, total_price', 'required'),
            array('consignment_out_id, product_id', 'numerical', 'integerOnly' => true),
            array('sale_price, total_price', 'length', 'max' => 18),
            array('quantity, qty_request_left, qty_sent', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, quantity, qty_request_left, consignment_out_id, product_id, qty_sent, sale_price, total_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'consignmentOut' => array(self::BELONGS_TO, 'ConsignmentOutHeader', 'consignment_out_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'transactionDeliveryOrderDetails' => array(self::HAS_MANY, 'TransactionDeliveryOrderDetail', 'consignment_out_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'qty_request_left' => 'Qty Request Left',
            'consignment_out_id' => 'Consignment Out',
            'product_id' => 'Product',
            'qty_sent' => 'Qty Sent',
            'sale_price' => 'Sale Price',
            'total_price' => 'Total Price',
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
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('qty_request_left', $this->qty_request_left);
        $criteria->compare('consignment_out_id', $this->consignment_out_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty_sent', $this->qty_sent);
        $criteria->compare('sale_price', $this->sale_price, true);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalQuantityDelivery() {
        $total = 0;

        foreach ($this->transactionDeliveryOrderDetails as $detail) {
            $total += $detail->quantity_delivery;
        }

        return $total;
    }

    public function getQuantityDeliveredLeft() {
        
        return $this->quantity - $this->qty_sent;
    }

}
