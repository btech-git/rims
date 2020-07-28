<?php

/**
 * This is the model class for table "{{registration_payment}}".
 *
 * The followings are the available columns in table '{{registration_payment}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property integer $customer_id
 * @property string $payment_type
 * @property string $payment_status
 * @property string $payment_amount
 * @property string $payment_due_date
 * @property string $payment_date
 * @property string $down_payment_amount
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property Customer $customer
 */
class RegistrationPayment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationPayment the static model class
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
		return '{{registration_payment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_transaction_id, customer_id', 'numerical', 'integerOnly'=>true),
			array('payment_type, payment_status', 'length', 'max'=>30),
			array('payment_amount, down_payment_amount', 'length', 'max'=>18),
			array('payment_due_date, payment_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_transaction_id, customer_id, payment_type, payment_status, payment_amount, payment_due_date, payment_date, down_payment_amount', 'safe', 'on'=>'search'),
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
			'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
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
			'customer_id' => 'Customer',
			'payment_type' => 'Payment Type',
			'payment_status' => 'Payment Status',
			'payment_amount' => 'Payment Amount',
			'payment_due_date' => 'Payment Due Date',
			'payment_date' => 'Payment Date',
			'down_payment_amount' => 'Down Payment Amount',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('payment_status',$this->payment_status,true);
		$criteria->compare('payment_amount',$this->payment_amount,true);
		$criteria->compare('payment_due_date',$this->payment_due_date,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('down_payment_amount',$this->down_payment_amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}