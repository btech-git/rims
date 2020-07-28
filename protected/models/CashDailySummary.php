<?php

/**
 * This is the model class for table "{{cash_daily_summary}}".
 *
 * The followings are the available columns in table '{{cash_daily_summary}}':
 * @property integer $id
 * @property string $transaction_datetime
 * @property string $amount
 * @property string $filename
 * @property string $memo
 * @property integer $coa_id
 * @property integer $branch_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Coa $coa
 * @property Branch $branch
 */
class CashDailySummary extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CashDailySummary the static model class
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
		return '{{cash_daily_summary}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_datetime, coa_id, branch_id, user_id', 'required'),
			array('coa_id, branch_id, user_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>18),
			array('filename', 'length', 'max'=>60),
			array('memo', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, transaction_datetime, amount, filename, memo, coa_id, branch_id, user_id', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_datetime' => 'Transaction Datetime',
			'amount' => 'Amount',
			'filename' => 'Filename',
			'memo' => 'Memo',
			'coa_id' => 'Coa',
			'branch_id' => 'Branch',
			'user_id' => 'User',
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
		$criteria->compare('transaction_datetime',$this->transaction_datetime,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}