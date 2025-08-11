<?php

/**
 * This is the model class for table "{{material_request_detail}}".
 *
 * The followings are the available columns in table '{{material_request_detail}}':
 * @property integer $id
 * @property string $quantity
 * @property string $quantity_movement_out
 * @property string $quantity_remaining
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $material_request_header_id
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Unit $unit
 * @property MaterialRequestHeader $materialRequestHeader
 * @property MovementOutDetail[] $movementOutDetails
 */
class MaterialRequestDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MaterialRequestDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{material_request_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, unit_id, material_request_header_id', 'required'),
            array('product_id, unit_id, material_request_header_id', 'numerical', 'integerOnly' => true),
            array('quantity, quantity_movement_out, quantity_remaining', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, quantity, quantity_movement_out, quantity_remaining, product_id, unit_id, material_request_header_id', 'safe', 'on' => 'search'),
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
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'materialRequestHeader' => array(self::BELONGS_TO, 'MaterialRequestHeader', 'material_request_header_id'),
            'movementOutDetails' => array(self::HAS_MANY, 'MovementOutDetail', 'material_request_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'quantity_movement_out' => 'Quantity Movement Out',
            'quantity_remaining' => 'Quantity Remaining',
            'product_id' => 'Product',
            'unit_id' => 'Satuan',
            'material_request_header_id' => 'Material Request Header',
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
        $criteria->compare('quantity_movement_out', $this->quantity_movement_out);
        $criteria->compare('quantity_remaining', $this->quantity_remaining);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('material_request_header_id', $this->material_request_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchByMovementOut() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('quantity_movement_out', $this->quantity_movement_out);
        $criteria->compare('quantity_remaining', $this->quantity_remaining);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('material_request_header_id', $this->material_request_header_id);

        $criteria->addCondition("t.quantity_remaining > 0");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalQuantityMovementOut() {
        $total = 0;
        
        foreach ($this->movementOutDetails as $detail) {
            if ($detail->movementOutHeader->status !== 'CANCELLED!!!') {
                $total += $detail->quantity;
            }
        }
        
        return $total;
    }
    
    public function getQuantityMovementLeft() {
        return $this->quantity - $this->quantity_movement_out;
    }
    
    public function getTotalProductPrice() {

        $quantity = $this->quantity_movement_out;
        if ($this->unit_id !== $this->product->unit_id) {
            $conversionFactor = 1;
            $unitConversion = UnitConversion::model()->findByAttributes(array(
                'unit_from_id' => $this->unit_id, 
                'unit_to_id' => $this->product->unit_id
            ));
            if ($unitConversion !== null) {
                $conversionFactor = $unitConversion->multiplier;
            } else {
                $unitConversionFlipped = UnitConversion::model()->findByAttributes(array(
                    'unit_from_id' => $this->product->unit_id, 
                    'unit_to_id' => $this->unit_id
                ));
                if ($unitConversionFlipped !== null) {
                    $conversionFactor = 1 / $unitConversionFlipped->multiplier;
                }
            }
            $quantity = $conversionFactor * $quantity;
        }

        return $quantity * $this->product->hpp;
    }
}
