<?php

/**
 * This is the model class for table "{{product_sub_category}}".
 *
 * The followings are the available columns in table '{{product_sub_category}}':
 * @property integer $id
 * @property integer $product_master_category_id
 * @property integer $product_sub_master_category_id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property ProductSubMasterCategory $productSubMasterCategory
 * @property ProductMasterCategory $productMasterCategory
 */
class ProductSubCategory extends CActiveRecord
{
	public $product_master_category_code;
	public $product_master_category_name;
	public $product_sub_master_category_code;
	public $product_sub_master_category_name;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_sub_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_master_category_id, product_sub_master_category_id, code, name, status', 'required'),
			array('product_master_category_id, product_sub_master_category_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>20),
			array('name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>10),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_master_category_id, product_sub_master_category_id, code, name, description, status, product_master_category_code, product_master_category_name, product_sub_master_category_code, product_sub_master_category_name', 'safe', 'on'=>'search'),
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
			'products' => array(self::HAS_MANY, 'Product', 'product_sub_category_id'),
			'productSubMasterCategory' => array(self::BELONGS_TO, 'ProductSubMasterCategory', 'product_sub_master_category_id'),
			'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_master_category_id' => 'Product Master Category',
			'product_sub_master_category_id' => 'Product Sub Master Category',
			'code' => 'Code',
			'name' => 'Name',
			'description' => 'Description',
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
		$criteria->compare('t.product_master_category_id',$this->product_master_category_id);
		$criteria->compare('t.product_sub_master_category_id',$this->product_sub_master_category_id);
		$criteria->compare('t.code',$this->code,true);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('t.description',$this->description,true);
		$criteria->compare('t.status',$this->status,true);
		
		$criteria->together=true;
		$criteria->with = array('productSubMasterCategory','productMasterCategory');
		$criteria->compare('productMasterCategory.code',$this->product_master_category_code,true);
		$criteria->compare('productMasterCategory.name',$this->product_master_category_name,true);
		$criteria->compare('productSubMasterCategory.code',$this->product_sub_master_category_code,true);
		$criteria->compare('productSubMasterCategory.name',$this->product_sub_master_category_name,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
				'defaultOrder'=>'t.status ASC, t.code ASC',
				'attributes' => array(
					'product_master_category_code' => array(
						'asc' => 'productMasterCategory.code',
						'desc' => 'productMasterCategory.code DESC'
					),
					'product_master_category_name' => array(
						'asc' => 'productMasterCategory.name',
						'desc' => 'productMasterCategory.name DESC'
					),
					'product_sub_master_category_code' => array(
						'asc' => 'productSubMasterCategory.code',
						'desc' => 'productSubMasterCategory.code DESC'
					),
					'product_sub_master_category_name' => array(
						'asc' => 'productSubMasterCategory.name',
						'desc' => 'productSubMasterCategory.name DESC'
					),
					'*'
				)
			),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSubCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getNameAndCode() {
        return $this->name . ' - ' . $this->code;
    }
}
