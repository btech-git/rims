<?php

/**
 * This is the model class for table "{{jurnal_umum}}".
 *
 * The followings are the available columns in table '{{jurnal_umum}}':
 * @property integer $id
 * @property string $kode_transaksi
 * @property string $tanggal_transaksi
 * @property integer $coa_id
 * @property integer $branch_id
 * @property string $total
 * @property string $debet_kredit
 * @property string $tanggal_posting
 * @property string $transaction_subject
 * @property string $transaction_type
 * @property string $remark
 * @property integer $is_coa_category
 *
 * The followings are the available model relations:
 * @property Coa $coa
 * @property Branch $branch
 */
class JurnalUmum extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $nama_bulan;
    public $bulan;
    public $tanggal_mulai;
    public $tanggal_sampai;
    public $currentSaldo;

    public function tableName() {
        return '{{jurnal_umum}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode_transaksi, tanggal_transaksi, coa_id, total, debet_kredit, tanggal_posting, branch_id', 'required'),
            array('coa_id, branch_id, is_coa_category', 'numerical', 'integerOnly' => true),
            array('kode_transaksi', 'length', 'max' => 30),
            array('remark', 'length', 'max' => 100),
            array('transaction_subject', 'length', 'max' => 200),
            array('transaction_type', 'length', 'max' => 20),
            array('total', 'length', 'max' => 18),
            array('debet_kredit', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode_transaksi, tanggal_transaksi, coa_id, total, debet_kredit, tanggal_posting, branch_id, tanggal_mulai, tanggal_sampai, transaction_subject, is_coa_category, transaction_type, remark', 'safe', 'on' => 'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode_transaksi' => 'Kode Transaksi',
            'tanggal_transaksi' => 'Tanggal Transaksi',
            'coa_id' => 'Coa',
            'branch_id' => 'Branch',
            'total' => 'Total',
            'debet_kredit' => 'Debet Kredit',
            'tanggal_posting' => 'Tanggal Posting',
            'transaction_type' => 'Type',
            'remark' => 'Remark',
        );
    }

    public function behaviors() {
        return array(
            'dateRangeSearch' => array(
                'class' => 'application.components.behaviors.EDateRangeSearchBehavior',
            ),
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        
        $criteria->compare('id', $this->id);
        $criteria->compare('kode_transaksi', $this->kode_transaksi, true);
        $criteria->compare('tanggal_transaksi', $this->tanggal_transaksi, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('debet_kredit', $this->debet_kredit, true);
        $criteria->compare('tanggal_posting', $this->tanggal_posting, true);
        $criteria->compare('transaction_subject', $this->transaction_subject, true);
        $criteria->compare('transaction_type', $this->transaction_type);
        $criteria->compare('is_coa_category', $this->is_coa_category);
        $criteria->compare('remark', $this->remark, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByTransactionJournal() {

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('kode_transaksi', $this->kode_transaksi, true);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('debet_kredit', $this->debet_kredit, true);
        $criteria->compare('tanggal_posting', $this->tanggal_posting, true);
        $criteria->compare('transaction_subject', $this->transaction_subject, true);
        $criteria->compare('transaction_type', $this->transaction_type);
        $criteria->compare('is_coa_category', $this->is_coa_category);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
            ),
        ));
    }

    public function searchByDailyCashReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('kode_transaksi', $this->kode_transaksi, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('debet_kredit', $this->debet_kredit, true);
        $criteria->compare('tanggal_posting', $this->tanggal_posting, true);
        $criteria->compare('transaction_subject', $this->transaction_subject, true);
        $criteria->compare('transaction_type', $this->transaction_type);

        $criteria->addCondition("t. is_coa_category = 0 AND t.transaction_type = 'JP' AND t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getBranchAccountId() {
        return $this->branch_id . '.' . $this->coa_id;
    }

    public function getBranchAccountCode() {
        $branch = empty($this->branch_id) ? '' : $this->branch;
        $coa = empty($this->coa_id) ? '' : $this->coa;

        return $branch->coa_prefix . '.' . $coa->code;
    }

    public function getBranchAccountName() {
        $branch = empty($this->branch_id) ? '' : $this->branch;
        $coa = empty($this->coa_id) ? '' : $this->coa;

        return $branch->code . '.' . $coa->name;
    }

    public function getSubTotalDebit($transactionNumber) {
        $sql = "SELECT COALESCE(SUM(total), 0) AS sub_total 
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE kode_transaksi = :kode_transaksi AND debet_kredit = 'D' AND is_coa_category = 0";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':kode_transaksi' => $transactionNumber,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getSubTotalKredit($transactionNumber) {
        $sql = "SELECT COALESCE(SUM(total), 0) AS sub_total 
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE kode_transaksi = :kode_transaksi AND debet_kredit = 'K' AND is_coa_category = 0";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':kode_transaksi' => $transactionNumber,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function searchByReceivable() {
        
        $criteria = new CDbCriteria;

        $criteria->addCondition("EXISTS (
            SELECT COALESCE(SUM(j.amount), 0) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0 
            ) j
            WHERE t.coa_id = j.coa_id
            GROUP BY j.coa_id
            HAVING beginning_balance > 0
        )");
        
        $criteria->compare('id', $this->id);
        $criteria->compare('kode_transaksi', $this->kode_transaksi, true);
        $criteria->compare('tanggal_transaksi', $this->tanggal_transaksi, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('debet_kredit', $this->debet_kredit, true);
        $criteria->compare('tanggal_posting', $this->tanggal_posting, true);
        $criteria->compare('transaction_subject', $this->transaction_subject, true);
        $criteria->compare('transaction_type', $this->transaction_type);
        $criteria->compare('is_coa_category', $this->is_coa_category);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public static function getLedgerBeginningBalances($coaIds, $startDate, $branchId) {
        $inIdsSql = 'NULL';
        if (!empty($coaIds)) {
            $inIdsSql = implode(',', $coaIds);
        }
        
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT j.coa_id, IF(a.normal_balance = 'Debit', COALESCE(SUM(j.amount), 0), COALESCE(SUM(j.amount), 0) * -1) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0 AND tanggal_transaksi >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
            ) j
            INNER JOIN " . Coa::model()->tableName() . " a ON a.id = j.coa_id
            WHERE j.coa_id IN ({$inIdsSql}) AND j.tanggal_transaksi <= :start_date " . $branchConditionSql . " 
            GROUP BY j.coa_id
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getGeneralLedgerReport($coaIds, $startDate, $endDate, $branchId) {
        $inIdsSql = 'NULL';
        if (!empty($coaIds)) {
            $inIdsSql = implode(',', $coaIds);
        }
        
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT coa_id, kode_transaksi, tanggal_transaksi, transaction_subject, transaction_type, total, debet_kredit
            FROM " . JurnalUmum::model()->tableName() . " 
            WHERE coa_id IN ({$inIdsSql}) AND tanggal_transaksi BETWEEN :start_date AND :end_date" . $branchConditionSql . "
            ORDER BY coa_id, tanggal_transaksi, kode_transaksi
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getTransactionJournalBalances($coaIds, $startDate, $endDate, $branchId) {
        $inIdsSql = 'NULL';
        if (!empty($coaIds)) {
            $inIdsSql = implode(',', $coaIds);
        }
        
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT j.coa_id, IF(a.normal_balance = 'Debit', COALESCE(SUM(j.amount), 0), COALESCE(SUM(j.amount), 0) * -1) AS beginning_balance 
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS debit, 0 AS credit, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                UNION ALL
                SELECT coa_id, tanggal_transaksi, 0 AS debit, total AS credit, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0 AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
            ) j
            INNER JOIN " . Coa::model()->tableName() . " a ON a.id = j.coa_id
            WHERE j.coa_id IN ({$inIdsSql}) AND j.tanggal_transaksi < :start_date " . $branchConditionSql . " 
            GROUP BY j.coa_id
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }

    public static function getTransactionJournalData($startDate, $endDate, $branchId, $transactionType, $remark) {
        $branchConditionSql = '';
        $remarkConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':transaction_type' => $transactionType,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if ($remark !== '') {
            $remarkConditionSql = ' AND j.remark = :remark';
            $params[':remark'] = $remark;
        }
        
        $sql = "SELECT j.coa_id AS coa_id, c.code AS coa_code, c.name AS coa_name, SUM(IF(j.debet_kredit = 'D', j.total, 0)) AS debit, 
                    SUM(IF(j.debet_kredit = 'K', j.total, 0)) AS credit
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Coa::model()->tableName() . " c on c.id = j.coa_id
                WHERE j.coa_id NOT IN (
                    SELECT c1.id 
                    FROM " . Coa::model()->tableName() . " c1
                    WHERE EXISTS (
                        SELECT c1.id 
                        FROM " . Coa::model()->tableName() . " c2
                        WHERE c1.id = c2.coa_id
                    )
                ) AND j.tanggal_transaksi BETWEEN :start_date AND :end_date AND j.transaction_type = :transaction_type AND j.is_coa_category = 0 " . 
                    $branchConditionSql . $remarkConditionSql . "
                GROUP BY j.coa_id
                ORDER BY c.code ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getBeginningBalanceDataByTransactionYear($startYearMonth, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_year_month' => $startYearMonth,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT j.coa_id, COALESCE(SUM(
                    CASE c.normal_balance
                        WHEN 'DEBIT' THEN CASE j.debet_kredit WHEN 'D' THEN +j.total WHEN 'K' THEN -j.total ELSE 0 END
                        WHEN 'KREDIT' THEN CASE j.debet_kredit WHEN 'K' THEN +j.total WHEN 'D' THEN -j.total ELSE 0 END
                        ELSE 0
                    END
                ), 0) AS total
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                WHERE SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) < :start_year_month AND c.coa_category_id IN (4, 5, 14, 15, 16, 17, 18, 19, 20, 21, 23) AND c.is_approved = 1" . $branchConditionSql . "
                GROUP BY j.coa_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getBalanceSheetDataByTransactionYear($startYearMonth, $endYearMonth, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_year_month' => $startYearMonth,
            ':end_year_month' => $endYearMonth,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) AS transaction_month_year, j.coa_id, j.debet_kredit, cc.id AS category_id, 
                    cc.code AS category_code, cc.name AS category_name, s.id AS sub_category_id, s.code AS sub_category_code, s.name AS sub_category_name, 
                    c.code AS coa_code, c.name AS coa_name, c.normal_balance, SUM(j.total) AS total
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                INNER JOIN " . CoaSubCategory::model()->tableName() . " s ON s.id = c.coa_sub_category_id
                INNER JOIN " . CoaCategory::model()->tableName() . " cc ON cc.id = s.coa_category_id
                WHERE SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) BETWEEN :start_year_month AND :end_year_month AND c.is_approved = 1 AND 
                    c.coa_category_id IN (4, 5, 14, 15, 16, 17, 18, 19, 20, 21, 23)" . $branchConditionSql . "
                GROUP BY SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2), j.coa_id, j.debet_kredit
                ORDER BY cc.`code`, s.`code` ASC, c.`code` ASC, transaction_month_year ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getProfitLossDataByTransactionYear($startYearMonth, $endYearMonth, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_year_month' => $startYearMonth,
            ':end_year_month' => $endYearMonth,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) AS transaction_month_year, j.coa_id, j.debet_kredit, cc.id AS category_id, cc.`code` AS category_code, cc.`name` AS category_name, s.id AS sub_category_id, s.`code` AS sub_category_code, s.`name` AS sub_category_name, c.`code` AS coa_code, c.`name` AS coa_name, c.normal_balance, SUM(j.total) AS total
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                INNER JOIN " . CoaSubCategory::model()->tableName() . " s ON s.id = c.coa_sub_category_id
                INNER JOIN " . CoaCategory::model()->tableName() . " cc ON cc.id = s.coa_category_id
                WHERE SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) BETWEEN :start_year_month AND :end_year_month AND c.coa_category_id IN (6, 7, 8, 9, 10) AND c.is_approved = 1 " . $branchConditionSql . "
                GROUP BY SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2), j.coa_id, j.debet_kredit
                ORDER BY cc.`code`, s.`code` ASC, c.`code` ASC, transaction_month_year ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getTransactionJournalReport($startDate, $endDate, $transactionType, $branchId, $coaId, $currentPage, $pageSize) {
        
        $pageOffset = ($currentPage - 1) * $pageSize;
        $transactionTypeConditionSql = '';
        $branchConditionSql = '';
        $coaConditionSql = '';
        
        $params = array(
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
        
        if (!empty($coaId)) {
            $coaConditionSql = ' AND coa_id = :coa_id';
            $params[':coa_id'] = $coaId;
        }
        
        $sql = "SELECT kode_transaksi, MIN(tanggal_transaksi) AS transaction_date, MIN(transaction_subject) AS transaction_subject
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE tanggal_transaksi BETWEEN :start_date AND :end_date" . $transactionTypeConditionSql . $branchConditionSql . $coaConditionSql ."
                GROUP BY kode_transaksi
                ORDER BY transaction_date ASC
                LIMIT {$pageOffset}, {$pageSize}";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getBalanceErrorReport() {
        
        $sql = "SELECT kode_transaksi, MAX(tanggal_transaksi) as transaction_date, SUM(CASE WHEN debet_kredit = 'D' THEN total ELSE 0 END) AS debit, 
                    SUM(CASE WHEN debet_kredit = 'K' THEN total ELSE 0 END) AS credit
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE tanggal_transaksi BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY kode_transaksi
                HAVING debit <> credit
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':end_date' => date('Y-m-d')));

        return $resultSet;
    }

        public static function getTransactionJournalCount($startDate, $endDate, $transactionType, $branchId, $coaId) {
        
        $transactionTypeConditionSql = '';
        $branchConditionSql = '';
        $coaConditionSql = '';
        
        $params = array(
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
        
        if (!empty($coaId)) {
            $coaConditionSql = ' AND coa_id = :coa_id';
            $params[':coa_id'] = $coaId;
        }
        
        $sql = "SELECT COUNT(DISTINCT kode_transaksi) AS transaction_item_count
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE tanggal_transaksi BETWEEN :start_date AND :end_date" . $transactionTypeConditionSql . $branchConditionSql . $coaConditionSql;
        
        $count = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return $count;
    }

    public static function getPaymentInByBankList($month, $year, $branchId, $coaIds) {
        $branchConditionSql = '';
        $coaInSql = '= NULL';
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        if (!empty($branchId)) {
            $branchConditionSql = " AND pi.branch_id = :branch_id";
            $params[':branch_id'] = $branchId;
        }
        if (!empty($coaIds)) {
            $coaInSql = "IN (" . implode(',', $coaIds) . ")";
        }
        
        $sql = "SELECT pi.tanggal_transaksi, pi.coa_id, MIN(pt.name) AS coa_name, COALESCE(SUM(pi.total), 0) AS total_amount
                FROM " . JurnalUmum::model()->tableName() . " pi
                INNER JOIN " . Coa::model()->tableName() . " pt ON pt.id = pi.coa_id
                WHERE pi.coa_id " . $coaInSql . " AND YEAR(tanggal_transaksi) = :year AND MONTH(tanggal_transaksi) = :month AND pi.transaction_type = 'Pin' AND
                    pi.is_coa_category = 0 AND pt.coa_sub_category_id IN (1, 2, 3) AND pt.status = 'Approved' AND pi.debet_kredit = 'D'" . $branchConditionSql . "
                GROUP BY pi.tanggal_transaksi, pi.coa_id
                ORDER BY pi.tanggal_transaksi";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getPaymentOutByBankList($month, $year, $branchId, $coaIds) {
        $branchConditionSql = '';
        $coaOutSql = '= NULL';
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        if (!empty($branchId)) {
            $branchConditionSql = " AND pi.branch_id = :branch_id";
            $params[':branch_id'] = $branchId;
        }
        if (!empty($coaIds)) {
            $coaOutSql = "IN (" . implode(',', $coaIds) . ")";
        }
        
        $sql = "SELECT pi.tanggal_transaksi, pi.coa_id, MIN(pt.name) AS coa_name, COALESCE(SUM(pi.total), 0) AS total_amount
                FROM " . JurnalUmum::model()->tableName() . " pi
                INNER JOIN " . Coa::model()->tableName() . " pt ON pt.id = pi.coa_id
                WHERE pi.coa_id " . $coaOutSql . " AND YEAR(tanggal_transaksi) = :year AND MONTH(tanggal_transaksi) = :month AND pi.transaction_type = 'Pout' AND 
                    pi.is_coa_category = 0 AND pt.coa_sub_category_id IN (1, 2, 3) AND pt.status = 'Approved' AND pi.debet_kredit = 'K'" . $branchConditionSql . "
                GROUP BY pi.tanggal_transaksi, pi.coa_id
                ORDER BY pi.tanggal_transaksi";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function graphSalePerBranch() {
        
        $sql = "SELECT b.code AS branch_name, SUM(j.total) AS total
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = j.branch_id
                WHERE j.transaction_type IN ('Invoice') AND tanggal_transaksi > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                GROUP BY j.branch_id";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
    
    public static function graphIncomeExpense() {
        
        $sql = "SELECT year, month, SUM(total_debit) as debit, SUM(total_kredit) as kredit
                FROM  (
                    SELECT SUBSTRING(tanggal_transaksi, 1, 4) AS year, SUBSTRING(tanggal_transaksi, 6, 2) AS month, SUM(total) AS total_debit, 0 AS total_kredit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(tanggal_transaksi, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(tanggal_transaksi, 6, 2)) <= 12 AND 
                        transaction_type IN ('Pin', 'CASH') AND debet_kredit = 'D'
                    GROUP BY SUBSTRING(tanggal_transaksi, 1, 4), SUBSTRING(tanggal_transaksi, 6, 2)
                    UNION
                    SELECT SUBSTRING(tanggal_transaksi, 1, 4) AS year, SUBSTRING(tanggal_transaksi, 6, 2) AS month, 0 AS total_debit, SUM(total) AS total_kredit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(tanggal_transaksi, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(tanggal_transaksi, 6, 2)) <= 12 AND 
                        transaction_type IN ('Pout', 'CASH') AND debet_kredit = 'K'
                    GROUP BY SUBSTRING(tanggal_transaksi, 1, 4), SUBSTRING(tanggal_transaksi, 6, 2)
                ) transaction
                GROUP BY year, month";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
    
    public static function getMonthlyRunningBalanceReport($endYear, $coaSubCategoryId) {
        
        $sql = "SELECT j.coa_id, YEAR(j.tanggal_transaksi) AS year, MONTH(j.tanggal_transaksi) AS month, MAX(c.name) AS coa_name, COALESCE(SUM(
                    CASE c.normal_balance
                        WHEN 'DEBIT' THEN CASE j.debet_kredit WHEN 'D' THEN +j.total WHEN 'K' THEN -j.total ELSE 0 END
                        WHEN 'KREDIT' THEN CASE j.debet_kredit WHEN 'K' THEN +j.total WHEN 'D' THEN -j.total ELSE 0 END
                        ELSE 0
                    END
                ), 0) AS total
                FROM " . JurnalUmum::model()->tableName() . " j 
                INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                WHERE YEAR(j.tanggal_transaksi) BETWEEN 2024 AND :end_year AND c.coa_sub_category_id = :coa_sub_category_id
                GROUP BY j.coa_id, YEAR(j.tanggal_transaksi), MONTH(j.tanggal_transaksi)
                ORDER BY j.coa_id ASC, year ASC, month ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':end_year' => $endYear,
            ':coa_sub_category_id' => $coaSubCategoryId,
        ));
        
        return $resultSet;
    } 

    public function searchByTransactionInfo($coaId, $debitCredit, $transactionType, $date, $page) {
        $criteria = new CDbCriteria;

        $criteria->compare('t.coa_id', $coaId);
        $criteria->compare('t.is_coa_category', 0);
        $criteria->compare('t.debet_kredit', $debitCredit);
        $criteria->compare('t.tanggal_transaksi', $date);
        $criteria->compare('t.transaction_type', $transactionType);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.tanggal_transaksi ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
                'currentPage' => $page - 1,
            ),
        ));
    }
    
    public function searchByYearlyCustomerReceivableInfo($coaId, $year, $month) {

        $criteria = new CDbCriteria;

        $criteria->addCondition("t.coa_id = :coa_id AND MONTH(t.tanggal_transaksi) = :transaction_month AND YEAR(t.tanggal_transaksi) = :transaction_year");
        $criteria->params = array(':transaction_month' => $month, ':transaction_year' => $year, ':coa_id' => $coaId);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.tanggal_transaksi ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public static function getYearlyCustomerReceivableBeginningBalance($coaId, $year, $month) {
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
            WHERE j.coa_id = :coa_id AND j.tanggal_transaksi < :tanggal_transaksi AND j.tanggal_transaksi >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
            GROUP BY j.coa_id
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':coa_id' => $coaId,
            ':tanggal_transaksi' => $year . '-' . $month .'-01',
        ));

        return ($value === false) ? 0 : $value;
    }

    public function searchByYearlyInsuranceReceivableInfo($coaId, $year, $month) {

        $criteria = new CDbCriteria;

        $criteria->addCondition("t.coa_id = :coa_id AND MONTH(t.tanggal_transaksi) = :transaction_month AND YEAR(t.tanggal_transaksi) = :transaction_year");
        $criteria->params = array(':transaction_month' => $month, ':transaction_year' => $year, ':coa_id' => $coaId);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.tanggal_transaksi ASC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public static function getYearlyInsuranceReceivableBeginningBalance($coaId, $year, $month) {
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
            WHERE j.coa_id = :coa_id AND j.tanggal_transaksi < :tanggal_transaksi AND j.tanggal_transaksi >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
            GROUP BY j.coa_id
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':coa_id' => $coaId,
            ':tanggal_transaksi' => $year . '-' . $month .'-01',
        ));

        return ($value === false) ? 0 : $value;
    }
}
