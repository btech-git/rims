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
 * @property integer $user_id
 * @property integer $is_approved
 * @property string $date
 * @property string $date_approval
 * @property string $time_created
 * @property string $time_approval
 * @property integer $user_id_approval
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
 * @property User $user
 * @property UserIdApproval $userIdApproval
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
            array('name, coa_category_id, coa_sub_category_id, user_id', 'required'),
            array('coa_category_id, coa_sub_category_id, coa_id, is_approved, user_id, user_id_approval', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('normal_balance', 'length', 'max' => 10),
            array('code', 'length', 'max' => 15),
            array('status', 'length', 'max' => 20),
            array('cash_transaction', 'length', 'max' => 5),
            array('opening_balance, closing_balance, debit, credit', 'length', 'max' => 18),
            array('date_approval', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, coa_category_id, coa_sub_category_id, coa_category_name, coa_sub_category_name, opening_balance, closing_balance, debit, credit, normal_balance, coa_id, cash_transaction, status, date, is_approved, date_approval, user_id, user_id_approval', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
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
            'user_id' => 'User Input',
            'user_id_approval' => 'User Approval',
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
        $criteria->compare('t.is_approved', 1);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.user_id_approval', $this->user_id_approval);

        $criteria->together = true;
        $criteria->with = array('coaCategory', 'coaSubCategory');
        $criteria->compare('coaCategory.name', $this->coa_category_name, true);
        $criteria->compare('coaSubCategory.name', $this->coa_sub_category_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.code ASC, t.name ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByTransactionJournal() {

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
        $criteria->compare('t.is_approved', 1);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.code ASC, t.name ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByPendingApproval() {
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
        $criteria->compare('t.is_approved', 0);
        $criteria->compare('t.date_approval', $this->date_approval);

        $criteria->together = true;
        $criteria->with = array('coaCategory', 'coaSubCategory');
        $criteria->compare('coaCategory.name', $this->coa_category_name, true);
        $criteria->compare('coaSubCategory.name', $this->coa_sub_category_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.code ASC, t.name ASC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchForWorkOrderExpense() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.coa_category_id', 8);
        $criteria->compare('t.coa_sub_category_id', $this->coa_sub_category_id);
        $criteria->compare('normal_balance', $this->normal_balance, true);
        $criteria->compare('opening_balance', $this->opening_balance, true);
        $criteria->compare('closing_balance', $this->closing_balance, true);
        $criteria->compare('debit', $this->debit, true);
        $criteria->compare('credit', $this->credit, true);
        $criteria->compare('t.is_approved', 1);
        $criteria->compare('t.date_approval', $this->date_approval);

        $criteria->together = true;
        $criteria->with = array('coaCategory', 'coaSubCategory');
        $criteria->compare('coaCategory.name', $this->coa_category_name, true);
        $criteria->compare('coaSubCategory.name', $this->coa_sub_category_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.code ASC, t.name ASC',
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
     * @return Coa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCodeNumber($coaSubCategory) {
        $lastCode = Coa::model()->find(array(
            'order' => 'id DESC',
            'condition' => 'coa_sub_category_id = :coa_sub_category_id AND is_approved = 1',
            'params' => array(':coa_sub_category_id' => $coaSubCategory),
        ));

        if (empty($lastCode)) {
            $lastCode = CoaSubCategory::model()->find(array(
                'condition' => 'id = :id',
                'params' => array(':id' => $coaSubCategory),
            ));
        }
        
        list($categoryCode, $subCategoryCode, $currentCode) = explode('.', $lastCode->code);
        
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
                WHERE coa_id = :coa_id AND debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                GROUP BY branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':coa_id' => $this->id));

        return $resultSet;
    }

    public function getTransactionTotalCreditAmount() {
        $sql = "SELECT branch_id, COALESCE(SUM(total), 0) AS total_amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND debet_kredit = 'K' AND is_coa_category = 0  AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
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
                WHERE dc.tanggal_transaksi < :start_date AND is_coa_category = 0 AND dc.coa_id = :coa_id" . $branchConditionSql . " AND dc.debet_kredit = 'D' AND dc.tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'";

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
                WHERE dc.tanggal_transaksi < :start_date AND is_coa_category = 0 AND dc.coa_id = :coa_id" . $branchConditionSql . " AND dc.debet_kredit = 'K' AND dc.tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'";

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
            SELECT IF(a.normal_balance = 'Debit', COALESCE(SUM(j.amount), 0), COALESCE(SUM(j.amount), 0) * -1) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
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
            INNER JOIN " . Account::model()->tableName() . " a ON a.id = j.detail_account_id
            WHERE j.account_id = :account_id AND j.tanggal_transaksi <= :end_date AND j.tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
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
            'condition' => "tanggal_transaksi BETWEEN :startDate AND :endDate AND is_coa_category = 0 AND coa_id = :coa_id" . $branchConditionSql,
            'params' => $params,
        ));

        if ($accountingJournals != null) {
            foreach ($accountingJournals as $accountingJournal) {
                $debitAmount = $accountingJournal->debet_kredit == 'D' ? $accountingJournal->total : 0;
                $creditAmount = $accountingJournal->debet_kredit == 'K' ? $accountingJournal->total : 0;
                if ($this->normal_balance == 'KREDIT' ) {
                    $balanceTotal += $creditAmount - $debitAmount;
                } else if ($this->normal_balance == 'DEBIT') {
                    $balanceTotal += $debitAmount - $creditAmount;
                } else {
                    $balanceTotal = 0.00;
                }
            }
        }
        
        return $balanceTotal;
    }
    
    public function getProfitLossBalance($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT IF(a.normal_balance = 'Debit', COALESCE(SUM(j.amount), 0), COALESCE(SUM(j.amount), 0) * -1) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0
            ) j
            INNER JOIN " . Coa::model()->tableName() . " a ON a.id = j.coa_id
            WHERE j.coa_id = :coa_id AND j.tanggal_transaksi BETWEEN :start_date AND :end_date " . $branchConditionSql .
            " GROUP BY j.coa_id
        ";
        
        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getBalanceSheetBalance($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT SUM(balance_debit) - SUM(balance_credit) AS total_balance
                FROM (
                    SELECT coa_id, SUM(total) AS balance_debit, 0 AS balance_credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND is_coa_category = 0 AND debet_kredit = 'D' AND tanggal_transaksi BETWEEN :start_date AND :end_date " . $branchConditionSql .
                    " GROUP BY coa_id
                    UNION
                    SELECT coa_id, 0 AS balance_debit, SUM(total) AS balance_credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND is_coa_category = 0 AND debet_kredit = 'K' AND tanggal_transaksi BETWEEN :start_date AND :end_date " . $branchConditionSql .
                    " GROUP BY coa_id
                ) transaction
                GROUP BY coa_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType) {
        $branchConditionSql = '';
        $transactionTypeConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($transactionType)) {
            $transactionTypeConditionSql = ' AND transaction_type = :transaction_type';
            $params[':transaction_type'] = $transactionType;
        }
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT COALESCE(SUM(total), 0) AS balance_debit
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi BETWEEN :start_date AND :end_date " . $branchConditionSql . $transactionTypeConditionSql .
                " GROUP BY coa_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType) {
        $branchConditionSql = '';
        $transactionTypeConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($transactionType)) {
            $transactionTypeConditionSql = ' AND transaction_type = :transaction_type';
            $params[':transaction_type'] = $transactionType;
        }
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT COALESCE(SUM(total), 0) AS balance_credit
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE coa_id = :coa_id AND debet_kredit = 'K' AND is_coa_category = 0 AND tanggal_transaksi BETWEEN :start_date AND :end_date " . $branchConditionSql . $transactionTypeConditionSql .
                " GROUP BY coa_id";

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
                WHERE coa_id = :coa_id AND tanggal_transaksi < :start_date AND is_coa_category = 0 
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
            'condition' => "tanggal_transaksi < :transactionDate AND coa_id = :coa_id AND is_coa_category = 0 tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'",
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
                } elseif ($this->coa_category_id == 1 || $this->coa_category_id == 2) {
                    $balanceTotal += $debitAmount - $creditAmount;
                } else {
                    $balanceTotal = 0.00;
                }
            }
        }
        
        return $balanceTotal;
    }
    
    public function getFinancialForecastReport($datePrevious, $dateNow) {
        
        $sql = "SELECT transaction_date, SUM(receivable_debit) AS total_receivable_debit, SUM(payable_credit) AS total_payable_credit, SUM(journal_debit) AS total_journal_debit, SUM(journal_credit) AS total_journal_credit
                FROM (
                    SELECT invoice_number AS transaction_number, payment_date_estimate AS transaction_date, coa_bank_id_estimate AS coa_id, branch_id, total_price AS receivable_debit, 0 AS payable_credit, 0 AS journal_debit, 0 AS journal_credit, payment_left AS remaining
                    FROM " . InvoiceHeader::model()->tableName() . "
                    WHERE payment_date_estimate BETWEEN :payment_date_estimate AND :date_now AND coa_bank_id_estimate = :coa_bank_id_estimate
                    UNION
                    SELECT purchase_order_no AS transaction_number, payment_date_estimate AS transaction_date, coa_bank_id_estimate AS coa_id, main_branch_id AS branch_id, 0 AS receivable_debit, total_price AS payable_credit, 0 AS journal_debit, 0 AS journal_credit, payment_left AS remaining
                    FROM " . TransactionPurchaseOrder::model()->tableName() . "
                    WHERE payment_date_estimate BETWEEN :payment_date_estimate AND :date_now AND coa_bank_id_estimate = :coa_bank_id_estimate
                    UNION
                    SELECT kode_transaksi AS transaction_number, tanggal_transaksi AS transaction_date, coa_id, branch_id, 0 AS receivable_debit, 0 AS payable_credit, total AS journal_debit, 0 AS journal_credit, 1 AS remaining
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE debet_kredit = 'D' AND tanggal_transaksi BETWEEN :payment_date_estimate AND :date_now AND coa_id = :coa_bank_id_estimate AND is_coa_category = 0 
                    UNION
                    SELECT kode_transaksi AS transaction_number, tanggal_transaksi AS transaction_date, coa_id, branch_id, 0 AS receivable_debit, 0 AS payable_credit, 0 AS journal_debit, total AS journal_credit, 1 AS remaining
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE debet_kredit = 'K' AND tanggal_transaksi BETWEEN :payment_date_estimate AND :date_now AND coa_id = :coa_bank_id_estimate AND is_coa_category = 0 
                ) transaction
                WHERE remaining > 0
                GROUP BY transaction_date
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':date_now' => $dateNow,
            ':payment_date_estimate' => $datePrevious,
            ':coa_bank_id_estimate' => $this->id,
//            ':branch_id' => $branchId,
        ));
        
        return $resultSet;
    }
    
    public function getFinancialForecastDetails($transactionDate) {
        
        $sql = "SELECT transaction_number, transaction_date, coa_id, branch_id, journal_debit, journal_credit
                FROM (
                    SELECT kode_transaksi AS transaction_number, tanggal_transaksi AS transaction_date, coa_id, branch_id, total AS journal_debit, 0 AS journal_credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE debet_kredit = 'D' AND tanggal_transaksi = :transaction_date AND coa_id = :coa_id AND is_coa_category = 0 
                    UNION
                    SELECT kode_transaksi AS transaction_number, tanggal_transaksi AS transaction_date, coa_id, branch_id, 0 AS journal_debit, total AS journal_credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE debet_kredit = 'K' AND tanggal_transaksi = :transaction_date AND coa_id = :coa_id AND is_coa_category = 0 
                ) transaction
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':transaction_date' => $transactionDate,
            ':coa_id' => $this->id,
        ));
        
        return $resultSet;
    }
    
