<?php

/**
 * This is the model class for table "{{asset_purchase}}".
 *
 * The followings are the available columns in table '{{asset_purchase}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $purchase_price
 * @property integer $monthly_useful_life
 * @property string $depreciation_amount
 * @property string $depreciation_start_date
 * @property string $depreciation_end_date
 * @property string $status
 * @property string $note
 * @property integer $asset_category_id
 * @property integer $user_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property AssetDepreciation[] $assetDepreciations
 * @property AssetCategory $assetCategory
 * @property Users $user
 * @property AssetSale[] $assetSales
 */
class AssetPurchase extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'PAS';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{asset_purchase}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, depreciation_start_date, depreciation_end_date, status, asset_category_id, user_id, description', 'required'),
            array('monthly_useful_life, asset_category_id, user_id', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 20),
            array('transaction_number', 'length', 'max' => 50),
            array('purchase_price, depreciation_amount', 'length', 'max' => 18),
            array('description', 'length', 'max' => 100),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, purchase_price, monthly_useful_life, depreciation_amount, depreciation_start_date, depreciation_end_date, status, note, asset_category_id, user_id, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'assetDepreciations' => array(self::HAS_MANY, 'AssetDepreciation', 'asset_purchase_id'),
            'assetCategory' => array(self::BELONGS_TO, 'AssetCategory', 'asset_category_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'assetSales' => array(self::HAS_MANY, 'AssetSale', 'asset_purchase_id'),
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
            'purchase_price' => 'Purchase Price',
            'monthly_useful_life' => 'Monthly Useful Life',
            'depreciation_amount' => 'Depreciation Amount',
            'depreciation_start_date' => 'Depreciation Start Date',
            'depreciation_end_date' => 'Depreciation End Date',
            'status' => 'Status',
            'note' => 'Note',
            'asset_category_id' => 'Asset Category',
            'user_id' => 'User',
            'description' => 'Description',
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('monthly_useful_life', $this->monthly_useful_life);
        $criteria->compare('depreciation_amount', $this->depreciation_amount, true);
        $criteria->compare('depreciation_start_date', $this->depreciation_start_date, true);
        $criteria->compare('depreciation_end_date', $this->depreciation_end_date, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('asset_category_id', $this->asset_category_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AssetPurchase the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $assetPurchase = AssetPurchase::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth]),
        ));

        $branchCode = Branch::model()->findByPk($branchId)->code;
        if ($assetPurchase !== null) {
            $this->transaction_number = $assetPurchase->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $branchCode, AssetPurchase::CONSTANT, $currentMonth, $currentYear);
    }
    
}
