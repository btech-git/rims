<?php

/**
 * This is the model class for table "{{journal_beginning_header}}".
 *
 * The followings are the available columns in table '{{journal_beginning_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $note
 * @property string $status
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property string $cancelled_datetime
 * @property integer $user_id_created
 * @property integer $user_id_updated
 * @property integer $user_id_cancelled
 * @property integer $branch_id
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property JournalBeginningApproval[] $journalBeginningApprovals
 * @property JournalBeginningDetail[] $journalBeginningDetails
 * @property Branch $branch
 * @property Users $userIdCreated
 * @property Users $userIdUpdated
 * @property Users $userIdCancelled
 */
class JournalBeginningHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'JBB';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{journal_beginning_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, status, created_datetime, user_id_created, branch_id, is_inactive', 'required'),
            array('user_id_created, user_id_updated, user_id_cancelled, branch_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('status', 'length', 'max' => 20),
            array('note, updated_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, note, status, created_datetime, updated_datetime, cancelled_datetime, user_id_created, user_id_updated, user_id_cancelled, branch_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'journalBeginningApprovals' => array(self::HAS_MANY, 'JournalBeginningApproval', 'journal_beginning_header_id'),
            'journalBeginningDetails' => array(self::HAS_MANY, 'JournalBeginningDetail', 'journal_beginning_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
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
            'note' => 'Note',
            'status' => 'Status',
            'created_datetime' => 'Created Datetime',
            'updated_datetime' => 'Updated Datetime',
            'cancelled_datetime' => 'Cancelled Datetime',
            'user_id_created' => 'User Created',
            'user_id_updated' => 'User Updated',
            'user_id_cancelled' => 'User Cancelled',
            'branch_id' => 'Branch',
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
        $criteria->compare('note', $this->note, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('branch_id', $this->branch_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JournalBeginningHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
