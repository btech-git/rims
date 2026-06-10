<?php

/**
 * This is the model class for table "{{sale_estimation_new_parts_detail}}".
 *
 * The followings are the available columns in table '{{sale_estimation_new_parts_detail}}':
 * @property integer $id
 * @property integer $quantity
 * @property string $retail_price
 * @property string $sale_price
 * @property string $discount_value
 * @property string $discount_type
 * @property string $total_price
 * @property string $memo
 * @property string $parts_name
 * @property string $parts_code
 * @property integer $sale_estimation_header_id
 *
 * The followings are the available model relations:
 * @property SaleEstimationHeader $saleEstimationHeader
 */
class SaleEstimationNewPartsDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sale_estimation_new_parts_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('parts_name, sale_estimation_header_id', 'required'),
            array('quantity, sale_estimation_header_id', 'numerical', 'integerOnly' => true),
            array('retail_price, sale_price, total_price', 'length', 'max' => 18),
            array('discount_value', 'length', 'max' => 10),
            array('discount_type', 'length', 'max' => 20),
            array('memo, parts_code', 'length', 'max' => 100),
            array('parts_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, quantity, retail_price, sale_price, discount_value, discount_type, total_price, memo, parts_name, parts_code, sale_estimation_header_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'saleEstimationHeader' => array(self::BELONGS_TO, 'SaleEstimationHeader', 'sale_estimation_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'retail_price' => 'Retail Price',
            'sale_price' => 'Sale Price',
            'discount_value' => 'Discount Value',
            'discount_type' => 'Discount Type',
            'total_price' => 'Total Price',
            'memo' => 'Memo',
            'parts_name' => 'Parts Name',
            'parts_code' => 'Parts Code',
            'sale_estimation_header_id' => 'Sale Estimation Header',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('retail_price', $this->retail_price, true);
        $criteria->compare('sale_price', $this->sale_price, true);
        $criteria->compare('discount_value', $this->discount_value, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('parts_name', $this->parts_name, true);
        $criteria->compare('parts_code', $this->parts_code, true);
        $criteria->compare('sale_estimation_header_id', $this->sale_estimation_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SaleEstimationNewPartsDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalBeforeDiscount() {
        
        return $this->quantity * $this->sale_price;
    }

    public function getDiscountAmount() {

        return ($this->discount_type == 'Nominal') ? $this->discount_value : $this->quantity * $this->sale_price * $this->discount_value / 100;
    }

    public function getTotalPrice() {
        
        return $this->quantity * $this->sale_price - $this->discountAmount;
    }
}