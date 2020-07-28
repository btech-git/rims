<?php

/**
 * This is the model class for table "{{transaction_sales_order_detail_approval}}".
 *
 * The followings are the available columns in table '{{transaction_sales_order_detail_approval}}':
 * @property integer $id
 * @property integer $sales_order_detail_id
 * @property integer $revision
 * @property string $approval_type
 * @property string $date
 * @property integer $supervisor_id
 * @property string $note
 *
 * The followings are the available model relations:
 * @property TransactionSalesOrderDetail $salesOrderDetail
 */
class TransactionSalesOrderDetailApproval extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TransactionSalesOrderDetailApproval the static model class
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
		return '{{transaction_sales_order_detail_approval}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sales_order_detail_id', 'required'),
			array('sales_order_detail_id, revision, supervisor_id', 'numerical', 'integerOnly'=>true),
			array('approval_type', 'length', 'max'=>30),
			array('date, note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sales_order_detail_id, revision, approval_type, date, supervisor_id, note', 'safe', 'on'=>'search'),
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
			'salesOrderDetail' => array(self::BELONGS_TO, 'TransactionSalesOrderDetail', 'sales_order_detail_id'),
			'supervisor' => array(self::BELONGS_TO, 'Users', 'supervisor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sales_order_detail_id' => 'Sales Order Detail',
			'revision' => 'Revision',
			'approval_type' => 'Approval Type',
			'date' => 'Date',
			'supervisor_id' => 'Supervisor',
			'note' => 'Note',
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
		$criteria->compare('sales_order_detail_id',$this->sales_order_detail_id);
		$criteria->compare('revision',$this->revision);
		$criteria->compare('approval_type',$this->approval_type,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('supervisor_id',$this->supervisor_id);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}