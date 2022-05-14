<?php

/**
 * This is the model class for table "{{asset_depreciation}}".
 *
 * The followings are the available columns in table '{{asset_depreciation}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $amount
 * @property integer $number_of_month
 * @property integer $asset_purchase_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property AssetPurchase $assetPurchase
 * @property Users $user
 */
class AssetDepreciation extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'DAS';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{asset_depreciation}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, asset_purchase_id, user_id', 'required'),
            array('number_of_month, asset_purchase_id, user_id', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 50),
            array('amount', 'length', 'max' => 18),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, amount, number_of_month, asset_purchase_id, user_id', 'safe', 'on' => 'search'),
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
            'amount' => 'Amount',
            'number_of_month' => 'Number Of Month',
            'asset_purchase_id' => 'Asset Purchase',
            'user_id' => 'User',
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
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('number_of_month', $this->number_of_month);
        $criteria->compare('asset_purchase_id', $this->asset_purchase_id);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AssetDepreciation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $assetPurchase = AssetDepreciation::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth]),
        ));

        $branchCode = Branch::model()->findByPk($branchId)->code;
        if ($assetPurchase !== null) {
            $this->transaction_number = $assetPurchase->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $branchCode, AssetDepreciation::CONSTANT, $currentMonth, $currentYear);
    }
    
}
