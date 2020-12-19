<?php

/**
 * This is the model class for table "{{cash_daily_summary}}".
 *
 * The followings are the available columns in table '{{cash_daily_summary}}':
 * @property integer $id
 * @property string $transaction_date
 * @property string $amount
 * @property string $memo
 * @property integer $branch_id
 * @property integer $user_id
 * @property string $input_datetime
 * @property integer $payment_type_id
 *
 * The followings are the available model relations:
 * @property CashDailyImages[] $cashDailyImages
 * @property PaymentType $paymentType
 * @property Branch $branch
 * @property Users $user
 */
class CashDailySummary extends CActiveRecord {

    public $images;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CashDailySummary the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cash_daily_summary}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_date, branch_id, user_id', 'required'),
            array('branch_id, user_id, payment_type_id', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, transaction_date, amount, memo, branch_id, user_id, input_datetime, payment_type_id, images', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cashDailyImages' => array(self::HAS_MANY, 'CashDailyImages', 'cash_daily_summary_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_date' => 'Transaction Date',
            'amount' => 'Amount',
            'memo' => 'Memo',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'input_datetime' => 'Input Datetime',
            'payment_type_id' => 'Payment Type',
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
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('input_datetime', $this->input_datetime, true);
        $criteria->compare('payment_type_id', $this->payment_type_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFilename() {
        
        return $this->id . '.' . $this->extension;
    }
}
