<?php

/**
 * This is the model class for table "{{asset_transaction}}".
 *
 * The followings are the available columns in table '{{asset_transaction}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $code
 * @property string $description
 * @property integer $is_zero_book_value
 * @property integer $asset_category_id
 * @property integer $is_taxable
 * @property string $memo
 * @property string $amount
 *
 * The followings are the available model relations:
 * @property AssetCategory $assetCategory
 */
class AssetTransaction extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{asset_transaction}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_number, transaction_date, code, asset_category_id', 'required'),
			array('is_zero_book_value, asset_category_id, is_taxable', 'numerical', 'integerOnly'=>true),
			array('transaction_number, code', 'length', 'max'=>20),
			array('description, memo', 'length', 'max'=>100),
			array('amount', 'length', 'max'=>18),
			array('transaction_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transaction_number, transaction_date, transaction_time, code, description, is_zero_book_value, asset_category_id, is_taxable, memo, amount', 'safe', 'on'=>'search'),
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
			'assetCategory' => array(self::BELONGS_TO, 'AssetCategory', 'asset_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_number' => 'Transaction Number',
			'transaction_date' => 'Transaction Date',
			'transaction_time' => 'Transaction Time',
			'code' => 'Code',
			'description' => 'Description',
			'is_zero_book_value' => 'Is Zero Book Value',
			'asset_category_id' => 'Asset Category',
			'is_taxable' => 'Is Taxable',
			'memo' => 'Memo',
			'amount' => 'Amount',
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
		$criteria->compare('transaction_number',$this->transaction_number,true);
		$criteria->compare('transaction_date',$this->transaction_date,true);
		$criteria->compare('transaction_time',$this->transaction_time,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_zero_book_value',$this->is_zero_book_value);
		$criteria->compare('asset_category_id',$this->asset_category_id);
		$criteria->compare('is_taxable',$this->is_taxable);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('amount',$this->amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
