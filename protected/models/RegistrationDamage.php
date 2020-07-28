<?php

/**
 * This is the model class for table "{{registration_damage}}".
 *
 * The followings are the available columns in table '{{registration_damage}}':
 * @property integer $id
 * @property integer $registration_transaction_id
 * @property string $panel
 * @property string $damage_type
 * @property string $description
 * @property integer $service_id
 * @property integer $product_id
 * @property integer $hour
 * @property integer $waiting_time
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property Service $service
 * @property Product $product
 */
class RegistrationDamage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationDamage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public $product_name;
	public $service_name;
	public $products;
	public function tableName()
	{
		return '{{registration_damage}}';
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
			array('registration_transaction_id, service_id, product_id, hour, waiting_time', 'numerical', 'integerOnly'=>true),
			array('panel, damage_type', 'length', 'max'=>50),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, registration_transaction_id, panel, damage_type, description, service_id, product_id, hour, waiting_time', 'safe', 'on'=>'search'),
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
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
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
			'panel' => 'Panel',
			'damage_type' => 'Damage Type',
			'description' => 'Description',
			'service_id' => 'Service',
			'product_id' => 'Product',
			'hour' => 'Hour',
			'waiting_time' => 'Waiting Time',
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
		$criteria->compare('panel',$this->panel,true);
		$criteria->compare('damage_type',$this->damage_type,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('hour',$this->hour);
		$criteria->compare('waiting_time',$this->waiting_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}