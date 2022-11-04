<?php

/**
 * This is the model class for table "{{asset_depreciation_header}}".
 *
 * The followings are the available columns in table '{{asset_depreciation_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property integer $depreciation_period_month
 * @property integer $depreciation_period_year
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property AssetDepreciationDetail[] $assetDepreciationDetails
 * @property Users $user
 */
class AssetDepreciationHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'DAS';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AssetDepreciationHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{asset_depreciation_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, depreciation_period_month, depreciation_period_year, user_id', 'required'),
            array('user_id, depreciation_period_month, depreciation_period_year', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, depreciation_period_month, depreciation_period_year, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'assetDepreciationDetails' => array(self::HAS_MANY, 'AssetDepreciationDetail', 'asset_depreciation_header_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'transaction_time' => 'Transaction Time',
            'user_id' => 'User',
            'depreciation_period_month' => 'Period Month',
            'depreciation_period_year' => 'Period Year',
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('depreciation_period_month', $this->depreciation_period_month);
        $criteria->compare('depreciation_period_year', $this->depreciation_period_year);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $assetDepreciation = AssetDepreciationHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth]),
        ));

        $branchCode = Branch::model()->findByPk($branchId)->code;
        if ($assetDepreciation !== null) {
            $this->transaction_number = $assetDepreciation->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $branchCode, AssetDepreciationHeader::CONSTANT, $currentMonth, $currentYear);
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
}
