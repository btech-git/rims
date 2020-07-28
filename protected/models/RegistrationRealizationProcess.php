<?php

/**
 * This is the model class for table "{{registration_realization_process}}".
 *
 * The followings are the available columns in table '{{registration_realization_process}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property string $name
 * @property integer $checked
 * @property integer $checked_by
 * @property string $checked_date
 * @property string $detail
 * @property integer $service_id
 *
 * The followings are the available model relations:
 * @property RegistrationRealizationImages[] $registrationRealizationImages
 * @property RegistrationTransaction $registrationTransaction
 * @property Service $service
 */
class RegistrationRealizationProcess extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationRealizationProcess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */

	const STATUS_ACTIVE = 0;
	const STATUS_INACTIVE = 1;
	
	public $images;
	public function tableName()
	{
		return '{{registration_realization_process}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('registration_transaction_id', 'required'),
			array('registration_transaction_id, checked, checked_by, service_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('checked_date, detail', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_transaction_id, name, checked, checked_by, checked_date, detail, service_id', 'safe', 'on'=>'search'),
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
			'registrationRealizationImages' => array(self::HAS_MANY, 'RegistrationRealizationImages', 'registration_realisation_id'),
			'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
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
			'registration_transaction_id' => 'Registration Transaction',
			'name' => 'Name',
			'checked' => 'Checked',
			'checked_by' => 'Checked By',
			'checked_date' => 'Checked Date',
			'detail' => 'Detail',
			'service_id' => 'Service',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('checked',$this->checked);
		$criteria->compare('checked_by',$this->checked_by);
		$criteria->compare('checked_date',$this->checked_date,true);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('service_id',$this->service_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}