//    public function searchByReceivable() {
//        // @todo Please modify the following code to remove attributes that should not be searched.
//
//        $criteria = new CDbCriteria;
//
//        $criteria->addCondition("EXISTS (
//            SELECT COALESCE(SUM(j.amount), 0) AS beginning_balance 
//            FROM (
//                SELECT coa_id, tanggal_transaksi, total AS amount
//                FROM " . JurnalUmum::model()->tableName() . "
//                WHERE debet_kredit = 'D' AND is_coa_category = 0 
//                UNION ALL
//                SELECT coa_id, tanggal_transaksi, total * -1 AS amount
//                FROM " . JurnalUmum::model()->tableName() . "
//                WHERE debet_kredit = 'K' AND is_coa_category = 0 
//            ) j
//            WHERE t.id = j.coa_id
//            GROUP BY j.coa_id
//            HAVING beginning_balance > 0
//        )");
//        
//        $criteria->compare('t.id', $this->id);
//        $criteria->compare('t.name', $this->name, true);
//        $criteria->compare('t.code', $this->code, true);
//        $criteria->compare('t.coa_category_id', $this->coa_category_id);
//        $criteria->compare('t.coa_sub_category_id', $this->coa_sub_category_id);
//        $criteria->compare('normal_balance', $this->normal_balance, true);
//        $criteria->compare('opening_balance', $this->opening_balance, true);
//        $criteria->compare('closing_balance', $this->closing_balance, true);
//        $criteria->compare('debit', $this->debit, true);
//        $criteria->compare('credit', $this->credit, true);
//        $criteria->compare('t.is_approved', 1);
//        $criteria->compare('t.date_approval', $this->date_approval);
//        $criteria->compare('t.user_id', $this->user_id);
//
//        return new CActiveDataProvider($this, array(
//            'criteria' => $criteria,
//            'sort' => array(
//                'defaultOrder' => 't.code ASC',
//            ),
//        ));
//    }

    public function getReceivableAmount() {
        $params = array(
            ':coa_id' => $this->id,
        );
        
        $sql = "SELECT SUM(j.debet) - SUM(j.credit) as balance
                FROM (
                    SELECT coa_id, SUM(total) as debet, 0 AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND debet_kredit = 'D' AND transaction_type IN ('SO', 'Pin', 'RG') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                    UNION
                    SELECT coa_id, 0 as debet, SUM(total) AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND debet_kredit = 'K' AND transaction_type IN ('SO', 'Pin', 'RG') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                ) j
                GROUP BY j.coa_id
                HAVING balance <> 0.00";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
        
    }
    
    public function getBeginningBalanceReceivable($startDate) {
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
        );
        
        $sql = "SELECT SUM(j.debet) - SUM(j.credit) as balance
                FROM (
                    SELECT coa_id, SUM(total) as debet, 0 AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND tanggal_transaksi < :start_date AND debet_kredit = 'D' AND transaction_type IN ('SO', 'Pin', 'RG') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                    UNION
                    SELECT coa_id, 0 as debet, SUM(total) AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND tanggal_transaksi < :start_date AND debet_kredit = 'K' AND transaction_type IN ('SO', 'Pin', 'RG') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                ) j
                GROUP BY j.coa_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
        
    }
    
    public function getReceivableLedgerReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT kode_transaksi, tanggal_transaksi, transaction_type, remark, amount, sale_amount, payment_amount, customer
                FROM (
                    SELECT j.coa_id, SUM(total) AS amount, SUM(total) AS sale_amount, 0 AS payment_amount, kode_transaksi, tanggal_transaksi, debet_kredit AS transaction_type, transaction_subject AS remark, c.name AS customer
                    FROM " . JurnalUmum::model()->tableName() . " j
                    INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                    WHERE j.coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND is_coa_category = 0 AND debet_kredit = 'D'" . $branchConditionSql .
                    " GROUP BY j.coa_id, kode_transaksi, tanggal_transaksi, debet_kredit, transaction_subject, c.name
                    UNION
                    SELECT j.coa_id, SUM(total) AS amount, 0 AS sale_amount, SUM(total) AS payment_amount, kode_transaksi, tanggal_transaksi, debet_kredit AS transaction_type, transaction_subject AS remark, c.name AS customer
                    FROM " . JurnalUmum::model()->tableName() . " j
                    INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                    WHERE j.coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND is_coa_category = 0 AND debet_kredit = 'K'" . $branchConditionSql .
                    " GROUP BY j.coa_id, kode_transaksi, tanggal_transaksi, debet_kredit, transaction_subject, c.name
                ) t
                ORDER BY tanggal_transaksi ASC, kode_transaksi ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getBeginningBalanceReceivableDetail() {
        $sql = "
            SELECT COALESCE(SUM(j.amount), 0) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
            ) j
            WHERE j.coa_id = :account_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':account_id' => $this->id,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getReceivableDetailReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT coa_id, total AS amount, kode_transaksi, tanggal_transaksi, debet_kredit AS transaction_type, transaction_subject AS remark
                FROM " . JurnalUmum::model()->tableName() . " 
                WHERE coa_id = :coa_id AND tanggal_transaksi BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . " ' AND :end_date AND is_coa_category = 0" . $branchConditionSql . " 
                ORDER BY tanggal_transaksi ASC, kode_transaksi ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getPayableDetailReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT coa_id, total AS amount, kode_transaksi, tanggal_transaksi, debet_kredit AS transaction_type, transaction_subject AS remark
                FROM " . JurnalUmum::model()->tableName() . " 
                WHERE coa_id = :coa_id AND tanggal_transaksi BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . " ' AND :end_date AND is_coa_category = 0" . $branchConditionSql . " 
                ORDER BY tanggal_transaksi ASC, kode_transaksi ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getPayableAmount() {
        $params = array(
            ':coa_id' => $this->id,
        );
        
        $sql = "SELECT SUM(j.debet) - SUM(j.credit) as balance
                FROM (
                    SELECT coa_id, SUM(total) as debet, 0 AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND debet_kredit = 'D' AND transaction_type IN ('CASH', 'DO', 'MO', 'PO', 'Pout', 'RCI', 'RTO', 'WOE') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                    UNION
                    SELECT coa_id, 0 as debet, SUM(total) AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND debet_kredit = 'K' AND transaction_type IN ('CASH', 'DO', 'MO', 'PO', 'Pout', 'RCI', 'RTO', 'WOE') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                ) j
                GROUP BY j.coa_id
                HAVING balance <> 0.00";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
        
    }
    
    public function getBeginningBalancePayable($startDate) {
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
        );
        
        $sql = "SELECT SUM(j.debet) - SUM(j.credit) as balance
                FROM (
                    SELECT coa_id, SUM(total) as debet, 0 AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND tanggal_transaksi < :start_date AND debet_kredit = 'D' AND transaction_type IN ('CASH', 'DO', 'MO', 'PO', 'Pout', 'RCI', 'RTO', 'WOE') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                    UNION
                    SELECT coa_id, 0 as debet, SUM(total) AS credit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE coa_id = :coa_id AND tanggal_transaksi < :start_date AND debet_kredit = 'K' AND transaction_type IN ('CASH', 'DO', 'MO', 'PO', 'Pout', 'RCI', 'RTO', 'WOE') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                    GROUP BY coa_id
                ) j
                GROUP BY j.coa_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
        
    }
    
    public function getPayableLedgerReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT kode_transaksi, tanggal_transaksi, transaction_type, remark, amount, purchase_amount, payment_amount, supplier
                FROM (
                    SELECT j.coa_id, SUM(total) AS amount, SUM(total) AS purchase_amount, 0 AS payment_amount, kode_transaksi, tanggal_transaksi, debet_kredit AS transaction_type, transaction_subject AS remark, c.name AS supplier
                    FROM " . JurnalUmum::model()->tableName() . " j
                    INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                    WHERE j.coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND is_coa_category = 0 AND debet_kredit = 'D'" . $branchConditionSql .
                    " GROUP BY j.coa_id, kode_transaksi, tanggal_transaksi, debet_kredit, transaction_subject, c.name
                    UNION
                    SELECT j.coa_id, SUM(total) AS amount, 0 AS purchase_amount, SUM(total) AS payment_amount, kode_transaksi, tanggal_transaksi, debet_kredit AS transaction_type, transaction_subject AS remark, c.name AS supplier
                    FROM " . JurnalUmum::model()->tableName() . " j
                    INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                    WHERE j.coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND is_coa_category = 0 AND debet_kredit = 'K'" . $branchConditionSql .
                    " GROUP BY j.coa_id, kode_transaksi, tanggal_transaksi, debet_kredit, transaction_subject, c.name
                ) t
                ORDER BY tanggal_transaksi ASC, kode_transaksi ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getCodeName() {
        return $this->code . ' - ' . $this->name;
    }
    
    public function getCombinationName() {
        return $this->code . ' - ' . $this->name . ' - ' . $this->coaCategory->name . ' - ' . $this->coaSubCategory->name;
    }
    
    public function getCreatedDatetime() {
        return $this->date . " " . $this->time_created;
    }
    
    public function getApprovedDatetime() {
        return $this->date_approval . " " . $this->time_approval;
    }
    
    public function getGeneralLedgerReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT kode_transaksi, tanggal_transaksi, transaction_subject, transaction_type, total, debet_kredit
            FROM " . JurnalUmum::model()->tableName() . " 
            WHERE coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date" . $branchConditionSql . "
            ORDER BY tanggal_transaksi, kode_transaksi
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getReceivableInvoiceReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT j.id, j.coa_id, j.tanggal_transaksi, j.kode_transaksi, j.remark, CASE WHEN j.debet_kredit = 'D' THEN total ELSE 0 END AS debit, 
                CASE WHEN j.debet_kredit = 'K' THEN total ELSE 0 END AS credit
            FROM " . JurnalUmum::model()->tableName() . " j
            WHERE j.coa_id = :coa_id AND j.tanggal_transaksi BETWEEN '2025-01-01' AND :end_date " . $branchConditionSql . "
            ORDER BY j.tanggal_transaksi ASC, j.id ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }

    public function getReceivableReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':coa_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT i.invoice_number, i.invoice_date, due_date, c.name as customer_name, COALESCE(i.total_price, 0) AS total_price, COALESCE(p.amount, 0) + 
                COALESCE(p.tax_service_amount, 0) + COALESCE(p.discount_amount, 0) + COALESCE(p.bank_administration_fee, 0) + COALESCE(p.merimen_fee, 0) + 
                COALESCE(p.downpayment_amount, 0) AS amount, i.total_price - COALESCE(p.amount, 0) - COALESCE(p.tax_service_amount, 0) - 
                COALESCE(p.discount_amount, 0) - COALESCE(p.bank_administration_fee, 0) - COALESCE(p.merimen_fee, 0) - COALESCE(p.downpayment_amount, 0) AS remaining
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            LEFT OUTER JOIN (
                SELECT d.invoice_header_id, SUM(d.amount) AS amount, SUM(d.tax_service_amount) AS tax_service_amount, SUM(d.discount_amount) AS discount_amount,
                    SUM(d.bank_administration_fee) AS bank_administration_fee, SUM(d.merimen_fee) AS merimen_fee, SUM(d.downpayment_amount) AS downpayment_amount
                FROM " . PaymentInDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.invoice_header_id
            ) p ON i.id = p.invoice_header_id 
            WHERE c.coa_id = :coa_id AND i.insurance_company_id IS NULL AND (i.total_price - COALESCE(p.amount, 0) - COALESCE(p.tax_service_amount, 0) - 
                COALESCE(p.discount_amount, 0) - COALESCE(p.bank_administration_fee, 0) - COALESCE(p.merimen_fee, 0) - COALESCE(p.downpayment_amount, 0)) > 100.00 
                AND i.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date" . $branchConditionSql;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
