<?php

/**
 * This is the model class for table "{{cash_daily_approval}}".
 *
 * The followings are the available columns in table '{{cash_daily_approval}}':
 * @property integer $id
 * @property string $transaction_date
 * @property string $amount
 * @property integer $user_id
 * @property string $approval_date
 * @property string $approval_time
 *
 * The followings are the available model relations:
 * @property Users $user
 */
class CashDailyApproval extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CashDailyApproval the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cash_daily_approval}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_date, user_id, approval_date, approval_time', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, transaction_date, amount, user_id, approval_date, approval_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
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
            'user_id' => 'User',
            'approval_date' => 'Approval Date',
            'approval_time' => 'Approval Time',
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
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('approval_date', $this->approval_date, true);
        $criteria->compare('approval_time', $this->approval_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getApprovalList($monthStart, $yearStart, $monthEnd, $yearEnd) {
        $sql = "SELECT c.transaction_date, u.username, c.approval_date, c.amount
                FROM " . CashDailyApproval::model()->tableName() . " c
                INNER JOIN " . Users::model()->tableName() . " u ON u.id = c.user_id
                WHERE CONCAT(SUBSTRING_INDEX(c.transaction_date, '-', 1), '-', SUBSTRING_INDEX(SUBSTRING_INDEX(c.transaction_date, '-', 2), '-', -1)) BETWEEN :yearMonthStart AND :yearMonthEnd
                ORDER BY c.transaction_date ASC";
        
        $resultSet = CActiveRecord::$db->createCommand($sql)->queryAll(true, array(
            ':yearMonthStart' => $yearStart . '-' . $monthStart,
            ':yearMonthEnd' => $yearEnd . '-' . $monthEnd,
        ));

        return $resultSet;
    }
}
