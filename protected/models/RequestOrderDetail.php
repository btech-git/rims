<?php

/**
 * This is the model class for table "{{request_order_detail}}".
 *
 * The followings are the available columns in table '{{request_order_detail}}':
 * @property integer $id
 * @property integer $request_order_id
 * @property integer $product_id
 * @property integer $unit_id
 * @property integer $quantity
 * @property integer $price
 * @property integer $discount
 * @property string $subtotal
 */
class RequestOrderDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{request_order_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, request_order_id, product_id, unit_id, quantity, price, discount, subtotal', 'required'),
			array('id, request_order_id, product_id, unit_id, quantity, price, discount', 'numerical', 'integerOnly'=>true),
			array('subtotal', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_order_id, product_id, unit_id, quantity, price, discount, subtotal', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_order_id' => 'Request Order',
			'product_id' => 'Product',
			'unit_id' => 'Unit',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'discount' => 'Discount',
			'subtotal' => 'Subtotal',
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
		$criteria->compare('request_order_id',$this->request_order_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('unit_id',$this->unit_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('subtotal',$this->subtotal,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RequestOrderDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
