<?php

/**
 * This is the model class for table "{{transaction_request_order_detail}}".
 *
 * The followings are the available columns in table '{{transaction_request_order_detail}}':
 * @property integer $id
 * @property integer $request_order_id
 * @property integer $product_id
 * @property integer $supplier_id
 * @property string $estimated_arrival_date
 * @property integer $unit_id
 * @property integer $discount_step
 * @property integer $discount1_type
 * @property string $discount1_nominal
 * @property integer $discount2_type
 * @property string $discount2_nominal
 * @property integer $discount3_type
 * @property string $discount3_nominal
 * @property integer $discount4_type
 * @property string $discount4_nominal
 * @property integer $discount5_type
 * @property string $discount5_nominal
 * @property string $quantity
 * @property string $total_quantity
 * @property string $last_buying_price
 * @property string $unit_price
 * @property string $total_price
 * @property string $purchase_order_quantity
 * @property string $request_order_quantity_rest
 * @property string $notes
 * @property string $retail_price
 * @property string $approval
 * @property integer $discount1_temp_quantity
 * @property string $discount1_temp_price
 * @property integer $discount2_temp_quantity
 * @property string $discount2_temp_price
 * @property integer $discount3_temp_quantity
 * @property string $discount3_temp_price
 * @property integer $discount4_temp_quantity
 * @property string $discount4_temp_price
 * @property integer $discount5_temp_quantity
 * @property string $discount5_temp_price
 *
 * The followings are the available model relations:
 * @property TransactionPurchaseOrderDetail[] $transactionPurchaseOrderDetails
 * @property TransactionRequestOrderApproval[] $transactionRequestOrderApprovals
 * @property Product $product
 * @property Supplier $supplier
 * @property TransactionRequestOrder $requestOrder
 */
class TransactionRequestOrderDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionRequestOrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_request_order_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_order_id, product_id, supplier_id, unit_id, quantity, total_price', 'required'),
            array('request_order_id, product_id, supplier_id, unit_id, discount_step, discount1_type, discount2_type, discount3_type, discount4_type, discount5_type, discount1_temp_quantity, discount2_temp_quantity, discount3_temp_quantity, discount4_temp_quantity, discount5_temp_quantity', 'numerical', 'integerOnly' => true),
            array('quantity, total_quantity, purchase_order_quantity, request_order_quantity_rest, discount1_nominal, discount2_nominal, discount3_nominal, discount4_nominal, discount5_nominal', 'length', 'max' => 10),
            array('last_buying_price, unit_price, total_price, retail_price, discount1_temp_price, discount2_temp_price, discount3_temp_price, discount4_temp_price, discount5_temp_price', 'length', 'max' => 18),
            array('approval', 'length', 'max' => 30),
            array('estimated_arrival_date, notes', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, request_order_id, product_id, supplier_id, estimated_arrival_date, unit_id, discount_step, discount1_type, discount1_nominal, discount2_type, discount2_nominal, discount3_type, discount3_nominal, discount4_type, discount4_nominal, discount5_type, discount5_nominal, quantity, total_quantity, last_buying_price, unit_price, total_price, purchase_order_quantity, request_order_quantity_rest, notes, retail_price, approval, discount1_temp_quantity, discount1_temp_price, discount2_temp_quantity, discount2_temp_price, discount3_temp_quantity, discount3_temp_price, discount4_temp_quantity, discount4_temp_price, discount5_temp_quantity, discount5_temp_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transactionPurchaseOrderDetails' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetail', 'request_order_detail_id'),
            'transactionRequestOrderApprovals' => array(self::HAS_MANY, 'TransactionRequestOrderApproval', 'request_order_detail_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'requestOrder' => array(self::BELONGS_TO, 'TransactionRequestOrder', 'request_order_id'),
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
            'supplier_id' => 'Supplier',
            'estimated_arrival_date' => 'Estimated Arrival Date',
            'unit_id' => 'Unit',
            'discount_step' => 'Discount Step',
            'discount1_type' => 'Discount1 Type',
            'discount1_nominal' => 'Discount1 Nominal',
            'discount2_type' => 'Discount2 Type',
            'discount2_nominal' => 'Discount2 Nominal',
            'discount3_type' => 'Discount3 Type',
            'discount3_nominal' => 'Discount3 Nominal',
            'discount4_type' => 'Discount4 Type',
            'discount4_nominal' => 'Discount4 Nominal',
            'discount5_type' => 'Discount5 Type',
            'discount5_nominal' => 'Discount5 Nominal',
            'quantity' => 'Quantity',
            'total_quantity' => 'Total Quantity',
            'last_buying_price' => 'Last Buying Price',
            'unit_price' => 'Unit Price',
            'total_price' => 'Total Price',
            'purchase_order_quantity' => 'Purchase Order Quantity',
            'request_order_quantity_rest' => 'Request Order Quantity Rest',
            'notes' => 'Notes',
            'retail_price' => 'Retail Price',
            'approval' => 'Approval',
            'discount1_temp_quantity' => 'Discount1 Temp Quantity',
            'discount1_temp_price' => 'Discount1 Temp Price',
            'discount2_temp_quantity' => 'Discount2 Temp Quantity',
            'discount2_temp_price' => 'Discount2 Temp Price',
            'discount3_temp_quantity' => 'Discount3 Temp Quantity',
            'discount3_temp_price' => 'Discount3 Temp Price',
            'discount4_temp_quantity' => 'Discount4 Temp Quantity',
            'discount4_temp_price' => 'Discount4 Temp Price',
            'discount5_temp_quantity' => 'Discount5 Temp Quantity',
            'discount5_temp_price' => 'Discount5 Temp Price',
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
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('estimated_arrival_date', $this->estimated_arrival_date, true);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('discount_step', $this->discount_step);
        $criteria->compare('discount1_type', $this->discount1_type);
        $criteria->compare('discount1_nominal', $this->discount1_nominal, true);
        $criteria->compare('discount2_type', $this->discount2_type);
        $criteria->compare('discount2_nominal', $this->discount2_nominal, true);
        $criteria->compare('discount3_type', $this->discount3_type);
        $criteria->compare('discount3_nominal', $this->discount3_nominal, true);
        $criteria->compare('discount4_type', $this->discount4_type);
        $criteria->compare('discount4_nominal', $this->discount4_nominal, true);
        $criteria->compare('discount5_type', $this->discount5_type);
        $criteria->compare('discount5_nominal', $this->discount5_nominal, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('last_buying_price', $this->last_buying_price, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('purchase_order_quantity', $this->purchase_order_quantity);
        $criteria->compare('request_order_quantity_rest', $this->request_order_quantity_rest);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('retail_price', $this->retail_price, true);
        $criteria->compare('approval', $this->approval, true);
        $criteria->compare('discount1_temp_quantity', $this->discount1_temp_quantity);
        $criteria->compare('discount1_temp_price', $this->discount1_temp_price, true);
        $criteria->compare('discount2_temp_quantity', $this->discount2_temp_quantity);
        $criteria->compare('discount2_temp_price', $this->discount2_temp_price, true);
        $criteria->compare('discount3_temp_quantity', $this->discount3_temp_quantity);
        $criteria->compare('discount3_temp_price', $this->discount3_temp_price, true);
        $criteria->compare('discount4_temp_quantity', $this->discount4_temp_quantity);
        $criteria->compare('discount4_temp_price', $this->discount4_temp_price, true);
        $criteria->compare('discount5_temp_quantity', $this->discount5_temp_quantity);
        $criteria->compare('discount5_temp_price', $this->discount5_temp_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getDiscount1Amount() {
        $amount = 0.00;

        if ($this->discount1_type == 1)
            $amount = $this->retail_price * $this->discount1_nominal / 100;
        elseif ($this->discount1_type == 2)
            $amount = $this->discount1_nominal;
        else
            $amount = 0.00;

        return $amount;
    }

    public function getUnitPriceAfterDiscount1() {
        return $this->retail_price - $this->discount1Amount;
    }

    public function getDiscount2Amount() {
        $amount = 0.00;

        if ($this->discount2_type == 1)
            $amount = $this->unitPriceAfterDiscount1 * $this->discount2_nominal / 100;
        elseif ($this->discount2_type == 2)
            $amount = $this->discount2_nominal;
        else
            $amount = 0.00;

        return $amount;
    }

    public function getUnitPriceAfterDiscount2() {
        return $this->unitPriceAfterDiscount1 - $this->discount2Amount;
    }

    public function getDiscount3Amount() {
        $amount = 0.00;

        if ($this->discount3_type == 1)
            $amount = $this->unitPriceAfterDiscount2 * $this->discount3_nominal / 100;
        elseif ($this->discount3_type == 2)
            $amount = $this->discount3_nominal;
        else
            $amount = 0.00;

        return $amount;
    }

    public function getUnitPriceAfterDiscount3() {
        return $this->unitPriceAfterDiscount2 - $this->discount3Amount;
    }

    public function getDiscount4Amount() {
        $amount = 0.00;

        if ($this->discount4_type == 1)
            $amount = $this->unitPriceAfterDiscount3 * $this->discount4_nominal / 100;
        elseif ($this->discount4_type == 2)
            $amount = $this->discount4_nominal;
        else
            $amount = 0.00;

        return $amount;
    }

    public function getUnitPriceAfterDiscount4() {
        return $this->unitPriceAfterDiscount3 - $this->discount4Amount;
    }

    public function getDiscount5Amount() {
        $amount = 0.00;

        if ($this->discount5_type == 1)
            $amount = $this->unitPriceAfterDiscount4 * $this->discount5_nominal / 100;
        elseif ($this->discount5_type == 2)
            $amount = $this->discount5_nominal;
        else
            $amount = 0.00;

        return $amount;
    }

    public function getUnitPriceAfterDiscount5() {
        return $this->unitPriceAfterDiscount4 - $this->discount5Amount;
    }

    public function getQuantityAfterBonus() {
        $bonusQuantity1 = ($this->discount1_type == 3) ? $this->discount1_nominal : 0;
        $bonusQuantity2 = ($this->discount2_type == 3) ? $this->discount2_nominal : 0;
        $bonusQuantity3 = ($this->discount3_type == 3) ? $this->discount3_nominal : 0;
        $bonusQuantity4 = ($this->discount4_type == 3) ? $this->discount4_nominal : 0;
        $bonusQuantity5 = ($this->discount5_type == 3) ? $this->discount5_nominal : 0;

        return $this->quantity + $bonusQuantity1 + $bonusQuantity2 + $bonusQuantity3 + $bonusQuantity4 + $bonusQuantity5;
    }

    public function getTotalDiscount() {
        return $this->getDiscount1Amount() + $this->getDiscount2Amount() + $this->getDiscount3Amount() + $this->getDiscount4Amount() + $this->getDiscount5Amount();
    }

    public function getUnitPrice() {
        $unitPrice = 0.00;

        if ($this->discount_step == 1)
            $unitPrice = ($this->discount1_type == 3) ? $this->unitPriceAfterDiscount1 * $this->quantity / ($this->quantity + $this->discount1_nominal) : $this->unitPriceAfterDiscount1;
        elseif ($this->discount_step == 2)
            $unitPrice = ($this->discount2_type == 3) ? $this->unitPriceAfterDiscount2 * $this->quantity / ($this->quantity + $this->discount2_nominal) : $this->unitPriceAfterDiscount2;
        elseif ($this->discount_step == 3)
            $unitPrice = ($this->discount3_type == 3) ? $this->unitPriceAfterDiscount3 * $this->quantity / ($this->quantity + $this->discount3_nominal) : $this->unitPriceAfterDiscount3;
        elseif ($this->discount_step == 4)
            $unitPrice = ($this->discount4_type == 3) ? $this->unitPriceAfterDiscount4 * $this->quantity / ($this->quantity + $this->discount4_nominal) : $this->unitPriceAfterDiscount4;
        elseif ($this->discount_step == 5)
            $unitPrice = ($this->discount5_type == 3) ? $this->unitPriceAfterDiscount5 * $this->quantity / ($this->quantity + $this->discount5_nominal) : $this->unitPriceAfterDiscount5;
        else
            $unitPrice = $this->retail_price;

        return $unitPrice;
    }

    public function getTotalBeforeDiscount() {
        return $this->quantity * $this->retail_price;
    }

    public function getSubTotal() {
        $total = 0.00;

        if ($this->discount_step == 1)
            $total = $this->quantity * $this->unitPriceAfterDiscount1;
        elseif ($this->discount_step == 2)
            $total = $this->quantity * $this->unitPriceAfterDiscount2;
        elseif ($this->discount_step == 3)
            $total = $this->quantity * $this->unitPriceAfterDiscount3;
        elseif ($this->discount_step == 4)
            $total = $this->quantity * $this->unitPriceAfterDiscount4;
        elseif ($this->discount_step == 5)
            $total = $this->quantity * $this->unitPriceAfterDiscount5;
        else
            $total = $this->quantity * $this->retail_price;

        return $total;
    }

    public function getDiscountType1Literal() {
        $discountTypeLiteral = '';

        if ($this->discount1_type == 1)
            $discountTypeLiteral = '%';
        elseif ($this->discount1_type == 2)
            $discountTypeLiteral = 'Rp';
        elseif ($this->discount1_type == 3)
            $discountTypeLiteral = 'Pcs';
        else
            $discountTypeLiteral;

        return $discountTypeLiteral;
    }

    public function getDiscountType2Literal() {
        $discountTypeLiteral = '';

        if ($this->discount2_type == 1)
            $discountTypeLiteral = '%';
        elseif ($this->discount2_type == 2)
            $discountTypeLiteral = 'Rp';
        elseif ($this->discount2_type == 3)
            $discountTypeLiteral = 'Pcs';
        else
            $discountTypeLiteral;

        return $discountTypeLiteral;
    }

    public function getDiscountType3Literal() {
        $discountTypeLiteral = '';

        if ($this->discount3_type == 1)
            $discountTypeLiteral = '%';
        elseif ($this->discount3_type == 2)
            $discountTypeLiteral = 'Rp';
        elseif ($this->discount3_type == 3)
            $discountTypeLiteral = 'Pcs';
        else
            $discountTypeLiteral;

        return $discountTypeLiteral;
    }

    public function getDiscountType4Literal() {
        $discountTypeLiteral = '';

        if ($this->discount4_type == 1)
            $discountTypeLiteral = '%';
        elseif ($this->discount4_type == 2)
            $discountTypeLiteral = 'Rp';
        elseif ($this->discount4_type == 3)
            $discountTypeLiteral = 'Pcs';
        else
            $discountTypeLiteral;

        return $discountTypeLiteral;
    }

    public function getDiscountType5Literal() {
        $discountTypeLiteral = '';

        if ($this->discount5_type == 1)
            $discountTypeLiteral = '%';
        elseif ($this->discount5_type == 2)
            $discountTypeLiteral = 'Rp';
        elseif ($this->discount5_type == 3)
            $discountTypeLiteral = 'Pcs';
        else
            $discountTypeLiteral;

        return $discountTypeLiteral;
    }

}
