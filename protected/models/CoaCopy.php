<?php

/**
 * This is the model class for table "{{coa_copy}}".
 *
 * The followings are the available columns in table '{{coa_copy}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $coa_category_id
 * @property integer $coa_sub_category_id
 * @property integer $coa_id
 * @property string $normal_balance
 * @property string $cash_transaction
 * @property string $opening_balance
 * @property string $closing_balance
 * @property string $debit
 * @property string $credit
 * @property string $status
 * @property string $date
 * @property string $date_approval
 * @property integer $is_approved
 */
class CoaCopy extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coa_copy}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name, code, normal_balance', 'required'),
			array('id, coa_category_id, coa_sub_category_id, coa_id, is_approved', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('code', 'length', 'max'=>15),
			array('normal_balance', 'length', 'max'=>10),
			array('cash_transaction', 'length', 'max'=>5),
			array('opening_balance, closing_balance, debit, credit', 'length', 'max'=>18),
			array('status', 'length', 'max'=>20),
			array('date, date_approval', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, code, coa_category_id, coa_sub_category_id, coa_id, normal_balance, cash_transaction, opening_balance, closing_balance, debit, credit, status, date, date_approval, is_approved', 'safe', 'on'=>'search'),
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
			'code' => 'Code',
			'coa_category_id' => 'Coa Category',
			'coa_sub_category_id' => 'Coa Sub Category',
			'coa_id' => 'Coa',
			'normal_balance' => 'Normal Balance',
			'cash_transaction' => 'Cash Transaction',
			'opening_balance' => 'Opening Balance',
			'closing_balance' => 'Closing Balance',
			'debit' => 'Debit',
			'credit' => 'Credit',
			'status' => 'Status',
			'date' => 'Date',
			'date_approval' => 'Date Approval',
			'is_approved' => 'Is Approved',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('coa_category_id',$this->coa_category_id);
		$criteria->compare('coa_sub_category_id',$this->coa_sub_category_id);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('normal_balance',$this->normal_balance,true);
		$criteria->compare('cash_transaction',$this->cash_transaction,true);
		$criteria->compare('opening_balance',$this->opening_balance,true);
		$criteria->compare('closing_balance',$this->closing_balance,true);
		$criteria->compare('debit',$this->debit,true);
		$criteria->compare('credit',$this->credit,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('date_approval',$this->date_approval,true);
		$criteria->compare('is_approved',$this->is_approved);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoaCopy the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
