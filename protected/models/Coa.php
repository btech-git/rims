<?php

/**
 * This is the model class for table "{{coa}}".
 *
 * The followings are the available columns in table '{{coa}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $coa_id
 * @property integer $coa_category_id
 * @property integer $coa_sub_category_id
 * @property string $cash_transaction
 * @property string $normal_balance
 * @property string $opening_balance
 * @property string $closing_balance
 * @property string $debit
 * @property string $credit
 * @property string $status
 * @property string $date
 * @property integer $is_approved
 * @property string $date_approval
 *
 * The followings are the available model relations:
 * @property CashTransaction[] $cashTransactions
 * @property CashTransactionDetail[] $cashTransactionDetails
 * @property Coa $coa
 * @property CoaCategory $coaCategory
 * @property CoaSubCategory $coaSubCategory
 * @property CoaDetail[] $coaDetails
 * @property CompanyBank[] $companyBanks
 * @property Customer[] $customers
 * @property ProductSubMasterCategory[] $productSubMasterCategories
 * @property ServiceCategory[] $serviceCategories
 * @property Supplier[] $suppliers
 * @property TransactionPurchaseOrder[] $transactionPurchaseOrders
 * @property TransactionSalesOrder[] $transactionSalesOrders
 * @property Bank[] $banks
 */
