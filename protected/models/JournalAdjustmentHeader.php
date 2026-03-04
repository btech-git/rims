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
 * @property integer $user_id_updated
 * @property integer $user_id_cancelled
 * @property integer $branch_id
 * @property string $status
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property string $cancelled_datetime
 * @property integer $is_verified
 * @property integer $user_id_verified
 * @property string $verified_datetime
 *
 * The followings are the available model relations:
 * @property JournalAdjustmentDetail[] $journalAdjustmentDetails
 * @property JournalAdjustmentApproval[] $journalAdjustmentApprovals
 * @property Users $user
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdCancelled $userIdCancelled
 * @property Branch $branch
 * @property UserIdVerified $userIdVerified
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
            array('transaction_number, date, time, user_id, branch_id, status, is_verified', 'required'),
            array('user_id, user_id_updated, user_id_cancelled, branch_id, user_id_updated, is_verified, user_id_verified', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('status', 'length', 'max' => 20),
            array('note, created_datetime, updated_datetime, cancelled_datetime, verified_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, date, time, note, user_id, user_id_updated, user_id_cancelled, branch_id, status, created_datetime, updated_datetime, cancelled_datetime, is_verified, user_id_verified, verified_datetime', 'safe', 'on' => 'search'),
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
            'journalAdjustmentApprovals' => array(self::HAS_MANY, 'JournalAdjustmentApproval', 'journal_adjustment_header_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'userIdVerified' => array(self::BELONGS_TO, 'Users', 'user_id_verified'),
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

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date DESC',
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByDailyCashReport() {
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

        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
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
