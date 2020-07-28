<?php

/**
 * This is the model class for table "{{equipment_branch}}".
 *
 * The followings are the available columns in table '{{equipment_branch}}':
 * @property integer $id
 * @property integer $branch_id
 * @property integer $equipment_id
 * @property string $brand
 * @property integer $quantity
 * @property string $purchase_date
 * @property integer $age
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Branch $branch
 * @property Equipments $equipment
 * @property EquipmentMaintenance[] $equipmentMaintenances
 */
class EquipmentBranch extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment_branch}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('branch_id, brand, quantity, purchase_date, age', 'required'),
			array('branch_id, quantity, age', 'numerical', 'integerOnly'=>true),
			array('brand', 'length', 'max'=>100),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, branch_id, brand, quantity, purchase_date, age, status', 'safe', 'on'=>'search'),
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
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'equipmentMaintenances' => array(self::HAS_MANY, 'EquipmentMaintenance', 'equipment_branch_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'branch_id' => 'Branch',
			'brand' => 'Brand',
			'quantity' => 'Quantity',
			'purchase_date' => 'Purchase Date',
			'age' => 'Age',
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
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('purchase_date',$this->purchase_date,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EquipmentBranch the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
