<?php

/**
 * This is the model class for table "{{registration_quick_service}}".
 *
 * The followings are the available columns in table '{{registration_quick_service}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property integer $quick_service_id
 * @property string $price
 * @property string $hour
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property QuickService $quickService
 */
class RegistrationQuickService extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationQuickService the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public $quick_service_code;
	public $employee_name;
	
	public function tableName()
	{
		return '{{registration_quick_service}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_transaction_id, quick_service_id', 'numerical', 'integerOnly'=>true),
			array('price', 'length', 'max'=>18),
			array('hour', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_transaction_id, quick_service_id, price, hour', 'safe', 'on'=>'search'),
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
			'quickService' => array(self::BELONGS_TO, 'QuickService', 'quick_service_id'),
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
			'quick_service_id' => 'Quick Service',
			'price' => 'Price',
			'hour' => 'Hour',
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
		$criteria->compare('quick_service_id',$this->quick_service_id);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('hour',$this->hour,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}