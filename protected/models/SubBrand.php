<?php

/**
 * This is the model class for table "{{sub_brand}}".
 *
 * The followings are the available columns in table '{{sub_brand}}':
 * @property integer $id
 * @property integer $brand_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property ProductSpecificationBattery[] $productSpecificationBatteries
 * @property ProductSpecificationOil[] $productSpecificationOils
 * @property ProductSpecificationTire[] $productSpecificationTires
 * @property Brand $brand
 * @property SubBrandSeries[] $subBrandSeries
 */
class SubBrand extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{sub_brand}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('brand_id, name', 'required'),
			array('brand_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, brand_id, name', 'safe', 'on'=>'search'),
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
			'productSpecificationBatteries' => array(self::HAS_MANY, 'ProductSpecificationBattery', 'sub_brand_id'),
			'productSpecificationOils' => array(self::HAS_MANY, 'ProductSpecificationOil', 'sub_brand_id'),
			'productSpecificationTires' => array(self::HAS_MANY, 'ProductSpecificationTire', 'sub_brand_id'),
			'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
			'subBrandSeries' => array(self::HAS_MANY, 'SubBrandSeries', 'sub_brand_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'brand_id' => 'Brand',
			'name' => 'Name',
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
		$criteria->compare('t.brand_id',$this->brand_id);
		$criteria->compare('t.name',$this->name,true);
		
		$criteria->together = 'true';
		$criteria->with = array('brand');
		$criteria->compare('brand.name', $this->brand_id == NULL ? $this->brand_id : $this->brand_id.'%', true,'AND', false);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
                'defaultOrder'=>'t.name ASC',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SubBrand the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
