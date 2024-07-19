<?php

/**
 * This is the model class for table "{{transaction_purchase_order_detail}}".
 *
 * The followings are the available columns in table '{{transaction_purchase_order_detail}}':
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property string $retail_price
 * @property string $quantity
 * @property string $unit_price
 * @property string $tax_amount
 * @property string $price_before_tax
 * @property integer $discount_step
 * @property integer $discount1_type
 * @property string $discount1_nominal
 * @property integer $discount1_temp_quantity
 * @property string $discount1_temp_price
 * @property integer $discount2_type
 * @property string $discount2_nominal
 * @property integer $discount2_temp_quantity
 * @property string $discount2_temp_price
 * @property integer $discount3_type
 * @property string $discount3_nominal
 * @property integer $discount3_temp_quantity
 * @property string $discount3_temp_price
 * @property integer $discount4_type
 * @property string $discount4_nominal
 * @property integer $discount4_temp_quantity
 * @property string $discount4_temp_price
 * @property integer $discount5_type
 * @property string $discount5_nominal
 * @property integer $discount5_temp_quantity
 * @property string $discount5_temp_price
 * @property string $total_quantity
 * @property string $total_before_tax
 * @property string $discount
 * @property string $total_price
 * @property string $receive_quantity
 * @property string $purchase_order_quantity_left
 * @property string $last_buying_price
 * @property string $memo
 *
 * The followings are the available model relations:
 * @property TransactionPurchaseOrder $purchaseOrder
 * @property Product $product
 * @property TransactionPurchaseOrderDetailRequest[] $transactionPurchaseOrderDetailRequests
 * @property TransactionReceiveItemDetail[] $transactionReceiveItemDetails
 */
class TransactionPurchaseOrderDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $request_order_id;
    public $request_order_detail_id;
    public $request_quantity;
    public $request_price;
    public $request_order_no;
    public $branch_id;
    public $branch_name;
    public $product_name;
    public $estimate_date_arrival;
    public $purchaseQuantity;
    public $hpp;
