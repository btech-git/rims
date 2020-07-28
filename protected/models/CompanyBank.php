<?php

/**
 * This is the model class for table "{{company_bank}}".
 *
 * The followings are the available columns in table '{{company_bank}}':
 * @property integer $id
 * @property integer $company_id
 * @property integer $bank_id
 * @property integer $coa_id
 * @property string $account_no
 * @property string $account_name
 * @property string $swift_code
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Bank $bank
 * @property Coa $coa
 * @property TransactionPurchaseOrder[] $transactionPurchaseOrders
 * @property TransactionSalesOrder[] $transactionSalesOrders
 */
class CompanyBank extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $bank_name;
	public $coa_name;
	public function tableName()
	{
		return '{{company_bank}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id, bank_id, coa_id, account_no, account_name, swift_code, status', 'required'),
			array('company_id, bank_id, coa_id', 'numerical', 'integerOnly'=>true),
			array('account_no, status', 'length', 'max'=>20),
			array('account_name', 'length', 'max'=>100),
			array('swift_code', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, company_id, bank_id, coa_id, account_no, account_name, swift_code, status', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'bank' => array(self::BELONGS_TO, 'Bank', 'bank_id'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
			'transactionPurchaseOrders' => array(self::HAS_MANY, 'TransactionPurchaseOrder', 'company_bank_id'),
			'transactionSalesOrders' => array(self::HAS_MANY, 'TransactionSalesOrder', 'company_bank_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'bank_id' => 'Bank',
			'coa_id' => 'Coa',
			'account_no' => 'Account No',
			'account_name' => 'Account Name',
			'swift_code' => 'Swift Code',
			'status' => 'Status',
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
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('account_no',$this->account_no,true);
		$criteria->compare('account_name',$this->account_name,true);
		$criteria->compare('swift_code',$this->swift_code,true);
		$criteria->compare('LOWER(t.status)', strtolower($this->status),FALSE);	
		
		$criteria->together=true;
		$criteria->with = array('coa');
		$criteria->compare('coa.name',$this->coa_name, true);
		$criteria->compare('coa.code',$this->coa_code, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CompanyBank the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getAccountNameAndNumber() {
        return $this->account_no . ' - ' . $this->account_name;
    }
}
