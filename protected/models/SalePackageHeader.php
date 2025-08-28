<?php

/**
 * This is the model class for table "{{sale_package_header}}".
 *
 * The followings are the available columns in table '{{sale_package_header}}':
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property string $start_date
 * @property string $end_date
 * @property integer $is_inactive
 * @property integer $user_id
 * @property string $datetime_created
 *
 * The followings are the available model relations:
 * @property InvoiceDetail[] $invoiceDetails
 * @property RegistrationPackage[] $registrationPackages
 * @property SalePackageDetail[] $salePackageDetails
 * @property Users $user
 */
class SalePackageHeader extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sale_package_header}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, start_date, end_date, user_id, datetime_created', 'required'),
			array('is_inactive, user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('price', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, price, start_date, end_date, is_inactive, user_id, datetime_created', 'safe', 'on'=>'search'),
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
			'invoiceDetails' => array(self::HAS_MANY, 'InvoiceDetail', 'sale_package_header_id'),
			'registrationPackages' => array(self::HAS_MANY, 'RegistrationPackage', 'sale_package_header_id'),
			'salePackageDetails' => array(self::HAS_MANY, 'SalePackageDetail', 'sale_package_header_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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
			'price' => 'Price',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'is_inactive' => 'Is Inactive',
			'user_id' => 'User',
			'datetime_created' => 'Datetime Created',
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
		$criteria->compare('price',$this->price,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('is_inactive',$this->is_inactive);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('datetime_created',$this->datetime_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalePackageHeader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
