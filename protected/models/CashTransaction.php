<?php

/**
 * This is the model class for table "{{cash_transaction}}".
 *
 * The followings are the available columns in table '{{cash_transaction}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $transaction_type
 * @property integer $coa_id
 * @property string $debit_amount
 * @property string $credit_amount
 * @property integer $branch_id
 * @property integer $user_id
 * @property string $status
 * @property string $note
 * @property string $created_datetime
 * @property string $cancelled_datetime
 * @property integer $user_id_cancelled
 * @property string $updated_datetime
 * @property integer $user_id_updated
 *
 * The followings are the available model relations:
 * @property Coa $coa
 * @property Branch $branch
 * @property Users $user
 * @property UserIdCancelled $userIdCancelled
 * @property UserIdUpdated $userIdUpdated
 * @property CashTransactionApproval[] $cashTransactionApprovals
 * @property CashTransactionDetail[] $cashTransactionDetails
 * @property CashTransactionImages[] $cashTransactionImages
 */
class CashTransaction extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'CASH';

    /**
     * @return string the associated database table name
     */
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    public $coa_code;
    public $coa_name;
    public $coa_opening_balance;
    public $coa_debit;
    public $coa_credit;
    public $images;

    public function tableName() {
        return '{{cash_transaction}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, transaction_type, coa_id, branch_id, user_id', 'required'),
            array('coa_id, branch_id, user_id, user_id_cancelled, user_id_updated', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 50),
            array('transaction_type', 'length', 'max' => 20),
            array('debit_amount, credit_amount', 'length', 'max' => 18),
            array('status', 'length', 'max' => 30),
            array('transaction_number', 'unique'),
            array('note, updated_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, created_datetime, transaction_time, transaction_type, note, coa_id, debit_amount, credit_amount, branch_id, user_id, status, cancelled_datetime, user_id_cancelled, updated_datetime, user_id_updated', 'safe', 'on' => 'search'),
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
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
            'cashTransactionApprovals' => array(self::HAS_MANY, 'CashTransactionApproval', 'cash_transaction_id'),
            'cashTransactionDetails' => array(self::HAS_MANY, 'CashTransactionDetail', 'cash_transaction_id'),
            'cashTransactionImages' => array(self::HAS_MANY, 'CashTransactionImages', 'cash_transaction_id'),
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
            'transaction_type' => 'Transaction Type',
            'coa_id' => 'Coa',
            'debit_amount' => 'Debit Amount',
            'credit_amount' => 'Credit Amount',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'note' => 'Note',
            'status' => 'Status',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('debit_amount', $this->debit_amount, true);
        $criteria->compare('credit_amount', $this->credit_amount, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByAdmin() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('debit_amount', $this->debit_amount, true);
        $criteria->compare('credit_amount', $this->credit_amount, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);

//        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByDailyCashReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('debit_amount', $this->debit_amount, true);
        $criteria->compare('credit_amount', $this->credit_amount, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);

        $criteria->addCondition("t.status = 'Approved' AND t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CashTransaction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
  
    public function getTotalDebitAmount($branchId, $transactionDate) {
        $sql = "SELECT transaction_date, branch_id, transaction_type, COALESCE(SUM(debit_amount), 0) AS total_amount
                FROM " . CashTransaction::model()->tableName() . "
                WHERE branch_id = :branch_id AND transaction_date = :transaction_date AND transaction_type = 'In'
                GROUP BY transaction_date, branch_id, transaction_type";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':branch_id' => $branchId,
            ':transaction_date' => $transactionDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotalCreditAmount($branchId, $transactionDate) {
        $sql = "SELECT transaction_date, transaction_type, COALESCE(SUM(credit_amount), 0) AS total_amount
                FROM " . CashTransaction::model()->tableName() . "
                WHERE branch_id = :branch_id AND transaction_date = :transaction_date AND transaction_type = 'Out'
                GROUP BY transaction_date, transaction_type";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':branch_id' => $branchId,
            ':transaction_date' => $transactionDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotalAmount($branchId, $transactionDate) {
        $sql = "SELECT transaction_date, COALESCE(SUM(debit_amount), 0) AS total_amount
                FROM " . CashTransaction::model()->tableName() . "
                WHERE branch_id = :branch_id AND transaction_date = :transaction_date
                GROUP BY transaction_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':branch_id' => $branchId,
            ':transaction_date' => $transactionDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotalDetails() {
        $total = 0.00;
        
        foreach($this->cashTransactionDetails as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }

    public function searchByPendingJournal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('debit_amount', $this->debit_amount, true);
        $criteria->compare('credit_amount', $this->credit_amount, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', 'Approved');

        $criteria->addCondition("substring(t.transaction_number, 1, (length(t.transaction_number) - 2)) NOT IN (
            SELECT substring(kode_transaksi, 1, (length(kode_transaksi) - 2))  
            FROM " . JurnalUmum::model()->tableName() . "
        )");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public static function pendingJournal() {
        $sql = "SELECT p.id, p.transaction_number, p.transaction_date, p.transaction_type, b.name as branch_name, p.status
                FROM " . CashTransaction::model()->tableName() . " p
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = p.branch_id
                WHERE p.status = 'Approved' AND p.transaction_date > '2021-12-31' AND p.transaction_number NOT IN (
                    SELECT kode_transaksi 
                    FROM " . JurnalUmum::model()->tableName() . "
                )
                ORDER BY p.transaction_date DESC";

        return $sql;
    }
    
    public function getDetailNote() {
        
        $detailNoteList = array();
        
        foreach ($this->cashTransactionDetails as $detail) {
            
            $detailNoteList[] = $detail->notes;
        }
        $detailNoteUniqueList = array_unique(explode(', ', implode(', ', $detailNoteList)));
        
        return implode(', ', $detailNoteUniqueList);
    }
}
