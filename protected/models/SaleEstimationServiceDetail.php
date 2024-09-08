<?php

/**
 * This is the model class for table "{{sale_estimation_service_detail}}".
 *
 * The followings are the available columns in table '{{sale_estimation_service_detail}}':
 * @property integer $id
 * @property string $price
 * @property string $discount_value
 * @property string $discount_type
 * @property string $memo
 * @property integer $sale_estimation_header_id
 * @property integer $service_id
 * @property integer $service_type_id
 *
 * The followings are the available model relations:
 * @property ServiceType $serviceType
 * @property Service $service
 * @property SaleEstimationHeader $saleEstimationHeader
 */
class SaleEstimationServiceDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sale_estimation_service_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sale_estimation_header_id, service_id, service_type_id', 'required'),
            array('sale_estimation_header_id, service_id, service_type_id', 'numerical', 'integerOnly' => true),
            array('price', 'length', 'max' => 18),
            array('discount_value', 'length', 'max' => 10),
            array('discount_type', 'length', 'max' => 20),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, price, discount_value, discount_type, memo, sale_estimation_header_id, service_id, service_type_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'service_type_id'),
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
            'saleEstimationHeader' => array(self::BELONGS_TO, 'SaleEstimationHeader', 'sale_estimation_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'price' => 'Price',
            'discount_value' => 'Discount Value',
            'discount_type' => 'Discount Type',
            'memo' => 'Memo',
            'sale_estimation_header_id' => 'Sale Estimation Header',
            'service_id' => 'Service',
            'service_type_id' => 'Service Type',
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
        $criteria->compare('price', $this->price, true);
        $criteria->compare('discount_value', $this->discount_value, true);
        $criteria->compare('discount_type', $this->discount_type, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('sale_estimation_header_id', $this->sale_estimation_header_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('service_type_id', $this->service_type_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SaleEstimationServiceDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
