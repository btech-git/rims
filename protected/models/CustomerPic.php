<?php

/**
 * This is the model class for table "rims_customer_pic".
 *
 * The followings are the available columns in table 'rims_customer_pic':
 * @property integer $id
 * @property integer $customer_id
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $fax
 * @property string $email
 * @property string $note
 * @property string $status
 * @property string $birthdate
 *
 * The followings are the available model relations:
 * @property Province $province
 * @property City $city
 * @property CustomerPicMobile[] $customerPicMobiles
 * @property CustomerPicPhone[] $customerPicPhones
 */
class CustomerPic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CustomerPic the static model class
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
		return 'rims_customer_pic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id, province_id, city_id', 'numerical', 'integerOnly'=>true),
			array('name, email', 'length', 'max'=>100),
			array('zipcode, status', 'length', 'max'=>10),
			array('fax', 'length', 'max'=>20),
			array('address, note, birthdate', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer_id, name, address, province_id, city_id, zipcode, fax, email, note, status, birthdate', 'safe', 'on'=>'search'),
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
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'customerPicMobiles' => array(self::HAS_MANY, 'CustomerPicMobile', 'customer_pic_id'),
			'customerPicPhones' => array(self::HAS_MANY, 'CustomerPicPhone', 'customer_pic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'name' => 'Name',
			'address' => 'Address',
			'province_id' => 'Province',
			'city_id' => 'City',
			'zipcode' => 'Zipcode',
			'fax' => 'Fax',
			'email' => 'Email',
			'note' => 'Note',
			'status' => 'Status',
			'birthdate' => 'Birthdate',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);
		$criteria->compare('birthdate',$this->birthdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}