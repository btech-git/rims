<?php

/**
 * This is the model class for table "{{registration_insurance_data}}".
 *
 * The followings are the available columns in table '{{registration_insurance_data}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property integer $insurance_company_id
 * @property string $insured_name
 * @property string $insurance_policy_number
 * @property string $insurance_policy_period_start
 * @property string $insurance_policy_period_end
 * @property string $spk_insurance
 * @property string $deductible_own_risk
 * @property string $insured_occupation
 * @property string $insured_telephone
 * @property string $insured_handphone
 * @property string $insured_email
 * @property string $insured_address
 * @property integer $insured_province_id
 * @property integer $insured_city_id
 * @property string $insured_zipcode
 * @property string $driver_name
 * @property string $driver_id_number
 * @property string $driver_license_number
 * @property string $relation_with_insured
 * @property string $driver_occupation
 * @property string $driver_telephone
 * @property string $driver_handphone
 * @property string $driver_email
 * @property string $driver_address
 * @property integer $driver_province_id
 * @property integer $driver_city_id
 * @property string $driver_zipcode
 * @property string $other_passenger_name
 * @property string $accident_place
 * @property string $accident_date_time
 * @property string $speed
 * @property string $damage_description
 * @property string $witness
 * @property string $injury
 * @property integer $is_reported
 * @property string $accident_description
 * @property string $insurance_surveyor_request
 * @property string $customer_request
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property InsuranceCompany $insuranceCompany
 * @property Province $insuredProvince
 * @property City $insuredCity
 * @property Province $driverProvince
 * @property City $driverCity
 * @property RegistrationInsuranceImages[] $registrationInsuranceImages
 */
