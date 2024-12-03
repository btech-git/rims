<?php

/**
 * This is the model class for table "{{cash_transaction_detail}}".
 *
 * The followings are the available columns in table '{{cash_transaction_detail}}':
 * @property integer $id
 * @property integer $cash_transaction_id
 * @property integer $coa_id
 * @property string $amount
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property CashTransaction $cashTransaction
 * @property Coa $coa
 */
class CashTransactionDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $coa_name;
    public $coa_normal_balance;
    public $coa_debit;
    public $coa_credit;

    public function tableName() {
        return '{{cash_transaction_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cash_transaction_id, coa_id, amount, notes', 'required'),
            array('cash_transaction_id, coa_id', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, cash_transaction_id, coa_id, amount, notes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cashTransaction' => array(self::BELONGS_TO, 'CashTransaction', 'cash_transaction_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cash_transaction_id' => 'Cash Transaction',
            'coa_id' => 'Coa',
            'amount' => 'Amount',
            'notes' => 'Notes',
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
        $criteria->compare('cash_transaction_id', $this->cash_transaction_id);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('notes', $this->notes, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CashTransactionDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
