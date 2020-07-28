<?php

/**
 * This is the model class for table "{{cash_transaction_images}}".
 *
 * The followings are the available columns in table '{{cash_transaction_images}}':
 * @property integer $id
 * @property integer $cash_transaction_id
 * @property string $extension
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property CashTransaction $cashTransaction
 */
class CashTransactionImages extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cash_transaction_images}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cash_transaction_id, extension', 'required'),
			array('cash_transaction_id, is_inactive', 'numerical', 'integerOnly'=>true),
			array('extension', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cash_transaction_id, extension, is_inactive', 'safe', 'on'=>'search'),
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
			'cashTransaction' => array(self::BELONGS_TO, 'CashTransaction', 'cash_transaction_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cash_transaction_id' => 'Cash Transaction',
			'extension' => 'Extension',
			'is_inactive' => 'Is Inactive',
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
		$criteria->compare('cash_transaction_id',$this->cash_transaction_id);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('is_inactive',$this->is_inactive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CashTransactionImages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function getFilename() {
    	return $this->cash_transaction_id . '-' . $this->cash_transaction_id . '-cash-transaction.' . $this->extension;
   	}

   	public function getThumbname() {
    	return $this->cash_transaction_id . '-' . $this->cash_transaction_id . '-cash-transaction-thumb.' . $this->extension;
   	}

   	public function getSquarename() {
    	return $this->cash_transaction_id . '-' . $this->cash_transaction_id . '-cash-transaction-square.' . $this->extension;
   	}	
}
