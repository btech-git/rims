<?php

/**
 * This is the model class for table "rims_employee_bank".
 *
 * The followings are the available columns in table 'rims_employee_bank':
 * @property integer $id
 * @property integer $bank_id
 * @property integer $employee_id
 * @property string $account_no
 * @property string $account_name
 * @property integer $status
 */
class EmployeeBank extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmployeeBank the static model class
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
		return 'rims_employee_bank';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('bank_id, employee_id, account_no, account_name, status', 'required'),
			array('bank_id, employee_id', 'numerical', 'integerOnly'=>true),
			array('account_no', 'length', 'max'=>20),
			array('account_name', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, bank_id, employee_id, account_no, account_name, status', 'safe', 'on'=>'search'),
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
			'bank' => array(self::BELONGS_TO, 'Bank', 'bank_id'),
			'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'bank_id' => 'Bank',
			'employee_id' => 'Employee',
			'account_no' => 'Account No',
			'account_name' => 'Account Name',
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
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('employee_id',$this->employee_id);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}