<?php

/**
 * This is the model class for table "{{consignment_in_detail}}".
 *
 * The followings are the available columns in table '{{consignment_in_detail}}':
 * @property integer $id
 * @property integer $consignment_in_id
 * @property integer $product_id
 * @property string $quantity
 * @property string $note
 * @property string $barcode_product
 * @property string $price
 * @property string $total_price
 * @property string $qty_received
 * @property string $qty_request_left
 *
 * The followings are the available model relations:
 * @property ConsignmentInHeader $consignmentIn
 * @property Product $product
 * @property TransactionReceiveItemDetail[] $transactionReceiveItemDetails
 */
class ConsignmentInDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ConsignmentInDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{consignment_in_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('consignment_in_id, product_id, quantity, price, total_price', 'required'),
            array('consignment_in_id, product_id', 'numerical', 'integerOnly' => true),
            array('barcode_product', 'length', 'max' => 50),
            array('price, total_price', 'length', 'max' => 18),
            array('quantity, qty_received, qty_request_left', 'length', 'max' => 10),
            array('note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, consignment_in_id, product_id, quantity, note, barcode_product, price, total_price, qty_received, qty_request_left', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'consignmentIn' => array(self::BELONGS_TO, 'ConsignmentInHeader', 'consignment_in_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'consignment_in_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'consignment_in_id' => 'Consignment In',
            'product_id' => 'Product',
            'quantity' => 'Quantity',
            'note' => 'Note',
            'barcode_product' => 'Barcode Product',
            'price' => 'Price',
            'total_price' => 'Total Price',
            'qty_received' => 'Qty Received',
            'qty_request_left' => 'Qty Request Left',
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
        $criteria->compare('consignment_in_id', $this->consignment_in_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('barcode_product', $this->barcode_product, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('qty_received', $this->qty_received);
        $criteria->compare('qty_request_left', $this->qty_request_left);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotal() {
        return $this->quantity * $this->price;
    }

    public function getTotalQuantityReceived() {
        $total = 0;

        foreach ($this->transactionReceiveItemDetails as $detail)
            $total += $detail->qty_received;

        return $total;
    }

}
