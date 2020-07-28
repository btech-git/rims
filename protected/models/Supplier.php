<?php

/**
 * This is the model class for table "{{supplier}}".
 *
 * The followings are the available columns in table '{{supplier}}':
 * @property integer $id
 * @property string $date
 * @property string $code
 * @property string $name
 * @property string $company
 * @property string $position
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $email_personal
 * @property string $email_company
 * @property string $npwp
 * @property integer $tenor
 * @property string $company_attribute
 * @property integer $coa_id
 * @property integer $description
 * @property integer $status
 * @property string $person_in_charge
 * @property string $phone
 * @property string $mobile_phone
 *
 * The followings are the available model relations:
 * @property ConsignmentInHeader[] $consignmentInHeaders
 * @property PaymentOut[] $paymentOuts
 * @property ProductPrice[] $productPrices
 * @property Province $province
 * @property City $city
 * @property SupplierBank[] $supplierBanks
 * @property SupplierMobile[] $supplierMobiles
 * @property SupplierPhone[] $supplierPhones
 * @property SupplierPic[] $supplierPics
 * @property SupplierProduct[] $supplierProducts
 * @property Coa $coa
 * @property Coa $coaOutstandingOrder
 * @property TransactionPurchaseOrder[] $transactionPurchaseOrders
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionRequestOrderDetail[] $transactionRequestOrderDetails
 * @property TransactionReturnOrder[] $transactionReturnOrders
 */
class Supplier extends CActiveRecord
{
	public $product_master_category_id;
	public $product_sub_master_category_id;
	public $product_sub_category_id;
	public $production_year;
	public $brand_id;
	public $purchase;
	public $product_name;
	public $coa_name;
	public $coa_code;
	public $coa_outstanding_code;
	public $coa_outstanding_name;
	// public $pid;
	// public $suppid;

	/**
	 * @return string the associated database table name
	 */
	
	public function tableName()
	{
		return '{{supplier}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, company, address, province_id, city_id, zipcode, email_personal, email_company, npwp, tenor', 'required'),
			array('province_id, city_id, tenor, coa_id, coa_outstanding_order', 'numerical', 'integerOnly'=>true),
			array('code, npwp', 'length', 'max'=>20),
			array('name, company, position', 'length', 'max'=>30),
			array('status', 'length', 'max'=>45),
			array('zipcode, company_attribute', 'length', 'max'=>10),
			array('email_personal, email_company, phone', 'length', 'max'=>60),
			array('person_in_charge, mobile_phone', 'length', 'max'=>100),
			array('date, note', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, code, name, company, position, address, province_id, city_id, zipcode, email_personal, email_company, npwp, tenor, company_attribute,product_name, coa_id, coa_name, coa_code, coa_outstanding_code, coa_outstanding_name, note, status, phone, person_in_charge, mobile_phone', 'safe', 'on'=>'search'),
		);
	}

	public function beforeSave()
	{
	
	    if ($this->isNewRecord)
	    {
	    	$this->date = new CDbExpression('NOW()');
	    }
	    return parent::beforeSave();
 	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'consignmentInHeaders' => array(self::HAS_MANY, 'ConsignmentInHeader', 'supplier_id'),
			'paymentOuts' => array(self::HAS_MANY, 'PaymentOut', 'supplier_id'),
			'productPrices' => array(self::HAS_MANY, 'ProductPrice', 'supplier_id'),
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'supplierBanks' => array(self::HAS_MANY, 'SupplierBank', 'supplier_id'),
			'supplierMobiles' => array(self::HAS_MANY, 'SupplierMobile', 'supplier_id'),
			'supplierPhones' => array(self::HAS_MANY, 'SupplierPhone', 'supplier_id'),
			'supplierPics' => array(self::HAS_MANY, 'SupplierPic', 'supplier_id'),
			'supplierProducts' => array(self::HAS_MANY, 'SupplierProduct', 'supplier_id'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
			'coaOutstandingOrder' => array(self::BELONGS_TO, 'Coa', 'coa_outstanding_order'),
			'transactionPurchaseOrders' => array(self::HAS_MANY, 'TransactionPurchaseOrder', 'supplier_id'),
			'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'supplier_id'),
			'transactionRequestOrderDetails' => array(self::HAS_MANY, 'TransactionRequestOrderDetail', 'supplier_id'),
			'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'supplier_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date' => 'Date',
			'code' => 'Code',
			'name' => 'Name',
			'company' => 'Company',
			'position' => 'Position',
			'address' => 'Address',
			'province_id' => 'Province',
			'city_id' => 'City',
			'zipcode' => 'Zipcode',
			'email_personal' => 'Email Personal',
			'email_company' => 'Email Company',
			'npwp' => 'Npwp',
			'tenor' => 'Tenor',
			'company_attribute' => 'Company Attribute',
			'coa_id' => 'Coa',
			'coa_outstanding_order' => 'Coa Outstanding Order',
            'person_in_charge' => 'PIC',
            'phone' => 'Phone',
            'mobile_phone' => 'Mobile Phone',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('email_personal',$this->email_personal,true);
		$criteria->compare('email_company',$this->email_company,true);
		$criteria->compare('npwp',$this->npwp,true);
		$criteria->compare('tenor',$this->tenor);
		$criteria->compare('company_attribute',$this->company_attribute,true);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('coa_outstanding_order',$this->coa_outstanding_order);
		$criteria->compare('description',$this->description);
		$criteria->compare('person_in_charge',$this->person_in_charge);
		$criteria->compare('phone',$this->phone);
		$criteria->compare('mobile_phone',$this->mobile_phone);

		$criteria->together = true;
		$criteria->with = array('coa','coaOutstandingOrder');
		$criteria->compare('coa.name',$this->coa_name, true);
		$criteria->compare('coa.code',$this->coa_code, true);
		$criteria->compare('coaOutstandingOrder.name',$this->coa_outstanding_name, true);
		$criteria->compare('coaOutstandingOrder.code',$this->coa_outstanding_code, true);

		// $criteria->together = true;
		// $criteria->with = array('productMasterCategory','productSubMasterCategory','productSubCategory','brand');
		// // $criteria->compare('t.name',$product->name,true);
		// $criteria->compare('productMasterCategory.name',$this->product_master_category_name,true);
		// $criteria->compare('productSubMasterCategory.name',$this->product_sub_master_category_name,true);
		// $criteria->compare('productSubCategory.name',$this->product_sub_category_name,true);
		// $criteria->compare('production_year',$this->production_year,true);
		// $criteria->compare('brand.name',$this->product_brand_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Supplier the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
