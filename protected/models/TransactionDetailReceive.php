<?php

/**
 * This is the model class for table "{{transaction_detail_receive}}".
 *
 * The followings are the available columns in table '{{transaction_detail_receive}}':
 * @property integer $id
 * @property integer $purchase_order_id
 * @property integer $purchase_order_detail_id
 * @property integer $receive_order_id
 * @property integer $quantity_good
 * @property integer $quantity_reject
 * @property integer $quantity_more
 * @property string $purchase_order_estimate_arrival_date
 * @property string $receive_order_estimate_arrival_date
 * @property integer $purchase_request_detail_id
 */
class TransactionDetailReceive extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransactionDetailReceive the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{transaction_detail_receive}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchase_order_id, purchase_order_detail_id, receive_order_id, quantity_good, quantity_reject, quantity_more, purchase_request_detail_id', 'numerical', 'integerOnly'=>true),
			array('purchase_order_estimate_arrival_date, receive_order_estimate_arrival_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, purchase_order_id, purchase_order_detail_id, receive_order_id, quantity_good, quantity_reject, quantity_more, purchase_order_estimate_arrival_date, receive_order_estimate_arrival_date, purchase_request_detail_id', 'safe', 'on'=>'search'),
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
			'purchase_order_id' => 'Purchase Order',
			'purchase_order_detail_id' => 'Purchase Order Detail',
			'receive_order_id' => 'Receive Order',
			'quantity_good' => 'Quantity Good',
			'quantity_reject' => 'Quantity Reject',
			'quantity_more' => 'Quantity More',
			'purchase_order_estimate_arrival_date' => 'Purchase Order Estimate Arrival Date',
			'receive_order_estimate_arrival_date' => 'Receive Order Estimate Arrival Date',
			'purchase_request_detail_id' => 'Purchase Request Detail',
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
		$criteria->compare('purchase_order_id',$this->purchase_order_id);
		$criteria->compare('purchase_order_detail_id',$this->purchase_order_detail_id);
		$criteria->compare('receive_order_id',$this->receive_order_id);
		$criteria->compare('quantity_good',$this->quantity_good);
		$criteria->compare('quantity_reject',$this->quantity_reject);
		$criteria->compare('quantity_more',$this->quantity_more);
		$criteria->compare('purchase_order_estimate_arrival_date',$this->purchase_order_estimate_arrival_date,true);
		$criteria->compare('receive_order_estimate_arrival_date',$this->receive_order_estimate_arrival_date,true);
		$criteria->compare('purchase_request_detail_id',$this->purchase_request_detail_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}