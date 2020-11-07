<?php

/**
 * This is the model class for table "{{transaction_request_transfer}}".
 *
 * The followings are the available columns in table '{{transaction_request_transfer}}':
 * @property integer $id
 * @property integer $request_order_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $quantity
 * @property integer $received_quantity
 * @property integer $rest_quantity
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property TransactionRequestOrder $requestOrder
 * @property Product $product
 */
class TransactionRequestTransfer extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionRequestTransfer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_request_transfer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_order_id, product_id, unit_id, quantity', 'required'),
            array('request_order_id, product_id, unit_id, quantity, received_quantity, rest_quantity', 'numerical', 'integerOnly' => true),
            array('notes', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, request_order_id, product_id, unit_id, quantity, received_quantity, rest_quantity, notes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'requestOrder' => array(self::BELONGS_TO, 'TransactionRequestOrder', 'request_order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'request_order_id' => 'Request Order',
            'product_id' => 'Product',
            'unit_id' => 'Unit',
            'quantity' => 'Quantity',
            'received_quantity' => 'Received Quantity',
            'rest_quantity' => 'Rest Quantity',
            'notes' => 'Notes',
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
        $criteria->compare('request_order_id', $this->request_order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('received_quantity', $this->received_quantity);
        $criteria->compare('rest_quantity', $this->rest_quantity);
        $criteria->compare('notes', $this->notes, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
