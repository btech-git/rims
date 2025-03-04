<?php

/**
 * This is the model class for table "{{payment_out}}".
 *
 * The followings are the available columns in table '{{payment_out}}':
 * @property integer $id
 * @property integer $purchase_order_id
 * @property string $payment_number
 * @property string $payment_date
 * @property integer $supplier_id
 * @property string $payment_amount
 * @property string $notes
 * @property string $payment_type
 * @property integer $user_id
 * @property integer $branch_id
 * @property string $status
 * @property integer $company_bank_id
 * @property string $nomor_giro
 * @property integer $payment_type_id
 * @property string $created_datetime
 * @property integer $user_id_edited
 * @property string $edited_datetime
 * @property integer $user_id_cancelled
 * @property string $cancelled_datetime
 * @property integer $coa_id_deposit
 *
 * The followings are the available model relations:
 * @property TransactionPurchaseOrder $purchaseOrder
 * @property Supplier $supplier
 * @property Users $user
 * @property UserIdCancelled $userIdCancelled
 * @property UserIdEdited $userIdEdited
 * @property Branch $branch
 * @property CompanyBank $companyBank
 * @property PayOutDetails[] $payOutDetails
 * @property PaymentOutImages[] $paymentOutImages
 * @property PaymentOutApproval[] $paymentOutApprovals
 * @property PaymentType $paymentType
 * @property CoaIdDeposit $coaIdDeposit
 */
