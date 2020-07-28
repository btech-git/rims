<?php

/**
 * This is the model class for table "{{transaction_sent_request_detail}}".
 *
 * The followings are the available columns in table '{{transaction_sent_request_detail}}':
 * @property integer $id
 * @property integer $sent_request_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $unit_price
 * @property integer $unit_id
 * @property integer $amount
 * @property integer $sent_request_quantity_left
 * @property integer $delivery_quantity
 *
 * The followings are the available model relations:
 * @property TransactionDeliveryOrderDetail[] $transactionDeliveryOrderDetails
 * @property TransactionSentRequest $sentRequest
 * @property Product $product
 */
class TransactionSentRequestDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{transaction_sent_request_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sent_request_id, product_id, quantity, unit_price', 'required'),
			array('sent_request_id, product_id, quantity, unit_id, amount, sent_request_quantity_left, delivery_quantity', 'numerical', 'integerOnly'=>true),
			array('unit_price', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sent_request_id, product_id, quantity, unit_price, unit_id, amount, sent_request_quantity_left, delivery_quantity', 'safe', 'on'=>'search'),
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
			'transactionDeliveryOrderDetails' => array(self::HAS_MANY, 'TransactionDeliveryOrderDetail', 'sent_request_detail_id'),
			'sentRequest' => array(self::BELONGS_TO, 'TransactionSentRequest', 'sent_request_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sent_request_id' => 'Sent Request',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'unit_price' => 'Unit Price',
			'unit_id' => 'Unit',
			'amount' => 'Amount',
			'sent_request_quantity_left' => 'Sent Request Quantity Left',
			'delivery_quantity' => 'Delivery Quantity',
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
		$criteria->compare('sent_request_id',$this->sent_request_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('unit_price',$this->unit_price,true);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('sent_request_quantity_left',$this->sent_request_quantity_left);
		$criteria->compare('delivery_quantity',$this->delivery_quantity);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TransactionSentRequestDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getTotal() {
        return $this->quantity * $this->unit_price;
    }
    
    public function getTotalQuantityDelivered() {
        $total = 0;
        
        foreach ($this->transactionDeliveryOrderDetails as $detail)
            $total += $detail->quantity_delivery;
        
        return $total;
    }
    
    public function getRemainingQuantityDelivery() {
        $quantityRemaining = 0;
        
        foreach ($this->transactionDeliveryOrderDetails as $detail)
            $quantityRemaining += $detail->quantity_delivery;
        
        return $this->quantity - $quantityRemaining;
    }
}
