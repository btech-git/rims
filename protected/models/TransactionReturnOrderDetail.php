<?php

/**
 * This is the model class for table "{{transaction_return_order_detail}}".
 *
 * The followings are the available columns in table '{{transaction_return_order_detail}}':
 * @property integer $id
 * @property integer $return_order_id
 * @property integer $product_id
 * @property integer $qty_request
 * @property integer $qty_request_left
 * @property integer $qty_reject
 * @property string $note
 * @property string $barcode_product
 * @property integer $quantity_movement
 * @property integer $quantity_movement_left
 *
 * The followings are the available model relations:
 * @property MovementOutDetail[] $movementOutDetails
 * @property TransactionReturnOrder $returnOrder
 * @property Product $product
 */
class TransactionReturnOrderDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReturnOrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $return_order_no;
    public $product_name;

    public function tableName() {
        return '{{transaction_return_order_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('return_order_id, product_id', 'numerical', 'integerOnly' => true),
            array('barcode_product', 'length', 'max' => 30),
            array('note', 'safe'),
            array('price, qty_request, qty_request_left, qty_reject, quantity_movement, quantity_movement_left', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, return_order_id, product_id, qty_request, qty_request_left, qty_reject, note, barcode_product,return_order_no, quantity_movement, quantity_movement_left, price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementOutDetails' => array(self::HAS_MANY, 'MovementOutDetail', 'return_order_detail_id'),
            'returnOrder' => array(self::BELONGS_TO, 'TransactionReturnOrder', 'return_order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'return_order_id' => 'Return Order',
            'product_id' => 'Product',
            'qty_request' => 'Qty Request',
            'qty_request_left' => 'Qty Request Left',
            'qty_reject' => 'Qty Reject',
            'note' => 'Note',
            'barcode_product' => 'Barcode Product',
            'quantity_movement' => 'Quantity Movement',
            'quantity_movement_left' => 'Quantity Movement Left',
            'price' => 'Price',
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
        $criteria->compare('return_order_id', $this->return_order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('qty_request', $this->qty_request);
        $criteria->compare('qty_request_left', $this->qty_request_left);
        $criteria->compare('qty_reject', $this->qty_reject);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('barcode_product', $this->barcode_product, true);
        $criteria->compare('quantity_movement', $this->quantity_movement);
        $criteria->compare('quantity_movement_left', $this->quantity_movement_left);
        $criteria->compare('price', $this->price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
