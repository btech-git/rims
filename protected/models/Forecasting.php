<?php

/**
 * This is the model class for table "{{forecasting}}".
 *
 * The followings are the available columns in table '{{forecasting}}':
 * @property integer $id
 * @property integer $transaction_id
 * @property string $type_forecasting
 * @property string $due_date
 * @property string $payment_date
 * @property string $realization_date
 * @property integer $bank_id
 * @property string $amount
 * @property string $balance
 * @property string $realization_balance
 * @property string $status
 * @property string $notes
 */
class Forecasting extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $image;
	public $priode;
	public $amt;
    const TYPE_PO = 'po';
    const TYPE_SO = 'so';
    const TYPE_LAIN = 'cash_out';
    const TYPE_PENDAPATAN = 'cash_in';
    const TYPE_CASH_OUT = 'cash_out';
    const TYPE_CASH_IN = 'cash_in';

	public $supplier_name;
	public $customer_name;
	public $bank_name;
	public $coa_name;

	public function tableName()
	{
		return '{{forecasting}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('transaction_id, due_date, payment_date, realization_date, bank_id, balance, realization_balance, status', 'required'),
			array('payment_date', 'required'),
			array('transaction_id, bank_id', 'numerical', 'integerOnly'=>true),
			array('type_forecasting', 'length', 'max'=>9),
			array('amount, balance, realization_balance', 'length', 'max'=>18),
			array('status', 'length', 'max'=>10),
			array('notes', 'safe'),
            array('image', 'file', 'types'=>'jpg, gif, png', 'safe' => false, 'allowEmpty' => true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, transaction_id, type_forecasting, due_date, payment_date, realization_date, bank_id, amount, balance, realization_balance, status, notes, supplier_name, customer_name, bank_name, coa_name', 'safe', 'on'=>'search'),
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
			'transaction_po' => array(self::BELONGS_TO, 'TransactionPurchaseOrder', 'transaction_id'),
			'transaction_so' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'transaction_id'),
			'transaction_ci' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'transaction_id'),
			'transaction_co' => array(self::BELONGS_TO, 'TransactionSalesOrder', 'transaction_id'),
			'bank' => array(self::BELONGS_TO, 'CompanyBank', 'bank_id'),
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'transaction_id' => 'Transaction',
			'type_forecasting' => 'Type Forecasting',
			'due_date' => 'Due Date',
			'payment_date' => 'Estimate Payment',
			'realization_date' => 'Realization Date',
			'bank_id' => 'Bank',
			'amount' => 'Amount',
			'balance' => 'Balance',
			'realization_balance' => 'Realization Balance',
			'status' => 'Status',
			'notes' => 'Notes',
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
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('type_forecasting',$this->type_forecasting,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('realization_date',$this->realization_date,true);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('realization_balance',$this->realization_balance,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Forecasting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getValue($attributes,$param = array()) {
		// if (empty($param)) {
		// 	$val= self::model()->findByAttributes();
		// }else{
			$val = self::model()->findByAttributes($param);
			// var_dump($val); die("S");
		// }
		return (empty($val)? '':$val->$attributes);
	}

	public function getValues($attributes,$param = array()) {
			$val = self::model()->findAllByAttributes($param);
			$x = array();
			foreach ($val as $key => $value) {
				$x[$key] = $value->$attributes;
			}
			return array_sum($x);
	}
	public function getSaldoAwal($bankid,$priodeStart) {
		// $val= self::model()->findAllByAttributes();

		// var_dump($bankid . $priodeStart); die();
		$resource_cnt_po = self::model()->findAll(array(
		  'select'=>'id,bank_id,payment_date, SUM(amount) as amt',
		  'condition'=>'bank_id=:bank_id AND type_forecasting = "po" AND YEAR(payment_date) = YEAR(:priodeStart - INTERVAL 1 MONTH) AND MONTH(payment_date) = MONTH(:priodeStart - INTERVAL 1 MONTH)',
		  'params'=>array(':bank_id'=>$bankid,':priodeStart'=>$priodeStart))
		);

		$resource_cnt_so = self::model()->findAll(array(
		  'select'=>'id,bank_id,payment_date, SUM(amount) as amt',
		  'condition'=>'bank_id=:bank_id AND type_forecasting = "so" AND YEAR(payment_date) = YEAR(:priodeStart - INTERVAL 1 MONTH) AND MONTH(payment_date) = MONTH(:priodeStart - INTERVAL 1 MONTH)',
		  'params'=>array(':bank_id'=>$bankid,':priodeStart'=>$priodeStart))
		);
		// var_dump($resource_cnt); die("S");
		foreach ($resource_cnt_po as $key => $value) {
			$amount_po = $value->amt; 
		}

		foreach ($resource_cnt_so as $key => $value) {
			$amount_so = $value->amt; 
		}

		$po_a = ($amount_po != NULL) ? $amount_po:0;
		$so_a = ($amount_so != NULL) ? $amount_so:0;

		// $amount = (($amount_so != NULL) ? $amount_so:0 - ($amount_po != NULL) ? $amount_po:0);
		return ($so_a - $po_a);
	}

	public function getSaldoAwalKas($bankid,$priodeStart) {
		// $val= self::model()->findAllByAttributes();

		// var_dump($bankid . $priodeStart); die();
		$resource_cnt_out = self::model()->findAll(array(
		  'select'=>'id,coa_id,payment_date, SUM(amount) as amt',
		  'condition'=>'coa_id=:bank_id AND type_forecasting = "cash_out" AND YEAR(payment_date) = YEAR(:priodeStart - INTERVAL 1 MONTH) AND MONTH(payment_date) = MONTH(:priodeStart - INTERVAL 1 MONTH)',
		  'params'=>array(':bank_id'=>$bankid,':priodeStart'=>$priodeStart))
		);

		$resource_cnt_in = self::model()->findAll(array(
		  'select'=>'id,coa_id,payment_date, SUM(amount) as amt',
		  'condition'=>'coa_id=:bank_id AND type_forecasting = "cash_in" AND YEAR(payment_date) = YEAR(:priodeStart - INTERVAL 1 MONTH) AND MONTH(payment_date) = MONTH(:priodeStart - INTERVAL 1 MONTH)',
		  'params'=>array(':bank_id'=>$bankid,':priodeStart'=>$priodeStart))
		);
		// var_dump($resource_cnt); die("S");
		foreach ($resource_cnt_out as $key => $value) {
			$amount_out = $value->amt; 
		}

		foreach ($resource_cnt_in as $key => $value) {
			$amount_in = $value->amt; 
		}

		$out_a = ($amount_out != NULL) ? $amount_out:0;
		$in_a = ($amount_in != NULL) ? $amount_in:0;

		// $amount = (($amount_so != NULL) ? $amount_so:0 - ($amount_po != NULL) ? $amount_po:0);
		return ($in_a - $out_a);
	}


	public function getCoaBank($coa) {

		/* id bank
			3 	BCA HUFADHA | 5 	BCA PD	| 7 	BCA PT	| 10 	CIMB NIAGA | 14 	Mandiri KMK | 17 	MANDIRI TBM
		*/
		//$listcoa = array(3,5,7,10,14,17); 

		$companyBank = CompanyBank::model()->findByAttributes(array('coa_id'=>$coa));
		// var_dump($companyBank); die();
		// if ($companyBank != NULL) {
		// }
		return ($companyBank == NULL) ? FALSE : $companyBank->id;
	}

}
