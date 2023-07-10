<?php

/**
 * This is the model class for table "{{invoice_detail}}".
 *
 * The followings are the available columns in table '{{invoice_detail}}':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $service_id
 * @property integer $product_id
 * @property integer $quick_service_id
 * @property string $quantity
 * @property string $discount
 * @property string $unit_price
 * @property string $total_price
 *
 * The followings are the available model relations:
 * @property InvoiceHeader $invoice
 * @property Service $service
 * @property Product $product
 * @property QuickService $quickService
 */
class InvoiceDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InvoiceDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{invoice_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invoice_id, unit_price, total_price', 'required'),
            array('invoice_id, service_id, product_id, quick_service_id', 'numerical', 'integerOnly' => true),
            array('unit_price, total_price, discount', 'length', 'max' => 18),
            array('quantity', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, invoice_id, service_id, product_id, quick_service_id, quantity, unit_price, total_price, discount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoice' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_id'),
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'quickService' => array(self::BELONGS_TO, 'QuickService', 'quick_service_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'invoice_id' => 'Invoice',
            'service_id' => 'Service',
            'product_id' => 'Product',
            'quick_service_id' => 'Quick Service',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
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
        $criteria->compare('invoice_id', $this->invoice_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('quick_service_id', $this->quick_service_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}