//    public $tax_amount;

    public function tableName() {
        return '{{transaction_purchase_order_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('purchase_order_id, retail_price, quantity, unit_price, total_quantity, price_before_tax, total_before_tax, discount_step, total_price', 'required'),
            array('purchase_order_id, product_id, unit_id, discount_step, discount1_type, discount1_temp_quantity, discount2_type, discount2_temp_quantity, discount3_type, discount3_temp_quantity, discount4_type, discount4_temp_quantity, discount5_type, discount5_temp_quantity', 'numerical', 'integerOnly' => true),
            array('last_buying_price, retail_price, unit_price, discount1_temp_price, discount2_temp_price, discount3_temp_price, discount4_temp_price, discount5_temp_price, price_before_tax, total_before_tax, discount, total_price', 'length', 'max' => 18),
            array('quantity, total_quantity, receive_quantity, purchase_order_quantity_left, discount1_nominal, discount2_nominal, discount3_nominal, discount4_nominal, discount5_nominal, tax_amount', 'length', 'max' => 10),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, last_buying_price, purchase_order_id, product_id, unit_id, retail_price, quantity, unit_price, price_before_tax, total_before_tax, discount_step, discount1_type, discount1_nominal, discount1_temp_quantity, discount1_temp_price, discount2_type, discount2_nominal, discount2_temp_quantity, discount2_temp_price, discount3_type, discount3_nominal, discount3_temp_quantity, discount3_temp_price, discount4_type, discount4_nominal, discount4_temp_quantity, discount4_temp_price, discount5_type, discount5_nominal, discount5_temp_quantity, discount5_temp_price, total_quantity, subtotal, discount, total_price, receive_quantity, purchase_order_quantity_left, tax_amount, memo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'purchaseOrder' => array(self::BELONGS_TO, 'TransactionPurchaseOrder', 'purchase_order_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'transactionPurchaseOrderDetailRequests' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetailRequest', 'purchase_order_detail_id'),
            'transactionReceiveItemDetails' => array(self::HAS_MANY, 'TransactionReceiveItemDetail', 'purchase_order_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order',
            'product_id' => 'Product',
            'unit_id' => 'Unit',
            'retail_price' => 'Retail Price',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'price_before_tax' => 'DPP',
            'discount_step' => 'Discount Step',
            'discount1_type' => 'Discount1 Type',
            'discount1_nominal' => 'Discount1 Nominal',
            'discount1_temp_quantity' => 'Discount1 Temp Quantity',
            'discount1_temp_price' => 'Discount1 Temp Price',
            'discount2_type' => 'Discount2 Type',
            'discount2_nominal' => 'Discount2 Nominal',
            'discount2_temp_quantity' => 'Discount2 Temp Quantity',
            'discount2_temp_price' => 'Discount2 Temp Price',
            'discount3_type' => 'Discount3 Type',
            'discount3_nominal' => 'Discount3 Nominal',
            'discount3_temp_quantity' => 'Discount3 Temp Quantity',
            'discount3_temp_price' => 'Discount3 Temp Price',
            'discount4_type' => 'Discount4 Type',
            'discount4_nominal' => 'Discount4 Nominal',
            'discount4_temp_quantity' => 'Discount4 Temp Quantity',
            'discount4_temp_price' => 'Discount4 Temp Price',
            'discount5_type' => 'Discount5 Type',
            'discount5_nominal' => 'Discount5 Nominal',
            'discount5_temp_quantity' => 'Discount5 Temp Quantity',
            'discount5_temp_price' => 'Discount5 Temp Price',
            'total_quantity' => 'Total Quantity',
            'total_before_tax' => 'Total DPP',
            'discount' => 'Discount',
            'total_price' => 'Total Price',
            'receive_quantity' => 'Receive Quantity',
            'purchase_order_quantity_left' => 'Purchase Order Quantity Left',
            'last_buying_price' => 'Last Buying Price',
            'tax_amount' => 'PPN',
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
        $criteria->compare('purchase_order_id', $this->purchase_order_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('retail_price', $this->retail_price, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('price_before_tax', $this->price_before_tax);
        $criteria->compare('discount_step', $this->discount_step);
        $criteria->compare('discount1_type', $this->discount1_type);
        $criteria->compare('discount1_nominal', $this->discount1_nominal, true);
        $criteria->compare('discount1_temp_quantity', $this->discount1_temp_quantity);
        $criteria->compare('discount1_temp_price', $this->discount1_temp_price, true);
        $criteria->compare('discount2_type', $this->discount2_type);
        $criteria->compare('discount2_nominal', $this->discount2_nominal, true);
        $criteria->compare('discount2_temp_quantity', $this->discount2_temp_quantity);
        $criteria->compare('discount2_temp_price', $this->discount2_temp_price, true);
        $criteria->compare('discount3_type', $this->discount3_type);
        $criteria->compare('discount3_nominal', $this->discount3_nominal, true);
        $criteria->compare('discount3_temp_quantity', $this->discount3_temp_quantity);
        $criteria->compare('discount3_temp_price', $this->discount3_temp_price, true);
        $criteria->compare('discount4_type', $this->discount4_type);
        $criteria->compare('discount4_nominal', $this->discount4_nominal, true);
        $criteria->compare('discount4_temp_quantity', $this->discount4_temp_quantity);
        $criteria->compare('discount4_temp_price', $this->discount4_temp_price, true);
        $criteria->compare('discount5_type', $this->discount5_type);
        $criteria->compare('discount5_nominal', $this->discount5_nominal, true);
        $criteria->compare('discount5_temp_quantity', $this->discount5_temp_quantity);
        $criteria->compare('discount5_temp_price', $this->discount5_temp_price, true);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_before_tax', $this->total_before_tax, true);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('receive_quantity', $this->receive_quantity);
        $criteria->compare('purchase_order_quantity_left', $this->purchase_order_quantity_left);
        $criteria->compare('last_buying_price', $this->last_buying_price, true);
        $criteria->compare('tax_amount', $this->tax_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionPurchaseOrderDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDiscount1Amount() {
        $amount = 0.00;

        if ($this->discount1_type == 1)
            $amount = round($this->retail_price * $this->discount1_nominal / 100, 2);
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
            $amount = round($this->unitPriceAfterDiscount1 * $this->discount2_nominal / 100, 2);
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
            $amount = round($this->unitPriceAfterDiscount2 * $this->discount3_nominal / 100, 2);
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
            $amount = round($this->unitPriceAfterDiscount3 * $this->discount4_nominal / 100, 2);
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
            $amount = round($this->unitPriceAfterDiscount4 * $this->discount5_nominal / 100, 2);
        elseif ($this->discount5_type == 2)
            $amount = $this->discount5_nominal;
        else
            $amount = 0.00;

        return $amount;
    }

    public function getUnitPriceAfterDiscount5() {
        return $this->unitPriceAfterDiscount4 - $this->discount5Amount;
    }

    public function getUnitPrice($tax, $taxPercentage) {
        $unitPrice = 0.00;

        if ($this->discount_step == 1) {
            $unitPrice = ($this->discount1_type == 3) ? round($this->unitPriceAfterDiscount1 * $this->quantity / ($this->quantity + $this->discount1_nominal), 2) : $this->unitPriceAfterDiscount1;
        } elseif ($this->discount_step == 2) {
            $unitPrice = ($this->discount2_type == 3) ? round($this->unitPriceAfterDiscount2 * $this->quantity / ($this->quantity + $this->discount2_nominal), 2) : $this->unitPriceAfterDiscount2;
        } elseif ($this->discount_step == 3) {
            $unitPrice = ($this->discount3_type == 3) ? round($this->unitPriceAfterDiscount3 * $this->quantity / ($this->quantity + $this->discount3_nominal), 2) : $this->unitPriceAfterDiscount3;
        } elseif ($this->discount_step == 4) {
            $unitPrice = ($this->discount4_type == 3) ? round($this->unitPriceAfterDiscount4 * $this->quantity / ($this->quantity + $this->discount4_nominal), 2) : $this->unitPriceAfterDiscount4;
        } elseif ($this->discount_step == 5) {
            $unitPrice = ($this->discount5_type == 3) ? round($this->unitPriceAfterDiscount5 * $this->quantity / ($this->quantity + $this->discount5_nominal), 2) : $this->unitPriceAfterDiscount5;
        } else {
            $unitPrice = $this->retail_price;
        }

        return ($tax == 1) ? round($unitPrice * (1 + ($taxPercentage / 100)), 2) : $unitPrice;
    }

    public function getPriceBeforeTax($tax, $taxPercentage) {
        $unitPrice = 0.00;

        if ($this->discount_step == 1) {
            $unitPrice = ($this->discount1_type == 3) ? round($this->unitPriceAfterDiscount1 * $this->quantity / ($this->quantity + $this->discount1_nominal), 2) : $this->unitPriceAfterDiscount1;
        } elseif ($this->discount_step == 2) {
            $unitPrice = ($this->discount2_type == 3) ? round($this->unitPriceAfterDiscount2 * $this->quantity / ($this->quantity + $this->discount2_nominal), 2) : $this->unitPriceAfterDiscount2;
        } elseif ($this->discount_step == 3) {
            $unitPrice = ($this->discount3_type == 3) ? round($this->unitPriceAfterDiscount3 * $this->quantity / ($this->quantity + $this->discount3_nominal), 2) : $this->unitPriceAfterDiscount3;
        } elseif ($this->discount_step == 4) {
            $unitPrice = ($this->discount4_type == 3) ? round($this->unitPriceAfterDiscount4 * $this->quantity / ($this->quantity + $this->discount4_nominal), 2) : $this->unitPriceAfterDiscount4;
        } elseif ($this->discount_step == 5) {
            $unitPrice = ($this->discount5_type == 3) ? round($this->unitPriceAfterDiscount5 * $this->quantity / ($this->quantity + $this->discount5_nominal), 2) : $this->unitPriceAfterDiscount5;
        } else {
            $unitPrice = $this->retail_price;
        }

        return ($tax == 3) ? round($this->getUnitPrice($tax, $taxPercentage) / (1 + ($taxPercentage / 100)), 2) : $unitPrice;
    }
    
    public function getTotalPriceBeforeTax($tax, $taxPercentage) {
        return $this->getPriceBeforeTax($tax, $taxPercentage) * $this->quantity;
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

    public function getSubTotal($tax, $taxPercentage) {
        $total = 0.00;

        if ($this->discount_step == 1) {
            $total = $this->quantity * $this->unitPriceAfterDiscount1;
        } elseif ($this->discount_step == 2) {
            $total = $this->quantity * $this->unitPriceAfterDiscount2;
        } elseif ($this->discount_step == 3) {
            $total = $this->quantity * $this->unitPriceAfterDiscount3;
        } elseif ($this->discount_step == 4) {
            $total = $this->quantity * $this->unitPriceAfterDiscount4;
        } elseif ($this->discount_step == 5) {
            $total = $this->quantity * $this->unitPriceAfterDiscount5;
        } else {
            $total = $this->quantity * $this->retail_price;
        }   

        return ($tax == 1) ? $total * (1 + ($taxPercentage / 100)) : $total;
    }

    public function getTaxAmount($tax, $taxPercentage) {
        return ($tax == 2) ? 0 : $this->getTotalPriceBeforeTax($tax, $taxPercentage) * $taxPercentage / 100;
    }

    public function getTotalBeforeDiscount() {
        return $this->quantity * $this->retail_price;
    }

    public function getQuantityReceiveTotal() {
        $total = 0;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $total += $detail->qty_received;
        }

        return $total;
    }
    
    public function getQuantityReceiveRemaining() {
        
        return $this->total_quantity - $this->receive_quantity;
    }

    public function getDiscountType1Literal() {
        $discountTypeLiteral = '';

        if ($this->discount1_type == 1) {
            $discountTypeLiteral = '%';
        } elseif ($this->discount1_type == 2) {
            $discountTypeLiteral = 'Rp';
        } elseif ($this->discount1_type == 3) {
            $discountTypeLiteral = 'Pcs';
        } else {
            $discountTypeLiteral = '';
        }

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

    public function getTotalQuantityReceived() {
        $total = 0;

        foreach ($this->transactionReceiveItemDetails as $detail) {
            $total += $detail->qty_received;
        }

        return $total;
    }

}
