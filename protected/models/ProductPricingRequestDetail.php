<?php

/**
 * This is the model class for table "{{product_pricing_request_detail}}".
 *
 * The followings are the available columns in table '{{product_pricing_request_detail}}':
 * @property integer $id
 * @property string $recommended_price
 * @property string $quantity
 * @property string $product_name
 * @property string $memo
 * @property integer $brand_id
 * @property integer $sub_brand_id
 * @property integer $sub_brand_series_id
 * @property integer $product_master_category_id
 * @property integer $product_sub_master_category_id
 * @property integer $product_sub_category_id
 * @property integer $product_pricing_request_header_id
 * @property integer $is_inactive
 * @property string $product_code
 * @property integer $unit_id
 * @property integer $production_year
 *
 * The followings are the available model relations:
 * @property Brand $brand
 * @property ProductMasterCategory $productMasterCategory
 * @property ProductPricingRequestHeader $productPricingRequestHeader
 * @property ProductSubCategory $productSubCategory
 * @property ProductSubMasterCategory $productSubMasterCategory
 * @property SubBrand $subBrand
 * @property SubBrandSeries $subBrandSeries
 * @property Unit $unit
 */
class ProductPricingRequestDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product_pricing_request_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_name, product_pricing_request_header_id, unit_id, product_code, production_year', 'required'),
            array('brand_id, sub_brand_id, sub_brand_series_id, product_master_category_id, product_sub_master_category_id, product_sub_category_id, product_pricing_request_header_id, is_inactive, unit_id, production_year', 'numerical', 'integerOnly' => true),
            array('recommended_price', 'length', 'max' => 18),
            array('quantity', 'length', 'max' => 10),
            array('product_name', 'length', 'max' => 100),
            array('product_code', 'length', 'max' => 50),
            array('memo', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, recommended_price, quantity, product_name, memo, brand_id, sub_brand_id, sub_brand_series_id, product_master_category_id, product_sub_master_category_id, product_sub_category_id, product_pricing_request_header_id, is_inactive, unit_id, product_code, production_year', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
            'productPricingRequestHeader' => array(self::BELONGS_TO, 'ProductPricingRequestHeader', 'product_pricing_request_header_id'),
            'productSubCategory' => array(self::BELONGS_TO, 'ProductSubCategory', 'product_sub_category_id'),
            'productSubMasterCategory' => array(self::BELONGS_TO, 'ProductSubMasterCategory', 'product_sub_master_category_id'),
            'subBrand' => array(self::BELONGS_TO, 'SubBrand', 'sub_brand_id'),
            'subBrandSeries' => array(self::BELONGS_TO, 'SubBrandSeries', 'sub_brand_series_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'recommended_price' => 'Recommended Price',
            'quantity' => 'Quantity',
            'product_name' => 'Product Name',
            'memo' => 'Memo',
            'brand_id' => 'Brand',
            'sub_brand_id' => 'Sub Brand',
            'sub_brand_series_id' => 'Sub Brand Series',
            'product_master_category_id' => 'Product Master Category',
            'product_sub_master_category_id' => 'Product Sub Master Category',
            'product_sub_category_id' => 'Product Sub Category',
            'product_pricing_request_header_id' => 'Product Pricing Request Header',
            'is_inactive' => 'Is Inactive',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('recommended_price', $this->recommended_price, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('brand_id', $this->brand_id);
        $criteria->compare('sub_brand_id', $this->sub_brand_id);
        $criteria->compare('sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('product_master_category_id', $this->product_master_category_id);
        $criteria->compare('product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('product_pricing_request_header_id', $this->product_pricing_request_header_id);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}