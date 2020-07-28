<?php

/**
 * This is the model class for table "rims_supplier_pic".
 *
 * The followings are the available columns in table 'rims_supplier_pic':
 * @property integer $id
 * @property integer $supplier_id
 * @property string $date
 * @property string $name
 * @property string $company
 * @property string $position
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $fax
 * @property string $email_personal
 * @property string $email_company
 * @property string $npwp
 * @property string $description
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Supplier $supplier
 * @property Province $province
 * @property City $city
 * @property SupplierPicMobile[] $supplierPicMobiles
 * @property SupplierPicPhone[] $supplierPicPhones
 */
class SupplierPic extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupplierPic the static model class
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
		return 'rims_supplier_pic';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id, province_id, city_id', 'numerical', 'integerOnly'=>true),
			array('name, company, position', 'length', 'max'=>30),
			array('zipcode, status', 'length', 'max'=>10),
			array('fax, npwp', 'length', 'max'=>20),
			array('email_personal, email_company, description', 'length', 'max'=>60),
			array('date, address', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, supplier_id, date, name, company, position, address, province_id, city_id, zipcode, fax, email_personal, email_company, npwp, description, status', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'supplierPicMobiles' => array(self::HAS_MANY, 'SupplierPicMobile', 'supplier_pic_id'),
			'supplierPicPhones' => array(self::HAS_MANY, 'SupplierPicPhone', 'supplier_pic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_id' => 'Supplier',
			'date' => 'Date',
			'name' => 'Name',
			'company' => 'Company',
			'position' => 'Position',
			'address' => 'Address',
			'province_id' => 'Province',
			'city_id' => 'City',
			'zipcode' => 'Zipcode',
			'fax' => 'Fax',
			'email_personal' => 'Email Personal',
			'email_company' => 'Email Company',
			'npwp' => 'Npwp',
			'description' => 'Description',
			'status' => 'Status',
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
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('zipcode',$this->zipcode,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('email_personal',$this->email_personal,true);
		$criteria->compare('email_company',$this->email_company,true);
		$criteria->compare('npwp',$this->npwp,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}