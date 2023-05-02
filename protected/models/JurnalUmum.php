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
            array('transaction_subject', 'length', 'max' => 100),
            array('transaction_type', 'length', 'max' => 20),
            array('total', 'length', 'max' => 18),
            array('debet_kredit', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode_transaksi, tanggal_transaksi, coa_id, total, debet_kredit, tanggal_posting, branch_id, tanggal_mulai, tanggal_sampai, transaction_subject, is_coa_category, transaction_type', 'safe', 'on' => 'search'),
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
            'transaction_type' => 'Type'
        );
    }

    public function behaviors() {
        return array(
            'dateRangeSearch' => array(
                'class' => 'application.components.behaviors.EDateRangeSearchBehavior',
            ),
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
        // $arrayTransactionDate = array($this->tanggal_transaksi_from,$this->tanggal_transaksi_to);
        // // var_dump($this->transaction_date);
        // $criteria->mergeWith($this->dateRangeSearchCriteria('tanggal_transaksi', $arrayTransactionDate)); 
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
            'pagination' => array(
                'pageSize' => 50,
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JurnalUmum the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getBranchAccountId() {
        return $this->branch_id . '.' . $this->coa_id;
    }

    public function getBranchAccountCode() {
        $branch = empty($this->branch) ? '' : $this->branch;
        $coa = empty($this->coa) ? '' : $this->coa;

        return $branch->coa_prefix . '.' . $coa->code;
    }

    public function getBranchAccountName() {
        $branch = empty($this->branch) ? '' : $this->branch;
        $coa = empty($this->coa) ? '' : $this->coa;

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
        // @todo Please modify the following code to remove attributes that should not be searched.

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
        
        $sql = "SELECT SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) AS transaction_month_year, j.coa_id, j.debet_kredit, cc.id AS category_id, cc.`code` AS category_code, cc.`name` AS category_name, s.id AS sub_category_id, s.`code` AS sub_category_code, s.`name` AS sub_category_name, c.`code` AS coa_code, c.`name` AS coa_name, c.normal_balance, SUM(j.total) AS total
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Coa::model()->tableName() . " c ON c.id = j.coa_id
                INNER JOIN " . CoaSubCategory::model()->tableName() . " s ON s.id = c.coa_sub_category_id
                INNER JOIN " . CoaCategory::model()->tableName() . " cc ON cc.id = s.coa_category_id
                WHERE SUBSTRING_INDEX(j.tanggal_transaksi, '-', 2) BETWEEN :start_year_month AND :end_year_month AND c.coa_category_id IN (1, 2, 3, 4, 5, 23) AND c.is_approved = 1 " . $branchConditionSql . "
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
    
    public static function graphSalePerBranch() {
        
        $sql = "SELECT b.name AS branch_name, SUM(j.total) AS total
                FROM " . JurnalUmum::model()->tableName() . " j
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = j.branch_id
                WHERE j.transaction_type IN ('RG', 'SO')
                GROUP BY j.branch_id";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
    
    public static function graphIncomeExpense() {
        
        $sql = "SELECT year, month, SUM(total_debit) as debit, SUM(total_kredit) as kredit
                FROM  (
                    SELECT SUBSTRING(tanggal_transaksi, 1, 4) AS year, SUBSTRING(tanggal_transaksi, 6, 2) AS month, SUM(total) AS total_debit, 0 AS total_kredit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(tanggal_transaksi, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(tanggal_transaksi, 6, 2)) <= 12 AND transaction_type IN ('Pin', 'CASH') AND debet_kredit = 'D'
                    GROUP BY SUBSTRING(tanggal_transaksi, 1, 4), SUBSTRING(tanggal_transaksi, 6, 2)
                    UNION
                    SELECT SUBSTRING(tanggal_transaksi, 1, 4) AS year, SUBSTRING(tanggal_transaksi, 6, 2) AS month, 0 AS total_debit, SUM(total) AS total_kredit
                    FROM " . JurnalUmum::model()->tableName() . "
                    WHERE (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(tanggal_transaksi, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(tanggal_transaksi, 6, 2)) <= 12 AND transaction_type IN ('Pout', 'CASH') AND debet_kredit = 'K'
                    GROUP BY SUBSTRING(tanggal_transaksi, 1, 4), SUBSTRING(tanggal_transaksi, 6, 2)
                ) transaction
                GROUP BY year, month";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
}
