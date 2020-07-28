<?php

/**
 * This is the model class for table "{{equipment_details}}".
 *
 * The followings are the available columns in table '{{equipment_details}}':
 * @property integer $id
 * @property integer $equipment_id
 * @property string $equipment_code
 * @property string $brand
 * @property string $purchase_date
 * @property integer $age
 * @property integer $quantity
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Equipments $equipment
 * @property EquipmentMaintenances[] $equipmentMaintenances
 */
class EquipmentDetails extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipment_details}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('equipment_id, equipment_code, brand, purchase_date, age', 'required'),
			array('equipment_id, age', 'numerical', 'integerOnly'=>true),
			array('equipment_code, brand', 'length', 'max'=>100),
			array('status', 'length', 'max'=>8),
			array('purchase_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, equipment_id, equipment_code, brand, purchase_date, age, quantity, status', 'safe', 'on'=>'search'),
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
			'equipment' => array(self::BELONGS_TO, 'Equipments', 'equipment_id'),
			'equipmentMaintenances' => array(self::HAS_MANY, 'EquipmentMaintenances', 'equipment_detail_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'equipment_id' => 'Equipment',
			'equipment_code' => 'Equipment Code',
			'brand' => 'Brand',
			'purchase_date' => 'Purchase Date',
			'age' => 'Age',
			'quantity' => 'Quantity',
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
		$criteria->compare('equipment_id',$this->equipment_id);
		$criteria->compare('equipment_code',$this->equipment_code,true);
		$criteria->compare('brand',$this->brand,true);
		$criteria->compare('purchase_date',$this->purchase_date,true);
		$criteria->compare('age',$this->age);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EquipmentDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
