<?php

/**
 * This is the model class for table "{{product_specification_tire}}".
 *
 * The followings are the available columns in table '{{product_specification_tire}}':
 * @property integer $id
 * @property integer $product_id
 * @property string $serial_number
 * @property string $type
 * @property integer $sub_brand_id
 * @property integer $sub_brand_series_id
 * @property string $attribute
 * @property integer $overall_diameter
 * @property integer $section_width_inches
 * @property integer $section_width_mm
 * @property integer $aspect_ratio
 * @property string $radial_type
 * @property integer $rim_diameter
 * @property integer $load_index
 * @property string $speed_symbol
 * @property integer $ply_rating
 * @property string $lettering
 * @property string $terrain
 * @property string $local_import
 * @property string $car_type
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property SubBrandSeries $subBrandSeries
 * @property SubBrand $subBrand
 */
class ProductSpecificationTire extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_specification_tire}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id', 'required'),
			array('product_id, sub_brand_id, sub_brand_series_id, overall_diameter, section_width_inches, section_width_mm, aspect_ratio, rim_diameter, load_index, ply_rating', 'numerical', 'integerOnly'=>true),
			array('serial_number, type, attribute', 'length', 'max'=>30),
			array('radial_type, speed_symbol, lettering, terrain', 'length', 'max'=>5),
			array('local_import, car_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, serial_number, type, sub_brand_id, sub_brand_series_id, attribute, overall_diameter, section_width_inches, section_width_mm, aspect_ratio, radial_type, rim_diameter, load_index, speed_symbol, ply_rating, lettering, terrain, local_import, car_type', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
			'subBrandSeries' => array(self::BELONGS_TO, 'SubBrandSeries', 'sub_brand_series_id'),
			'subBrand' => array(self::BELONGS_TO, 'SubBrand', 'sub_brand_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'serial_number' => 'Serial Number',
			'type' => 'Type',
			'sub_brand_id' => 'Sub Brand',
			'sub_brand_series_id' => 'Sub Brand Series',
			'attribute' => 'Attribute',
			'overall_diameter' => 'Overall Diameter',
			'section_width_inches' => 'Section Width Inches',
			'section_width_mm' => 'Section Width Mm',
			'aspect_ratio' => 'Aspect Ratio',
			'radial_type' => 'Radial Type',
			'rim_diameter' => 'Rim Diameter',
			'load_index' => 'Load Index',
			'speed_symbol' => 'Speed Symbol',
			'ply_rating' => 'Ply Rating',
			'lettering' => 'Lettering',
			'terrain' => 'Terrain',
			'local_import' => 'Local Import',
			'car_type' => 'Car Type',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('serial_number',$this->serial_number,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('sub_brand_id',$this->sub_brand_id);
		$criteria->compare('sub_brand_series_id',$this->sub_brand_series_id);
		$criteria->compare('attribute',$this->attribute,true);
		$criteria->compare('overall_diameter',$this->overall_diameter);
		$criteria->compare('section_width_inches',$this->section_width_inches);
		$criteria->compare('section_width_mm',$this->section_width_mm);
		$criteria->compare('aspect_ratio',$this->aspect_ratio);
		$criteria->compare('radial_type',$this->radial_type,true);
		$criteria->compare('rim_diameter',$this->rim_diameter);
		$criteria->compare('load_index',$this->load_index);
		$criteria->compare('speed_symbol',$this->speed_symbol,true);
		$criteria->compare('ply_rating',$this->ply_rating);
		$criteria->compare('lettering',$this->lettering,true);
		$criteria->compare('terrain',$this->terrain,true);
		$criteria->compare('local_import',$this->local_import,true);
		$criteria->compare('car_type',$this->car_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductSpecificationTire the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
