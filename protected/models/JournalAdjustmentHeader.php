<?php

/**
 * This is the model class for table "{{journal_adjustment_header}}".
 *
 * The followings are the available columns in table '{{journal_adjustment_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $date
 * @property string $time
 * @property string $note
 * @property integer $user_id
 * @property integer $branch_id
 * @property string $status
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property JournalAdjustmentDetail[] $journalAdjustmentDetails
 * @property Users $user
 * @property Branch $branch
 */
class JournalAdjustmentHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'JAD';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{journal_adjustment_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, date, time, user_id, branch_id, status', 'required'),
            array('user_id, branch_id', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('status', 'length', 'max' => 20),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, date, time, note, user_id, branch_id, status, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'journalAdjustmentDetails' => array(self::HAS_MANY, 'JournalAdjustmentDetail', 'journal_adjustment_header_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'date' => 'Date',
            'time' => 'Time',
            'note' => 'Note',
            'user_id' => 'User',
            'branch_id' => 'Branch',
            'status' => 'Status',
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date DESC',
            ),
        ));
    }

    public function searchByAdmin() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('status', $this->status, true);

//        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date DESC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JournalAdjustmentHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalDebit() {
        $total = 0.00;
        
        foreach ($this->journalAdjustmentDetails as $detail) {
            $total += $detail->debit;
        }
        
        return $total;
    }

    public function getTotalCredit() {
        $total = 0.00;
        
        foreach ($this->journalAdjustmentDetails as $detail) {
            $total += $detail->credit;
        }
        
        return $total;
    }
}
