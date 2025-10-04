<?php

/**
 * This is the model class for table "{{service_product}}".
 *
 * The followings are the available columns in table '{{service_product}}':
 * @property integer $id
 * @property integer $quantity
 * @property integer $service_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property Product $product
 * @property Unit $unit
 */
class ServiceProduct extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ServiceProduct the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{service_product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('service_id, product_id, unit_id, status', 'required'),
            array('quantity, service_id, product_id, unit_id', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, quantity, service_id, product_id, unit_id, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
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
            'quantity' => 'Quantity',
            'service_id' => 'Service',
            'product_id' => 'Product',
            'unit_id' => 'Unit',
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
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
