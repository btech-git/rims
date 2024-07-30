<?php

/**
 * This is the model class for table "{{warehouse_branch_product_category}}".
 *
 * The followings are the available columns in table '{{warehouse_branch_product_category}}':
 * @property integer $id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $product_master_category_id
 *
 * The followings are the available model relations:
 * @property Branch $branch
 * @property ProductMasterCategory $productMasterCategory
 * @property Warehouse $warehouse
 */
class WarehouseBranchProductCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{warehouse_branch_product_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('branch_id, product_master_category_id', 'required'),
			array('warehouse_id, branch_id, product_master_category_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, warehouse_id, branch_id, product_master_category_id', 'safe', 'on'=>'search'),
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
			'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
			'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
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
			'branch_id' => 'Branch',
			'product_master_category_id' => 'Product Master Category',
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
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('product_master_category_id',$this->product_master_category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WarehouseBranchProductCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
