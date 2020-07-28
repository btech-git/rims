<?php

/**
 * This is the model class for table "{{registration_product}}".
 *
 * The followings are the available columns in table '{{registration_product}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property integer $product_id
 * @property integer $quantity
 * @property string $retail_price
 * @property string $recommended_selling_price
 * @property string $hpp
 * @property string $sale_price
 * @property string $discount
 * @property string $total_price
 * @property string $discount_type
 * @property integer $quantity_movement
 * @property integer $quantity_movement_left
 * @property integer $is_material
 * @property integer $quantity_receive
 * @property integer $quantity_receive_left
 * @property string $note
 *
 * The followings are the available model relations:
 * @property MovementOutDetail[] $movementOutDetails
 * @property RegistrationTransaction $registrationTransaction
 * @property Product $product
 */
class RegistrationProduct extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public $product_name;
	public $transaction_number;
	public function tableName()
	{
		return '{{registration_product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('quantity, sale_price, total_price', 'required'),
			array('registration_transaction_id, product_id, quantity, quantity_movement, quantity_movement_left, is_material, quantity_receive, quantity_receive_left', 'numerical', 'integerOnly'=>true),
			array('retail_price, hpp, sale_price, discount, total_price, recommended_selling_price', 'length', 'max'=>18),
			array('discount_type', 'length', 'max'=>30),
			array('note', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_transaction_id, product_id, quantity, retail_price, hpp, sale_price, discount, total_price, discount_type, transaction_number, quantity_movement, quantity_movement_left, is_material, quantity_receive, quantity_receive_left, recommended_selling_price, note', 'safe', 'on'=>'search'),
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
			'movementOutDetails' => array(self::HAS_MANY, 'MovementOutDetail', 'registration_product_id'),
			'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
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
			'registration_transaction_id' => 'Registration Transaction',
			'product_id' => 'Product',
			'quantity' => 'Quantity',
			'retail_price' => 'Retail Price',
			'hpp' => 'Hpp',
			'sale_price' => 'Sale Price',
			'discount' => 'Discount',
			'total_price' => 'Total Price',
			'discount_type' => 'Discount Type',
			'quantity_movement' => 'Quantity Movement',
			'quantity_movement_left' => 'Quantity Movement Left',
			'is_material' => 'Is Material',
			'quantity_receive' => 'Quantity Receive',
			'quantity_receive_left' => 'Quantity Receive Left',
            'recommended_selling_price' => 'Recommended Selling Price',
            'note' => 'Note'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('registration_transaction_id',$this->registration_transaction_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('retail_price',$this->retail_price,true);
		$criteria->compare('hpp',$this->hpp,true);
		$criteria->compare('sale_price',$this->sale_price,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('total_price',$this->total_price,true);
		$criteria->compare('discount_type',$this->discount_type,true);
		$criteria->compare('quantity_movement',$this->quantity_movement);
		$criteria->compare('quantity_movement_left',$this->quantity_movement_left);
		$criteria->compare('is_material',$this->is_material);
		$criteria->compare('quantity_receive',$this->quantity_receive);
		$criteria->compare('quantity_receive_left',$this->quantity_receive_left);
		$criteria->compare('recommended_selling_price',$this->recommended_selling_price);
		$criteria->compare('note',$this->note);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getDiscountAmount() {
        return ($this->discount_type == 'Nominal') ? $this->discount : $this->quantity * $this->sale_price * $this->discount / 100 ;
    }
    
    public function getTotalAmountProduct() {
        
        $priceAfterDiscount = $this->quantity * $this->sale_price - $this->discountAmount;
        $taxNominal = 0;
        
        return $priceAfterDiscount + $taxNominal;
    }

    public function getTotalPriceAfterTax() {
        $taxValue = ($this->registrationTransaction->ppn == 0) ? 0 : 10;
        $totalAfterTax = $this->total_price * (1 + $taxValue/100);
        
        return $totalAfterTax;
    }
}