class PaymentOut extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'Pout';

    /**
     * @return string the associated database table name
     */
    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    public $purchase_order_number;
    public $supplier_name;
    public $images;

    public function tableName() {
        return '{{payment_out}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_number, payment_date, supplier_id, payment_amount, notes, user_id, branch_id, status, payment_type_id', 'required'),
            array('purchase_order_id, supplier_id, user_id, branch_id, company_bank_id, cash_payment_type, bank_id, payment_type_id, user_id_cancelled, coa_id_deposit, user_id_edited', 'numerical', 'integerOnly' => true),
            array('payment_number', 'length', 'max' => 50),
            array('payment_amount', 'length', 'max' => 18),
            array('nomor_giro', 'length', 'max' => 20),
            array('payment_type, status', 'length', 'max' => 30),
            array('payment_number', 'unique'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, purchase_order_id, purchase_order_number, payment_number, payment_date, created_datetime, edited_datetime, supplier_id, payment_amount, coa_id_deposit, notes, payment_type, user_id, branch_id, user_id_edited, supplier_name, status, company_bank_id, nomor_giro, cash_payment_type, bank_id, payment_type_id, images, cancelled_datetime, user_id_cancelled', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'purchaseOrder' => array(self::BELONGS_TO, 'TransactionPurchaseOrder', 'purchase_order_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdCancelled' => array(self::BELONGS_TO, 'User', 'user_id_cancelled'),
            'userIdEdited' => array(self::BELONGS_TO, 'User', 'user_id_edited'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'bank' => array(self::BELONGS_TO, 'Bank', 'bank_id'),
            'companyBank' => array(self::BELONGS_TO, 'CompanyBank', 'company_bank_id'),
            'payOutDetails' => array(self::HAS_MANY, 'PayOutDetail', 'payment_out_id'),
            'paymentOutApprovals' => array(self::HAS_MANY, 'PaymentOutApproval', 'payment_out_id'),
            'paymentOutImages' => array(self::HAS_MANY, 'PaymentOutImages', 'payment_out_id'),
            'paymentType' => array(self::BELONGS_TO, 'PaymentType', 'payment_type_id'),
            'coaIdDeposit' => array(self::BELONGS_TO, 'Coa', 'coa_id_deposit'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'purchase_order_id' => 'Purchase Order',
            'payment_number' => 'Payment Number',
            'payment_date' => 'Payment Date',
            'supplier_id' => 'Supplier',
            'payment_amount' => 'Payment Amount',
            'notes' => 'Notes',
            'payment_type' => 'Payment Type',
            'user_id' => 'User',
            'branch_id' => 'Branch',
            'status' => 'Status',
            'company_bank_id' => 'Company Bank',
            'nomor_giro' => 'Nomor Giro',
            'cash_payment_type' => 'Cash Payment Type',
            'bank_id' => 'Bank',
            'payment_type_id' => 'Payment Type',
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.payment_number', $this->payment_number, true);
        $criteria->compare('t.payment_date', $this->payment_date, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.notes', $this->notes, true);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('t.nomor_giro', $this->nomor_giro, true);
        $criteria->compare('t.cash_payment_type', $this->cash_payment_type);
        $criteria->compare('t.bank_id', $this->bank_id);
        $criteria->compare('t.payment_type_id', $this->payment_type_id);
        $criteria->compare('t.coa_id_deposit', $this->coa_id_deposit);

        $criteria->together = true;
        $criteria->with = array('supplier', 'purchaseOrder');
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_number, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByAdmin() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.payment_number', $this->payment_number, true);
        $criteria->compare('t.payment_date', $this->payment_date, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('company_bank_id', $this->company_bank_id);
        $criteria->compare('nomor_giro', $this->nomor_giro, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('bank_id', $this->bank_id);
        $criteria->compare('payment_type_id', $this->payment_type_id);

//        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

        $criteria->together = true;
        $criteria->with = array('supplier', 'purchaseOrder');
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_number, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByDailyCashReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('purchase_order_id', $this->purchase_order_id);
        $criteria->compare('payment_number', $this->payment_number, true);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('payment_amount', $this->payment_amount, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('company_bank_id', $this->company_bank_id);
        $criteria->compare('nomor_giro', $this->nomor_giro, true);
        $criteria->compare('cash_payment_type', $this->cash_payment_type);
        $criteria->compare('bank_id', $this->bank_id);
        $criteria->compare('payment_type_id', $this->payment_type_id);

        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        $criteria->together = true;
        $criteria->with = array('supplier', 'purchaseOrder');
        $criteria->compare('purchaseOrder.purchase_order_no', $this->purchase_order_number, true);
        $criteria->compare('supplier.name', $this->supplier_name, true);

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
     * @return PaymentOut the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(payment_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(payment_number, '/', 2), '/', -1), '.', -1)";
        $paymentOut = PaymentOut::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($paymentOut == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $paymentOut->branch->code;
            $this->payment_number = $paymentOut->payment_number;
        }

        $this->setCodeNumberByNext('payment_number', $branchCode, PaymentOut::CONSTANT, $currentMonth, $currentYear);
    }
    
    public function getTotalInvoice() {
        $total = 0.00;
        
        foreach ($this->payOutDetails as $detail) {
            $total += $detail->total_invoice;
        }
        
        return $total;
    }

    public function getFilename() {
        
        return $this->id . '.' . $this->extension;
    }
    
    public function searchByPendingJournal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.purchase_order_id', $this->purchase_order_id);
        $criteria->compare('t.payment_number', $this->payment_number, true);
        $criteria->compare('t.payment_date', $this->payment_date, true);
        $criteria->compare('t.supplier_id', $this->supplier_id);
        $criteria->compare('t.payment_amount', $this->payment_amount, true);
        $criteria->compare('t.notes', $this->notes, true);
        $criteria->compare('t.payment_type', $this->payment_type, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.status', 'Approved');
        $criteria->compare('t.company_bank_id', $this->company_bank_id);
        $criteria->compare('t.nomor_giro', $this->nomor_giro, true);
        $criteria->compare('t.cash_payment_type', $this->cash_payment_type);
        $criteria->compare('t.bank_id', $this->bank_id);
        $criteria->compare('t.payment_type_id', $this->payment_type_id);

        $criteria->addCondition("substring(t.payment_number, 1, (length(t.payment_number) - 2)) NOT IN (
            SELECT substring(kode_transaksi, 1, (length(kode_transaksi) - 2))  
            FROM " . JurnalUmum::model()->tableName() . "
        )");

        $criteria->together = true;
        $criteria->with = array('supplier');
        $criteria->compare('supplier.name', $this->supplier_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'payment_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public function getApprovalStatus() {
        $paymentOutApproval = PaymentOutApproval::model()->findByAttributes(array('payment_out_id' => $this->id), array('order' => 'id DESC'));
        
        return $paymentOutApproval->approval_type;
    }

    public static function getPaymentByTypeList($month, $year, $branchId) {
        $branchConditionSql = '';
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        if (!empty($branchId)) {
            $branchConditionSql = " AND pi.branch_id = :branch_id";
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT pi.payment_date, pi.payment_type_id, MIN(pt.name) AS payment_type, COALESCE(SUM(pi.payment_amount), 0) AS total_amount
                FROM " . PaymentOut::model()->tableName() . " pi
                INNER JOIN " . PaymentType::model()->tableName() . " pt ON pt.id = pi.payment_type_id
                WHERE YEAR(payment_date) = :year AND MONTH(payment_date) = :month AND pi.status IN ('CLEAR', 'Approved')" . $branchConditionSql . "
                GROUP BY pi.payment_date, pi.payment_type_id
                ORDER BY pi.payment_date";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
