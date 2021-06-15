<?php

/**
 * This is the model class for table "{{financial_forecast_approval}}".
 *
 * The followings are the available columns in table '{{financial_forecast_approval}}':
 * @property integer $id
 * @property string $date_transaction
 * @property string $debit_receivable
 * @property string $debit_journal
 * @property string $credit_payable
 * @property string $credit_journal
 * @property integer $coa_id
 * @property string $date_approval
 * @property string $time_approval
 * @property string $total_amount
 * @property integer $user_id_approval
 *
 * The followings are the available model relations:
 * @property Coa $coa
 * @property Users $userIdApproval
 */
class FinancialForecastApproval extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{financial_forecast_approval}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('date_transaction, coa_id, date_approval, time_approval, total_amount, user_id_approval', 'required'),
            array('coa_id, user_id_approval', 'numerical', 'integerOnly' => true),
            array('debit_receivable, debit_journal, credit_payable, credit_journal, total_amount', 'length', 'max' => 18),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date_transaction, debit_receivable, debit_journal, credit_payable, credit_journal, coa_id, date_approval, time_approval, total_amount, user_id_approval', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date_transaction' => 'Date Transaction',
            'debit_receivable' => 'Debit Receivable',
            'debit_journal' => 'Debit Journal',
            'credit_payable' => 'Credit Payable',
            'credit_journal' => 'Credit Journal',
            'coa_id' => 'Coa',
            'date_approval' => 'Date Approval',
            'time_approval' => 'Time Approval',
            'total_amount' => 'Total Amount',
            'user_id_approval' => 'User Id Approval',
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
        $criteria->compare('date_transaction', $this->date_transaction, true);
        $criteria->compare('debit_receivable', $this->debit_receivable, true);
        $criteria->compare('debit_journal', $this->debit_journal, true);
        $criteria->compare('credit_payable', $this->credit_payable, true);
        $criteria->compare('credit_journal', $this->credit_journal, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('date_approval', $this->date_approval, true);
        $criteria->compare('time_approval', $this->time_approval, true);
        $criteria->compare('total_amount', $this->total_amount, true);
        $criteria->compare('user_id_approval', $this->user_id_approval);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FinancialForecastApproval the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
