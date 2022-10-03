<?php

/**
 * This is the model class for table "{{transaction_return_item_detail}}".
 *
 * The followings are the available columns in table '{{transaction_return_item_detail}}':
 * @property integer $id
 * @property integer $return_item_id
 * @property integer $product_id
 * @property string $return_type
 * @property string $quantity
 * @property string $quantity_delivery
 * @property string $quantity_left
 * @property string $note
 * @property integer $barcode_product
 * @property string $quantity_movement
 * @property string $quantity_movement_left
 *
 * The followings are the available model relations:
 * @property MovementInDetail[] $movementInDetails
 * @property TransactionReturnItem $returnItem
 * @property Product $product
 */
class TransactionReturnItemDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionReturnItemDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $product_name;
    public $return_item_no;

    public function tableName() {
        return '{{transaction_return_item_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('return_item_id, product_id, return_type, quantity', 'required'),
            array('return_item_id, product_id, barcode_product', 'numerical', 'integerOnly' => true),
            array('return_type', 'length', 'max' => 30),
            array('note', 'safe'),
            array('price, quantity, quantity_delivery, quantity_left, quantity_movement, quantity_movement_left', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, return_item_id, product_id, return_type, quantity, quantity_delivery, quantity_left, note, barcode_product, quantity_movement, quantity_movement_left', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementInDetails' => array(self::HAS_MANY, 'MovementInDetail', 'return_item_detail_id'),
            'returnItem' => array(self::BELONGS_TO, 'TransactionReturnItem', 'return_item_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'return_item_id' => 'Return Item',
            'product_id' => 'Product',
            'return_type' => 'Return Type',
            'quantity' => 'Quantity',
            'quantity_delivery' => 'Quantity Delivery',
            'quantity_left' => 'Quantity Left',
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
        $criteria->compare('return_item_id', $this->return_item_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('return_type', $this->return_type, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('quantity_delivery', $this->quantity_delivery);
        $criteria->compare('quantity_left', $this->quantity_left);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('barcode_product', $this->barcode_product);
        $criteria->compare('quantity_movement', $this->quantity_movement);
        $criteria->compare('quantity_movement_left', $this->quantity_movement_left);
        $criteria->compare('price', $this->price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
