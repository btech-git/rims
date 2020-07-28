<?php

/**
 * This is the model class for table "{{registration_insurance_images}}".
 *
 * The followings are the available columns in table '{{registration_insurance_images}}':
 * @property integer $id
 * @property integer $registration_insurance_data_id
 * @property string $extension
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property RegistrationInsuranceData $registrationInsuranceData
 */
class RegistrationInsuranceImages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationInsuranceImages the static model class
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
		return '{{registration_insurance_images}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_insurance_data_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('extension', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_insurance_data_id, extension, is_inactive', 'safe', 'on'=>'search'),
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
			'registrationInsuranceData' => array(self::BELONGS_TO, 'RegistrationInsuranceData', 'registration_insurance_data_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'registration_insurance_data_id' => 'Registration Insurance Data',
			'extension' => 'Extension',
			'is_inactive' => 'Is Inactive',
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
		$criteria->compare('registration_insurance_data_id',$this->registration_insurance_data_id);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('is_inactive',$this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getFilename() {
    	return $this->registration_insurance_data_id . '-' . $this->id . '-insurance.' . $this->extension;
   	}

   	public function getThumbname() {
    	return $this->registration_insurance_data_id . '-' . $this->id . '-insurance-thumb.' . $this->extension;
   	}

   	public function getSquarename() {
    	return $this->registration_insurance_data_id . '-' . $this->id . '-insurance-square.' . $this->extension;
   	}	

}