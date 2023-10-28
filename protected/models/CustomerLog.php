<?php

/**
 * This is the model class for table "customer_log".
 *
 * The followings are the available columns in table 'customer_log':
 * @property integer $id
 * @property string $name
 * @property string $customer_type
 * @property integer $coa_id
 * @property integer $customer_id
 * @property string $date_updated
 * @property string $time_updated
 * @property integer $user_updated_id
 *
 * The followings are the available model relations:
 * @property Customer $customer
 * @property Coa $coa
 * @property Users $userUpdated
 */
class CustomerLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, customer_type, coa_id, customer_id, date_updated, time_updated, user_updated_id', 'required'),
			array('coa_id, customer_id, user_updated_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('customer_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, customer_type, coa_id, customer_id, date_updated, time_updated, user_updated_id', 'safe', 'on'=>'search'),
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
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
			'userUpdated' => array(self::BELONGS_TO, 'Users', 'user_updated_id'),
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
			'customer_type' => 'Customer Type',
			'coa_id' => 'Coa',
			'customer_id' => 'Customer',
			'date_updated' => 'Date Updated',
			'time_updated' => 'Time Updated',
			'user_updated_id' => 'User Updated',
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
		$criteria->compare('customer_type',$this->customer_type,true);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('time_updated',$this->time_updated,true);
		$criteria->compare('user_updated_id',$this->user_updated_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
