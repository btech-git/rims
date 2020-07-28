<?php

/**
 * This is the model class for table "{{jurnal_penyesuaian}}".
 *
 * The followings are the available columns in table '{{jurnal_penyesuaian}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property integer $coa_biaya_id
 * @property integer $coa_akumulasi_id
 * @property string $amount
 * @property integer $branch_id
 * @property integer $user_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Coa $coaBiaya
 * @property Coa $coaAkumulasi
 * @property Branch $branch
 * @property Users $user
 * @property JurnalPenyesuaianApproval[] $jurnalPenyesuaianApprovals
 */
class JurnalPenyesuaian extends MonthlyTransactionActiveRecord
{
    const CONSTANT = 'JP';
	/**
	 * @return string the associated database table name
	 */
	public $coa_biaya_name;
	public $coa_akumulasi_name;
	public $coa_biaya_code;
	public $coa_akumulasi_code;
	public function tableName()
	{
		return '{{jurnal_penyesuaian}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_number, transaction_date, coa_biaya_id, coa_akumulasi_id, amount, branch_id, user_id, status', 'required'),
			array('coa_biaya_id, coa_akumulasi_id, branch_id, user_id', 'numerical', 'integerOnly'=>true),
			array('transaction_number', 'length', 'max'=>50),
			array('amount', 'length', 'max'=>18),
			array('status', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transaction_number, transaction_date, coa_biaya_id, coa_akumulasi_id, amount, branch_id, user_id, status, coa_biaya_name,coa_biaya_code,coa_akumulasi_name,coa_akumulasi_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'coaBiaya' => array(self::BELONGS_TO, 'Coa', 'coa_biaya_id'),
			'coaAkumulasi' => array(self::BELONGS_TO, 'Coa', 'coa_akumulasi_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'jurnalPenyesuaianApprovals' => array(self::HAS_MANY, 'JurnalPenyesuaianApproval', 'jurnal_penyesuaian_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_number' => 'Transaction Number',
			'transaction_date' => 'Transaction Date',
			'coa_biaya_id' => 'Coa Biaya',
			'coa_akumulasi_id' => 'Coa Akumulasi',
			'amount' => 'Amount',
			'branch_id' => 'Branch',
			'user_id' => 'User',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_number',$this->transaction_number,true);
		$criteria->compare('transaction_date',$this->transaction_date,true);
		$criteria->compare('coa_biaya_id',$this->coa_biaya_id);
		$criteria->compare('coa_akumulasi_id',$this->coa_akumulasi_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('status',$this->status,true);

		$criteria->together = 'true';
		$criteria->with = array('coaBiaya','coaAkumulasi');
		$criteria->compare('coaBiaya.name', $this->coa_biaya_name, true);
		$criteria->compare('coaBiaya.code', $this->coa_biaya_code, true);
		$criteria->compare('coaAkumulasi.name', $this->coa_akumulasi_name, true);
		$criteria->compare('coaAkumulasi.code', $this->coa_akumulasi_code, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return JurnalPenyesuaian the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $jurnalPenyesuaian = JurnalPenyesuaian::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));
        
        if ($jurnalPenyesuaian == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $jurnalPenyesuaian->branch->code;
            $this->transaction_number = $jurnalPenyesuaian->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $branchCode, JurnalPenyesuaian::CONSTANT, $currentMonth, $currentYear);
    }
}
