<?php

/**
 * This is the model class for table "rims_customer_pic_phone".
 *
 * The followings are the available columns in table 'rims_customer_pic_phone':
 * @property integer $id
 * @property integer $customer_pic_id
 * @property string $phone_no
 * @property string $status
 *
 * The followings are the available model relations:
 * @property CustomerPic $customerPic
 */
class CustomerPicPhone extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CustomerPicPhone the static model class
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
		return 'rims_customer_pic_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_pic_id', 'numerical', 'integerOnly'=>true),
			array('phone_no', 'length', 'max'=>20),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, customer_pic_id, phone_no, status', 'safe', 'on'=>'search'),
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
			'customerPic' => array(self::BELONGS_TO, 'CustomerPic', 'customer_pic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_pic_id' => 'Customer Pic',
			'phone_no' => 'Phone No',
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
		$criteria->compare('customer_pic_id',$this->customer_pic_id);
		$criteria->compare('phone_no',$this->phone_no,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}