class Coa extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $bulan;
    public $coa_category_name;
    public $coa_sub_category_name;

    public function tableName() {
        return '{{coa}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, coa_category_id, coa_sub_category_id', 'required'),
            array('coa_category_id, coa_sub_category_id, coa_id, is_approved', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('normal_balance', 'length', 'max' => 10),
            array('code', 'length', 'max' => 15),
            array('status', 'length', 'max' => 20),
            array('cash_transaction', 'length', 'max' => 5),
            array('opening_balance, closing_balance, debit, credit', 'length', 'max' => 18),
            array('date_approval', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, coa_category_id, coa_sub_category_id, coa_category_name, coa_sub_category_name, opening_balance, closing_balance, debit, credit, normal_balance, coa_id, cash_transaction, status, date, is_approved, date_approval', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cashTransactions' => array(self::HAS_MANY, 'CashTransaction', 'coa_id'),
            'cashTransactionDetails' => array(self::HAS_MANY, 'CashTransactionDetail', 'coa_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'coaCategory' => array(self::BELONGS_TO, 'CoaCategory', 'coa_category_id'),
            'coaSubCategory' => array(self::BELONGS_TO, 'CoaSubCategory', 'coa_sub_category_id'),
            'coaDetails' => array(self::HAS_MANY, 'CoaDetail', 'coa_id'),
            'companyBanks' => array(self::HAS_MANY, 'CompanyBank', 'coa_id'),
            'customers' => array(self::HAS_MANY, 'Customer', 'coa_id'),
            'productSubMasterCategories' => array(self::HAS_MANY, 'ProductSubMasterCategory', 'coa_id'),
            'serviceCategories' => array(self::HAS_MANY, 'ServiceCategory', 'coa_id'),
            'suppliers' => array(self::HAS_MANY, 'Supplier', 'coa_id'),
            'transactionPurchaseOrders' => array(self::HAS_MANY, 'TransactionPurchaseOrder', 'coa_id'),
            'transactionSalesOrders' => array(self::HAS_MANY, 'TransactionSalesOrder', 'coa_id'),
            'coaIds' => array(self::HAS_MANY, 'Coa', 'coa_id'),
            'jurnalUmums' => array(self::HAS_MANY, 'JurnalUmum', 'coa_id'),
            'banks' => array(self::HAS_MANY, 'Bank', 'coa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'coa_category_id' => 'Coa Category',
            'coa_sub_category_id' => 'Coa Sub Category',
            'normal_balance' => 'Normal Balance',
            'opening_balance' => 'Opening Balance',
            'closing_balance' => 'Closing Balance',
            'debit' => 'Debit',
            'credit' => 'Credit',
            'is_approved' => 'Approval',
            'date_approval' => 'Tanggal Approval',
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
     * @return CActiveDataProvider the data provider that ctotalan return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.coa_category_id', $this->coa_category_id);
        $criteria->compare('t.coa_sub_category_id', $this->coa_sub_category_id);
        $criteria->compare('normal_balance', $this->normal_balance, true);
        $criteria->compare('opening_balance', $this->opening_balance, true);
        $criteria->compare('closing_balance', $this->closing_balance, true);
        $criteria->compare('debit', $this->debit, true);
        $criteria->compare('credit', $this->credit, true);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);

        $criteria->together = true;
        $criteria->with = array('coaCategory', 'coaSubCategory');
        $criteria->compare('coaCategory.name', $this->coa_category_name, true);
        $criteria->compare('coaSubCategory.name', $this->coa_sub_category_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCodeNumber($coaSubCategory) {
        $lastCode = Coa::model()->find(array(
            'order' => 'id DESC',
            'condition' => 'coa_sub_category_id = :coa_sub_category_id',
            'params' => array(':coa_sub_category_id' => $coaSubCategory),
        ));

        list($categoryCode, $subCategoryCode, $currentCode) = explode('.', $lastCode->code);

        if (empty($lastCode))
            $currentCode = 0;

        $this->code = sprintf('%s.%s.%03d', $categoryCode, $subCategoryCode, $currentCode + 1);
    }

    public function searchByDailyTransaction($pageNumber) {

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.coa_category_id', $this->coa_category_id);
        $criteria->compare('t.coa_sub_category_id', $this->coa_sub_category_id);
        $criteria->compare('normal_balance', $this->normal_balance, true);
        $criteria->compare('opening_balance', $this->opening_balance, true);
        $criteria->compare('closing_balance', $this->closing_balance, true);
        $criteria->compare('debit', $this->debit, true);
        $criteria->compare('credit', $this->credit, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
                'currentPage' => $pageNumber - 1,
            ),
        ));
    }

    public function getTransactionTotalDebitAmount() {
        $sql = "SELECT branch_id, COALESCE(SUM(total), 0) AS total_amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND debet_kredit = 'D'
                GROUP BY branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':coa_id' => $this->id));

        return $resultSet;
    }

    public function getTransactionTotalCreditAmount() {
        $sql = "SELECT branch_id, COALESCE(SUM(total), 0) AS total_amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND debet_kredit = 'K'
                GROUP BY branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':coa_id' => $this->id));

        return $resultSet;
    }

    public function getReportBeginningBalanceDebit($startDate, $branchId) {
        $branchConditionSql = '';
        $params = array(
            ':start_date' => $startDate,
            ':coa_id' => $this->id,
        );
        if (!empty($branchId)) {
            $branchConditionSql = ' AND dc.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }

        $sql = "SELECT COALESCE(SUM(dc.total), 0) AS beginning_balance 
                FROM " . JurnalUmum::model()->tableName() . " dc
                INNER JOIN " . Coa::model()->tableName() . " a ON a.id = dc.coa_id
                WHERE dc.tanggal_transaksi < :start_date AND dc.coa_id = :coa_id" . $branchConditionSql . " AND debet_kredit = 'D'";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }

    public function getReportBeginningBalanceCredit($startDate, $branchId) {
        $branchConditionSql = '';
        $params = array(
            ':start_date' => $startDate,
            ':coa_id' => $this->id,
        );
        if (!empty($branchId)) {
            $branchConditionSql = ' AND dc.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }

        $sql = "SELECT COALESCE(SUM(dc.total), 0) AS beginning_balance 
                FROM " . JurnalUmum::model()->tableName() . " dc
                INNER JOIN " . Coa::model()->tableName() . " a ON a.id = dc.coa_id
                WHERE dc.tanggal_transaksi < :start_date AND dc.coa_id = :coa_id" . $branchConditionSql . " AND debet_kredit = 'K'";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }

    public function getReportForecastData($transactionDate) {
        $sql = "SELECT transaction_subject, total, debet_kredit
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND tanggal_transaksi = :transaction_date";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':coa_id' => $this->id,
            ':transaction_date' => $transactionDate,
        ));

        return $resultSet;
    }

    public function getBeginningBalanceLedger($startDate) {
        $sql = "
            SELECT COALESCE(SUM(j.amount), 0) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D'
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K'
            ) j
            INNER JOIN " . Coa::model()->tableName() . " a ON a.id = j.coa_id
            WHERE j.coa_id = :account_id AND j.tanggal_transaksi < :start_date
            GROUP BY j.coa_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':account_id' => $this->id,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getEndingBalanceLedger($accountId, $endDate) {
        $sql = "
            SELECT COALESCE(SUM(j.total), 0) AS beginning_balance 
            FROM " . JurnalUmum::model()->tableName() . " j
            INNER JOIN " . Account::model()->tableName() . " a ON a.id = dc.detail_account_id
            WHERE dc.account_id = :account_id AND dc.date <= :end_date
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':account_id' => $accountId,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getBalanceTotal($startDate, $endDate, $branchId) {
        $balanceTotal = 0.00;
        $branchConditionSql = '';
        $params = array(
            ':startDate' => $startDate,
            ':endDate' => $endDate,
            ':coa_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }

        $accountingJournals = $this->getRelated('jurnalUmums', false, array(
            'condition' => "tanggal_transaksi BETWEEN :startDate AND :endDate AND coa_id = :coa_id" . $branchConditionSql,
            'params' => $params,
        ));

        if ($accountingJournals != null) {
            foreach ($accountingJournals as $accountingJournal) {
                $debitAmount = $accountingJournal->debet_kredit == 'D' ? $accountingJournal->total : 0;
                $creditAmount = $accountingJournal->debet_kredit == 'K' ? $accountingJournal->total : 0;
                if (
                    $this->coa_category_id == 3 ||
                    $this->coa_category_id == 4 || 
                    $this->coa_category_id == 5
                ) {
                    $balanceTotal += $creditAmount - $debitAmount;
                } else if ($this->coa_category_id == 1 || $this->coa_category_id == 2) {
                    $balanceTotal += $debitAmount - $creditAmount;
                } else {
                    $balanceTotal = 0.00;
                }
            }
        }
        
        return $balanceTotal;
    }
    
    public function getProfitLossBalance($startDate, $endDate, $branchId) {
//        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        /*if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }*/
        
        $sql = "SELECT SUM(total) AS balance
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date
                GROUP BY coa_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getProfitLossPreviousBalance($startDate, $endDate) {
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
        );
        
        $sql = "SELECT SUM(total) AS balance
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND tanggal_transaksi < :start_date
                GROUP BY coa_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getBeginningBalanceFinancialForecast($transactionDate) {
        $balanceTotal = 0.00;
        $params = array(
            ':transactionDate' => $transactionDate,
            ':coa_id' => $this->id,
        );
        
        $accountingJournals = $this->getRelated('jurnalUmums', false, array(
            'condition' => "tanggal_transaksi < :transactionDate AND coa_id = :coa_id",
            'params' => $params,
        ));

        if ($accountingJournals != null) {
            foreach ($accountingJournals as $accountingJournal) {
                $debitAmount = $accountingJournal->debet_kredit == 'D' ? $accountingJournal->total : 0;
                $creditAmount = $accountingJournal->debet_kredit == 'K' ? $accountingJournal->total : 0;
                if (
                    $this->coa_category_id == 3 ||
                    $this->coa_category_id == 4 || 
                    $this->coa_category_id == 5
                ) {
                    $balanceTotal += $creditAmount - $debitAmount;
                } else if ($this->coa_category_id == 1 || $this->coa_category_id == 2) {
                    $balanceTotal += $debitAmount - $creditAmount;
                } else {
                    $balanceTotal = 0.00;
                }
            }
        }
        
        return $balanceTotal;
    }
    
    public function getFinancialForecastReport($datePrevious) {
        
        $sql = "SELECT transaction_date, coa_id, SUM(receivable_debit) AS total_receivable_debit, SUM(payable_credit) AS total_payable_credit, SUM(journal_debit) AS total_journal_debit, SUM(journal_credit) AS total_journal_credit
                FROM (
                    SELECT invoice_number AS transaction_number, payment_date_estimate AS transaction_date, coa_bank_id_estimate AS coa_id, branch_id, total_price AS receivable_debit, 0 AS payable_credit, 0 AS journal_debit, 0 AS journal_credit, payment_left AS remaining
                    FROM " . InvoiceHeader::model()->tableName() . "
                    UNION
                    SELECT purchase_order_no AS transaction_number, payment_date_estimate AS transaction_date, coa_bank_id_estimate AS coa_id, main_branch_id AS branch_id, 0 AS receivable_debit, total_price AS payable_credit, 0 AS journal_debit, 0 AS journal_credit, payment_left AS remaining
                    FROM " . TransactionPurchaseOrder::model()->tableName() . "
                    UNION
                    SELECT kode_transaksi AS transaction_number, tanggal_transaksi AS transaction_date, coa_id, branch_id, 0 AS receivable_debit, 0 AS payable_credit, total AS journal_debit, 0 AS journal_credit, 1 AS remaining
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE debet_kredit = 'D'
                    UNION
                    SELECT kode_transaksi AS transaction_number, tanggal_transaksi AS transaction_date, coa_id, branch_id, 0 AS receivable_debit, 0 AS payable_credit, 0 AS journal_debit, total AS journal_credit, 1 AS remaining
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE debet_kredit = 'K'
                ) transaction
                WHERE remaining > 0 AND transaction_date BETWEEN :payment_date_estimate AND :date_now AND coa_id = :coa_bank_id_estimate
                GROUP BY transaction_date
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':date_now' => date('Y-m-d'),
            ':payment_date_estimate' => $datePrevious,
            ':coa_bank_id_estimate' => $this->id,
//            ':branch_id' => $branchId,
        ));
        
        return $resultSet;
    }
    
    public function getFinancialForecastDetails($transactionDate) {
        
        $sql = "SELECT transaction_number, payment_date_estimate, coa_bank_id_estimate, branch_id, debit, credit, remaining
                FROM (
                    SELECT invoice_number AS transaction_number, payment_date_estimate, coa_bank_id_estimate, branch_id, total_price AS debit, 0 AS credit, payment_left AS remaining
                    FROM " . InvoiceHeader::model()->tableName() . "
                    UNION
                    SELECT purchase_order_no AS transaction_number, payment_date_estimate, coa_bank_id_estimate, main_branch_id AS branch_id, 0 AS debit, total_price AS credit, payment_left AS remaining
                    FROM " . TransactionPurchaseOrder::model()->tableName() . "
                ) transaction
                WHERE remaining > 0 AND payment_date_estimate =:payment_date_estimate AND coa_bank_id_estimate = :coa_bank_id_estimate
                ORDER BY payment_date_estimate ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':payment_date_estimate' => $transactionDate,
            ':coa_bank_id_estimate' => $this->id,
        ));
        
        return $resultSet;
    }
}
