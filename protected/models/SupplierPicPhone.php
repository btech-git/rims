<?php

/**
 * This is the model class for table "rims_supplier_pic_phone".
 *
 * The followings are the available columns in table 'rims_supplier_pic_phone':
 * @property integer $id
 * @property integer $supplier_pic_id
 * @property string $phone_no
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property SupplierPic $supplierPic
 */
class SupplierPicPhone extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SupplierPicPhone the static model class
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
		return 'rims_supplier_pic_phone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_pic_id, status', 'numerical', 'integerOnly'=>true),
			array('phone_no', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, supplier_pic_id, phone_no, status', 'safe', 'on'=>'search'),
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
			'supplierPic' => array(self::BELONGS_TO, 'SupplierPic', 'supplier_pic_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_pic_id' => 'Supplier Pic',
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
		$criteria->compare('supplier_pic_id',$this->supplier_pic_id);
		$criteria->compare('phone_no',$this->phone_no,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}