class RegistrationInsuranceData extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationInsuranceData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	const STATUS_ACTIVE = 0;
	const STATUS_INACTIVE = 1;
	
	public $featured_image;
	public $images;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{registration_insurance_data}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_transaction_id, insurance_company_id, insured_name, insurance_policy_number, insured_handphone, insured_email, insured_address, insured_province_id, insured_city_id', 'required'),
			array('registration_transaction_id, insurance_company_id, insured_province_id, insured_city_id, driver_province_id, driver_city_id, is_reported', 'numerical', 'integerOnly'=>true),
			array('registration_transaction_id, insurance_company_id, insured_province_id, insured_city_id, driver_province_id, driver_city_id, is_reported', 'numerical', 'integerOnly'=>true),
			array('insured_name, driver_name, other_passenger_name, injury', 'length', 'max'=>100),
			array('insurance_policy_number, insured_email, driver_email, speed, witness', 'length', 'max'=>50),
			array('spk_insurance', 'length', 'max'=>5),
			array('deductible_own_risk', 'length', 'max'=>18),
			array('insured_occupation, driver_id_number, driver_license_number, relation_with_insured, driver_occupation', 'length', 'max'=>30),
			array('insured_telephone, insured_handphone, driver_telephone, driver_handphone', 'length', 'max'=>20),
			array('insured_zipcode, driver_zipcode', 'length', 'max'=>10),
			//array('insurance_policy_period_start, insurance_policy_period_end, insured_address, driver_address, accident_place, accident_date_time, damage_description, accident_description, insurance_surveyor_request, customer_request', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_transaction_id, insurance_company_id, insured_name, insurance_policy_number, insurance_policy_period_start, insurance_policy_period_end, spk_insurance, deductible_own_risk, insured_occupation, insured_telephone, insured_handphone, insured_email, insured_address, insured_province_id, insured_city_id, insured_zipcode, driver_name, driver_id_number, driver_license_number, relation_with_insured, driver_occupation, driver_telephone, driver_handphone, driver_email, driver_address, driver_province_id, driver_city_id, driver_zipcode, other_passenger_name, accident_place, accident_date_time, speed, damage_description, witness, injury, is_reported, accident_description, insurance_surveyor_request, customer_request', 'safe', 'on'=>'search'),
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
			'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
			'insuredProvince' => array(self::BELONGS_TO, 'Province', 'insured_province_id'),
			'insuredCity' => array(self::BELONGS_TO, 'City', 'insured_city_id'),
			'driverProvince' => array(self::BELONGS_TO, 'Province', 'driver_province_id'),
			'driverCity' => array(self::BELONGS_TO, 'City', 'driver_city_id'),
			'registrationInsuranceImages' => array(self::HAS_MANY, 'RegistrationInsuranceImages', 'registration_insurance_data_id'),
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
			'insurance_company_id' => 'Insurance Company',
			'insured_name' => 'Insured Name',
			'insurance_policy_number' => 'Insurance Policy Number',
			'insurance_policy_period_start' => 'Policy Period Start',
			'insurance_policy_period_end' => 'Policy Period End',
			'spk_insurance' => 'Spk Insurance',
			'deductible_own_risk' => 'Deductible Own Risk',
			'insured_occupation' => 'Insured Occupation',
			'insured_telephone' => 'Insured Telephone',
			'insured_handphone' => 'Insured Handphone',
			'insured_email' => 'Insured Email',
			'insured_address' => 'Insured Address',
			'insured_province_id' => 'Insured Province',
			'insured_city_id' => 'Insured City',
			'insured_zipcode' => 'Insured Zip Code',
			'driver_name' => 'Driver Name',
			'driver_id_number' => 'Driver Id Number',
			'driver_license_number' => 'Driver License Number',
			'relation_with_insured' => 'Relation With Insured',
			'driver_occupation' => 'Driver Occupation',
			'driver_telephone' => 'Driver Telephone',
			'driver_handphone' => 'Driver Handphone',
			'driver_email' => 'Driver Email',
			'driver_address' => 'Driver Address',
			'driver_province_id' => 'Driver Province',
			'driver_city_id' => 'Driver City',
			'driver_zipcode' => 'Driver Zipcode',
			'other_passenger_name' => 'Other Passenger Name',
			'accident_place' => 'Accident Place',
			'accident_date_time' => 'Accident Date Time',
			'speed' => 'Speed',
			'damage_description' => 'Damage Description',
			'witness' => 'Witness',
			'injury' => 'Injury',
			'is_reported' => 'Is Reported',
			'accident_description' => 'Accident Description',
			'insurance_surveyor_request' => 'Insurance Surveyor Request',
			'customer_request' => 'Customer Request',
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
		$criteria->compare('insurance_company_id',$this->insurance_company_id);
		$criteria->compare('insured_name',$this->insured_name,true);
		$criteria->compare('insurance_policy_number',$this->insurance_policy_number,true);
		$criteria->compare('insurance_policy_period_start',$this->insurance_policy_period_start,true);
		$criteria->compare('insurance_policy_period_end',$this->insurance_policy_period_end,true);
		$criteria->compare('spk_insurance',$this->spk_insurance,true);
		$criteria->compare('deductible_own_risk',$this->deductible_own_risk,true);
		$criteria->compare('insured_occupation',$this->insured_occupation,true);
		$criteria->compare('insured_telephone',$this->insured_telephone,true);
		$criteria->compare('insured_handphone',$this->insured_handphone,true);
		$criteria->compare('insured_email',$this->insured_email,true);
		$criteria->compare('insured_address',$this->insured_address,true);
		$criteria->compare('insured_province_id',$this->insured_province_id);
		$criteria->compare('insured_city_id',$this->insured_city_id);
		$criteria->compare('insured_zipcode',$this->insured_zipcode,true);
		$criteria->compare('driver_name',$this->driver_name,true);
		$criteria->compare('driver_id_number',$this->driver_id_number,true);
		$criteria->compare('driver_license_number',$this->driver_license_number,true);
		$criteria->compare('relation_with_insured',$this->relation_with_insured,true);
		$criteria->compare('driver_occupation',$this->driver_occupation,true);
		$criteria->compare('driver_telephone',$this->driver_telephone,true);
		$criteria->compare('driver_handphone',$this->driver_handphone,true);
		$criteria->compare('driver_email',$this->driver_email,true);
		$criteria->compare('driver_address',$this->driver_address,true);
		$criteria->compare('driver_province_id',$this->driver_province_id);
		$criteria->compare('driver_city_id',$this->driver_city_id);
		$criteria->compare('driver_zipcode',$this->driver_zipcode,true);
		$criteria->compare('other_passenger_name',$this->other_passenger_name,true);
		$criteria->compare('accident_place',$this->accident_place,true);
		$criteria->compare('accident_date_time',$this->accident_date_time,true);
		$criteria->compare('speed',$this->speed,true);
		$criteria->compare('damage_description',$this->damage_description,true);
		$criteria->compare('witness',$this->witness,true);
		$criteria->compare('injury',$this->injury,true);
		$criteria->compare('is_reported',$this->is_reported);
		$criteria->compare('accident_description',$this->accident_description,true);
		$criteria->compare('insurance_surveyor_request',$this->insurance_surveyor_request,true);
		$criteria->compare('customer_request',$this->customer_request,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getFeaturedname() {
    	return $this->id . '-post-featured.' . $this->spk_insurance;
   	}
}