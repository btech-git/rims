<?php

/**
 * This is the model class for table "{{asset_depreciation_detail}}".
 *
 * The followings are the available columns in table '{{asset_depreciation_detail}}':
 * @property integer $id
 * @property string $amount
 * @property integer $number_of_month
 * @property integer $depreciation_period_month
 * @property integer $depreciation_period_year
 * @property integer $asset_purchase_id
 * @property integer $asset_depreciation_header_id
 *
 * The followings are the available model relations:
 * @property AssetPurchase $assetPurchase
 * @property AssetDepreciationHeader $assetDepreciationHeader
 */
class AssetDepreciationDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AssetDepreciationDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{asset_depreciation_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('asset_purchase_id, asset_depreciation_header_id, depreciation_period_month, depreciation_period_year', 'required'),
            array('number_of_month, asset_purchase_id, asset_depreciation_header_id, depreciation_period_month, depreciation_period_year', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, amount, number_of_month, asset_purchase_id, asset_depreciation_header_id, depreciation_period_month, depreciation_period_year', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'assetPurchase' => array(self::BELONGS_TO, 'AssetPurchase', 'asset_purchase_id'),
            'assetDepreciationHeader' => array(self::BELONGS_TO, 'AssetDepreciationHeader', 'asset_depreciation_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'amount' => 'Amount',
            'number_of_month' => 'Number Of Month',
            'asset_purchase_id' => 'Asset Purchase',
            'asset_depreciation_header_id' => 'Asset Depreciation Header',
            'depreciation_period_month' => 'Depreciation Month',
            'depreciation_period_year' => 'Depreciation Year',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('number_of_month', $this->number_of_month);
        $criteria->compare('asset_purchase_id', $this->asset_purchase_id);
        $criteria->compare('asset_depreciation_header_id', $this->asset_depreciation_header_id);
        $criteria->compare('depreciation_period_month', $this->depreciation_period_month);
        $criteria->compare('depreciation_period_year', $this->depreciation_period_year);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getYearsRange() {
        $currentYear = date('Y');
        $yearFrom = $currentYear - 2;
        $yearTo = $currentYear + 2;
        $yearsRange = range($yearFrom, $yearTo);
        return array_combine($yearsRange, $yearsRange);
    }
    
    public function getDepreciationPeriodMonth($month) {
        
        switch($month) {
            case 1: return 'Jan';
            case 2: return 'Feb';
            case 3: return 'Mar';
            case 4: return 'Apr';
            case 5: return 'May';
            case 6: return 'Jun';
            case 7: return 'Jul';
            case 8: return 'Aug';
            case 9: return 'Sep';
            case 10: return 'Oct';
            case 11: return 'Nov';
            case 12: return 'Dec';
            default: return '';
        }
    }

    public function getPeriodMonthYear() {
        
        return $this->getDepreciationPeriodMonth($this->depreciation_period_month) . ' ' . $this->depreciation_period_year;
    }
}
