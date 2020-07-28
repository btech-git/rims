<?php

/**
 * This is the model class for table "{{transaction_sales_order_detail}}".
 *
 * The followings are the available columns in table '{{transaction_sales_order_detail}}':
 * @property integer $id
 * @property integer $sales_order_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property string $retail_price
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $amount
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
 * @property integer $total_quantity
 * @property string $discount
 * @property string $subtotal
 * @property string $total_price
 * @property integer $delivery_quantity
 * @property integer $sales_order_quantity_left
 *
 * The followings are the available model relations:
 * @property TransactionDeliveryOrderDetail[] $transactionDeliveryOrderDetails
 * @property TransactionSalesOrder $salesOrder
 * @property Product $product
 */
class TransactionSalesOrderDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $product_name;
	public $hpp;
	public $tax_amount;
    
	public function tableName()
	{
		return '{{transaction_sales_order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sales_order_id, product_id, retail_price, quantity, unit_price', 'required'),
			array('sales_order_id, product_id, unit_id, quantity, amount, discount_step, discount1_type, discount1_temp_quantity, discount2_type, discount2_temp_quantity, discount3_type, discount3_temp_quantity, discount4_type, discount4_temp_quantity, discount5_type, discount5_temp_quantity, total_quantity, delivery_quantity, sales_order_quantity_left', 'numerical', 'integerOnly'=>true),
			array('retail_price, unit_price, discount1_temp_price, discount2_temp_price, discount3_temp_price, discount4_temp_price, discount5_temp_price, total_price, discount, subtotal', 'length', 'max'=>18),
			array('discount1_nominal, discount2_nominal, discount3_nominal, discount4_nominal, discount5_nominal', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sales_order_id, product_id, unit_id, retail_price, quantity, unit_price, amount, discount_step, discount1_type, discount1_nominal, discount1_temp_quantity, discount1_temp_price, discount2_type, discount2_nominal, discount2_temp_quantity, discount2_temp_price, discount3_type, discount3_nominal, discount3_temp_quantity, discount3_temp_price, discount4_type, discount4_nominal, discount4_temp_quantity, discount4_temp_price, discount5_type, discount5_nominal, discount5_temp_quantity, discount5_temp_price, total_quantity, total_price, delivery_quantity, sales_order_quantity_left, discount, subtotal', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'transactionDeliveryOrderDetails' => array(self::HAS_MANY, 'TransactionDeliveryOrderDetail', 'sales_order_detail_id'),
			'salesOrder' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'sales_order_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sales_order_id' => 'Sales Order',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'retail_price' => 'Retail Price',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'amount' => 'Amount',
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
			'discount' => 'Discount',
			'subtotal' => 'Subtotal',
			'total_price' => 'Total Price',
			'delivery_quantity' => 'Delivery Quantity',
			'sales_order_quantity_left' => 'Sales Order Quantity Left',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('sales_order_id',$this->sales_order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('retail_price',$this->retail_price,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('discount_step',$this->discount_step);
		$criteria->compare('discount1_type',$this->discount1_type);
		$criteria->compare('discount1_nominal',$this->discount1_nominal,true);
		$criteria->compare('discount1_temp_quantity',$this->discount1_temp_quantity);
		$criteria->compare('discount1_temp_price',$this->discount1_temp_price,true);
		$criteria->compare('discount2_type',$this->discount2_type);
		$criteria->compare('discount2_nominal',$this->discount2_nominal,true);
		$criteria->compare('discount2_temp_quantity',$this->discount2_temp_quantity);
		$criteria->compare('discount2_temp_price',$this->discount2_temp_price,true);
		$criteria->compare('discount3_type',$this->discount3_type);
		$criteria->compare('discount3_nominal',$this->discount3_nominal,true);
		$criteria->compare('discount3_temp_quantity',$this->discount3_temp_quantity);
		$criteria->compare('discount3_temp_price',$this->discount3_temp_price,true);
		$criteria->compare('discount4_type',$this->discount4_type);
		$criteria->compare('discount4_nominal',$this->discount4_nominal,true);
		$criteria->compare('discount4_temp_quantity',$this->discount4_temp_quantity);
		$criteria->compare('discount4_temp_price',$this->discount4_temp_price,true);
		$criteria->compare('discount5_type',$this->discount5_type);
		$criteria->compare('discount5_nominal',$this->discount5_nominal,true);
		$criteria->compare('discount5_temp_quantity',$this->discount5_temp_quantity);
		$criteria->compare('discount5_temp_price',$this->discount5_temp_price,true);
		$criteria->compare('total_quantity',$this->total_quantity);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('total_price',$this->total_price,true);
		$criteria->compare('delivery_quantity',$this->delivery_quantity);
		$criteria->compare('sales_order_quantity_left',$this->sales_order_quantity_left);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionSalesOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
    
    public function getTotalDiscount () {
        return $this->getDiscount1Amount() + $this->getDiscount2Amount() + $this->getDiscount3Amount() + $this->getDiscount4Amount() + $this->getDiscount5Amount();
    }
    
    public function getTotalBeforeDiscount() {
        return $this->quantity * $this->retail_price;
    }
    
//    public function getTotal() {
//        return $this->quantity * $this->unitPrice;
//    }
    
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
    
    public function getTaxAmount($tax) {
        return ($tax == 1) ? $this->subTotal * .1 : 0;
    }
    
    public function getGrandTotal() {
        $taxAmount = empty($this->salesOrder) ? 0 : $this->getTaxAmount($this->salesOrder->ppn);
        
        return $this->subTotal + $taxAmount;
    }
    
    public function getTotalQuantity() {
        $bonus1 = ($this->discount1_type == 3) ? $this->discount1_nominal : 0;
        $bonus2 = ($this->discount2_type == 3) ? $this->discount2_nominal : 0;
        $bonus3 = ($this->discount3_type == 3) ? $this->discount3_nominal : 0;
        $bonus4 = ($this->discount4_type == 3) ? $this->discount4_nominal : 0;
        $bonus5 = ($this->discount5_type == 3) ? $this->discount5_nominal : 0;
        
        return $this->quantity + $bonus1 + $bonus2 + $bonus3 + $bonus4 + $bonus5;
    }
    
    public function getRemainingQuantityDelivery() {
        $total = 0;
        
        foreach ($this->transactionDeliveryOrderDetails as $detail)
            $total += $detail->quantity_delivery;
        
        return $this->quantity - $total;
    }
}
