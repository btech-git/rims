<?php

/**
 * This is the model class for table "{{supplier_copy}}".
 *
 * The followings are the available columns in table '{{supplier_copy}}':
 * @property integer $id
 * @property string $date
 * @property string $code
 * @property string $name
 * @property string $company
 * @property string $person_in_charge
 * @property string $phone
 * @property string $mobile_phone
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
 * @property integer $coa_outstanding_order
 * @property string $description
 * @property string $status
 * @property string $date_approval
 * @property integer $is_approved
 */
class SupplierCopy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{supplier_copy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, code, name, company, position, address, province_id, city_id, zipcode, email_personal, email_company, npwp, tenor', 'required'),
			array('id, province_id, city_id, tenor, coa_id, coa_outstanding_order, is_approved', 'numerical', 'integerOnly'=>true),
			array('code, npwp', 'length', 'max'=>20),
			array('name, company, position', 'length', 'max'=>30),
			array('person_in_charge, mobile_phone', 'length', 'max'=>100),
			array('phone, email_personal, email_company', 'length', 'max'=>60),
			array('zipcode, company_attribute', 'length', 'max'=>10),
			array('status', 'length', 'max'=>45),
			array('date, description, date_approval', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, date, code, name, company, person_in_charge, phone, mobile_phone, position, address, province_id, city_id, zipcode, email_personal, email_company, npwp, tenor, company_attribute, coa_id, coa_outstanding_order, description, status, date_approval, is_approved', 'safe', 'on'=>'search'),
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
			'date' => 'Date',
			'code' => 'Code',
			'name' => 'Name',
			'company' => 'Company',
			'person_in_charge' => 'Person In Charge',
			'phone' => 'Phone',
			'mobile_phone' => 'Mobile Phone',
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
			'description' => 'Description',
			'status' => 'Status',
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
		$criteria->compare('date',$this->date,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('person_in_charge',$this->person_in_charge,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);
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
	 * @return SupplierCopy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
