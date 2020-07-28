<?php

/**
 * This is the model class for table "{{warehouse_section}}".
 *
 * The followings are the available columns in table '{{warehouse_section}}':
 * @property integer $id
 * @property integer $warehouse_id
 * @property string $code
 * @property integer $product_id
 * @property string $rack_number
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Warehouse $warehouse
 * @property Product $product
 */
class WarehouseSection extends CActiveRecord
{
	public $product_name;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{warehouse_section}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('warehouse_id, code, product_id, rack_number, status', 'required'),
			array('warehouse_id, product_id', 'numerical', 'integerOnly'=>true),
			array('code, rack_number', 'length', 'max'=>20),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, warehouse_id, code, product_id, rack_number, status, product_name', 'safe', 'on'=>'search'),
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
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'warehouse_id' => 'Warehouse',
			'code' => 'Code',
			'product_id' => 'Product',
			'rack_number' => 'Rack Number',
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
		$criteria->compare('warehouse_id',$this->warehouse_id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('rack_number',$this->rack_number,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarehouseSection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
