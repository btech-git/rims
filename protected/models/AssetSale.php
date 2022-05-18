<?php

/**
 * This is the model class for table "{{asset_sale}}".
 *
 * The followings are the available columns in table '{{asset_sale}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $sale_price
 * @property string $note
 * @property integer $asset_purchase_id
 * @property integer $user_id
 * @property integer $company_bank_id
 *
 * The followings are the available model relations:
 * @property AssetPurchase $assetPurchase
 * @property Users $user
 * @property CompanyBank $companyBank
 */
class AssetSale extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'SAS';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{asset_sale}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, asset_purchase_id, user_id, company_bank_id', 'required'),
            array('asset_purchase_id, user_id, company_bank_id', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 50),
            array('sale_price', 'length', 'max' => 18),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, sale_price, note, asset_purchase_id, user_id, company_bank_id', 'safe', 'on' => 'search'),
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
            'companyBank' => array(self::BELONGS_TO, 'CompanyBank', 'company_bank_id'),
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
            'sale_price' => 'Sale Price',
            'note' => 'Note',
            'asset_purchase_id' => 'Asset Purchase',
            'user_id' => 'User',
            'company_bank_id' => 'Company Bank',
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
        $criteria->compare('sale_price', $this->sale_price, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('asset_purchase_id', $this->asset_purchase_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('company_bank_id', $this->company_bank_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AssetSale the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $assetSale = AssetSale::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth]),
        ));

        $branchCode = Branch::model()->findByPk($branchId)->code;
        if ($assetSale !== null) {
            $this->transaction_number = $assetSale->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $branchCode, AssetSale::CONSTANT, $currentMonth, $currentYear);
    }
}
