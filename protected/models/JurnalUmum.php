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
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('branch_id', $this->branch_id);
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JurnalUmum the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
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

//    public function getReportTotalBalance() {
//        $params = array(
//            ':transaction_date' => $this->tanggal_transaksi,
//        );
//        
//        $sql = "SELECT COALESCE(SUM(dc.total), 0) AS beginning_balance 
//                FROM " . JurnalUmum::model()->tableName() . " dc
//                INNER JOIN " . Coa::model()->tableName() . " a ON a.id = dc.coa_id
//                WHERE dc.tanggal_transaksi = :transaction_date AND dc.coa_id = :coa_id AND debet_kredit = 'D'";
//
//        $value = CActiveRecord::$db->createCommand($sql)->queryScalar($params);
//        
//        return ($value === false) ? 0 : $value;
//    }
    
}
