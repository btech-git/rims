<?php

/**
 * This is the model class for table "{{insurance_company_pricelist}}".
 *
 * The followings are the available columns in table '{{insurance_company_pricelist}}':
 * @property integer $id
 * @property integer $insurance_company_id
 * @property integer $service_id
 * @property string $damage_type
 * @property string $vehicle_type
 * @property string $price
 *
 * The followings are the available model relations:
 * @property InsuranceCompany $insuranceCompany
 * @property Service $service
 */
class InsuranceCompanyPricelist extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InsuranceCompanyPricelist the static model class
	 */
	public $service_name;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{insurance_company_pricelist}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('insurance_company_id, service_id, damage_type, vehicle_type, price', 'required'),
			array('insurance_company_id, service_id', 'numerical', 'integerOnly'=>true),
			array('damage_type, vehicle_type', 'length', 'max'=>30),
			array('price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, insurance_company_id, service_id, damage_type, vehicle_type, price', 'safe', 'on'=>'search'),
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
			'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'insurance_company_id' => 'Insurance Company',
			'service_id' => 'Service',
			'damage_type' => 'Damage Type',
			'vehicle_type' => 'Vehicle Type',
			'price' => 'Price',
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
		$criteria->compare('insurance_company_id',$this->insurance_company_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('damage_type',$this->damage_type,true);
		$criteria->compare('vehicle_type',$this->vehicle_type,true);
		$criteria->compare('price',$this->price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}