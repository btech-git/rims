<?php

/**
 * This is the model class for table "{{customer_copy}}".
 *
 * The followings are the available columns in table '{{customer_copy}}':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $mobile_phone
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $note
 * @property string $customer_type
 * @property integer $default_payment_type
 * @property integer $tenor
 * @property string $status
 * @property string $birthdate
 * @property string $flat_rate
 * @property integer $coa_id
 * @property string $date_approval
 * @property integer $is_approved
 */
class CustomerCopy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer_copy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, address, province_id, city_id, customer_type', 'required'),
			array('id, province_id, city_id, default_payment_type, tenor, coa_id, is_approved', 'numerical', 'integerOnly'=>true),
			array('name, mobile_phone, phone, email', 'length', 'max'=>100),
			array('zipcode, customer_type, status, flat_rate', 'length', 'max'=>10),
			array('fax', 'length', 'max'=>20),
			array('note, birthdate, date_approval', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, province_id, city_id, zipcode, mobile_phone, phone, fax, email, note, customer_type, default_payment_type, tenor, status, birthdate, flat_rate, coa_id, date_approval, is_approved', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'address' => 'Address',
			'province_id' => 'Province',
			'city_id' => 'City',
			'zipcode' => 'Zipcode',
			'mobile_phone' => 'Mobile Phone',
			'phone' => 'Phone',
			'fax' => 'Fax',
			'email' => 'Email',
			'note' => 'Note',
			'customer_type' => 'Customer Type',
			'default_payment_type' => 'Default Payment Type',
			'tenor' => 'Tenor',
			'status' => 'Status',
			'birthdate' => 'Birthdate',
			'flat_rate' => 'Flat Rate',
			'coa_id' => 'Coa',
			'date_approval' => 'Date Approval',
			'is_approved' => 'Is Approved',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('customer_type',$this->customer_type,true);
		$criteria->compare('default_payment_type',$this->default_payment_type);
		$criteria->compare('tenor',$this->tenor);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('flat_rate',$this->flat_rate,true);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('date_approval',$this->date_approval,true);
		$criteria->compare('is_approved',$this->is_approved);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerCopy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
