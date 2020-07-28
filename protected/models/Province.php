<?php

/**
 * This is the model class for table "rims_province".
 *
 * The followings are the available columns in table 'rims_province':
 * @property integer $id
 * @property string $name
 * @property string $code
 *
 * The followings are the available model relations:
 * @property Branch[] $branches
 * @property City[] $cities
 * @property Customer[] $customers
 * @property CustomerPic[] $customerPics
 * @property Employee[] $employees
 * @property Employee[] $employees1
 * @property Supplier[] $suppliers
 * @property SupplierPic[] $supplierPics
 */
class Province extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Province the static model class
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
		return 'rims_province';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>100),
			array('code', 'length', 'max'=>5),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, code', 'safe', 'on'=>'search'),
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
			'branches' => array(self::HAS_MANY, 'Branch', 'province_id'),
			'cities' => array(self::HAS_MANY, 'City', 'province_id'),
			'customers' => array(self::HAS_MANY, 'Customer', 'province_id'),
			'customerPics' => array(self::HAS_MANY, 'CustomerPic', 'province_id'),
			'employees' => array(self::HAS_MANY, 'Employee', 'province_id'),
			'employees1' => array(self::HAS_MANY, 'Employee', 'home_province'),
			'suppliers' => array(self::HAS_MANY, 'Supplier', 'province_id'),
			'supplierPics' => array(self::HAS_MANY, 'SupplierPic', 'province_id'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}