<?php

/**
 * This is the model class for table "{{supplier}}".
 *
 * The followings are the available columns in table '{{supplier}}':
 * @property integer $id
 * @property string $date
 * @property string $code
 * @property string $name
 * @property string $company
 * @property string $position
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $email_personal
 * @property string $email_company
 * @property string $npwp
 * @property integer $tenor
 * @property string $company_attribute
 * @property integer $coa_id
 * @property integer $description
 * @property integer $status
 * @property string $person_in_charge
 * @property string $phone
 * @property string $mobile_phone
 * @property integer $is_approved
 * @property string $date_approval
 * @property integer $user_id
 * @property string $time_created
 * @property string $time_approval
 *
 * The followings are the available model relations:
 * @property ConsignmentInHeader[] $consignmentInHeaders
 * @property PaymentOut[] $paymentOuts
 * @property ProductPrice[] $productPrices
 * @property Province $province
 * @property City $city
 * @property SupplierBank[] $supplierBanks
 * @property SupplierMobile[] $supplierMobiles
 * @property SupplierPhone[] $supplierPhones
 * @property SupplierPic[] $supplierPics
 * @property SupplierProduct[] $supplierProducts
 * @property Coa $coa
 * @property Coa $coaOutstandingOrder
 * @property TransactionPurchaseOrder[] $transactionPurchaseOrders
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionRequestOrderDetail[] $transactionRequestOrderDetails
 * @property TransactionReturnOrder[] $transactionReturnOrders
 * @property User $user
 */
class Supplier extends CActiveRecord {

    public $product_master_category_id;
    public $product_sub_master_category_id;
    public $product_sub_category_id;
    public $production_year;
    public $brand_id;
    public $purchase;
    public $product_name;
    public $coa_name;
    public $coa_code;
    public $coa_outstanding_code;
    public $coa_outstanding_name;

    // public $pid;
    // public $suppid;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{supplier}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name, company, address, province_id, city_id, zipcode, email_personal, email_company, npwp, tenor, user_id', 'required'),
            array('province_id, city_id, tenor, coa_id, coa_outstanding_order, is_approved, user_id', 'numerical', 'integerOnly' => true),
            array('code, npwp', 'length', 'max' => 20),
            array('name, company, position', 'length', 'max' => 30),
            array('status', 'length', 'max' => 45),
            array('zipcode, company_attribute', 'length', 'max' => 10),
            array('email_personal, email_company, phone', 'length', 'max' => 60),
            array('person_in_charge, mobile_phone', 'length', 'max' => 100),
            array('date, note, date_approval', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, date, code, name, company, position, address, time_created, time_approval, province_id, city_id, zipcode, email_personal, email_company, npwp, tenor, company_attribute,product_name, coa_id, coa_name, coa_code, coa_outstanding_code, coa_outstanding_name, note, status, phone, person_in_charge, mobile_phone, is_approved, date_approval, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave() {

        if ($this->isNewRecord) {
            $this->date = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'consignmentInHeaders' => array(self::HAS_MANY, 'ConsignmentInHeader', 'supplier_id'),
            'paymentOuts' => array(self::HAS_MANY, 'PaymentOut', 'supplier_id'),
            'productPrices' => array(self::HAS_MANY, 'ProductPrice', 'supplier_id'),
            'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'supplierBanks' => array(self::HAS_MANY, 'SupplierBank', 'supplier_id'),
            'supplierMobiles' => array(self::HAS_MANY, 'SupplierMobile', 'supplier_id'),
            'supplierPhones' => array(self::HAS_MANY, 'SupplierPhone', 'supplier_id'),
            'supplierPics' => array(self::HAS_MANY, 'SupplierPic', 'supplier_id'),
            'supplierProducts' => array(self::HAS_MANY, 'SupplierProduct', 'supplier_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'coaOutstandingOrder' => array(self::BELONGS_TO, 'Coa', 'coa_outstanding_order'),
            'transactionPurchaseOrders' => array(self::HAS_MANY, 'TransactionPurchaseOrder', 'supplier_id'),
            'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'supplier_id'),
            'transactionRequestOrderDetails' => array(self::HAS_MANY, 'TransactionRequestOrderDetail', 'supplier_id'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'supplier_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'date' => 'Date',
            'code' => 'Code',
            'name' => 'Name',
            'company' => 'Company',
            'position' => 'Position',
            'address' => 'Address',
            'province_id' => 'Province',
            'city_id' => 'City',
            'zipcode' => 'Zipcode',
            'email_personal' => 'Email Personal',
            'email_company' => 'Email Company',
            'npwp' => 'Npwp',
            'tenor' => 'Tenor',
            'company_attribute' => 'Company Attribute',
            'coa_id' => 'Coa',
            'coa_outstanding_order' => 'Coa Outstanding Order',
            'person_in_charge' => 'PIC',
            'phone' => 'Phone',
            'mobile_phone' => 'Mobile Phone',
            'is_approved' => 'Approval',
            'date_approval' => 'Tanggal Approval',
            'user_id' => 'User Input',
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
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.company', $this->company, true);
        $criteria->compare('t.position', $this->position, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('t.zipcode', $this->zipcode, true);
        $criteria->compare('t.email_personal', $this->email_personal, true);
        $criteria->compare('email_company', $this->email_company, true);
        $criteria->compare('npwp', $this->npwp, true);
        $criteria->compare('tenor', $this->tenor);
        $criteria->compare('company_attribute', $this->company_attribute, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.coa_outstanding_order', $this->coa_outstanding_order);
        $criteria->compare('t.description', $this->description);
        $criteria->compare('person_in_charge', $this->person_in_charge);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('mobile_phone', $this->mobile_phone);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        $criteria->together = true;
        $criteria->with = array('coa', 'coaOutstandingOrder');
        $criteria->compare('coa.name', $this->coa_name, true);
        $criteria->compare('coa.code', $this->coa_code, true);
        $criteria->compare('coaOutstandingOrder.name', $this->coa_outstanding_name, true);
        $criteria->compare('coaOutstandingOrder.code', $this->coa_outstanding_code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function searchByPayableReport() {
        
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.company', $this->company, true);
        $criteria->compare('t.position', $this->position, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('t.zipcode', $this->zipcode, true);
        $criteria->compare('t.email_personal', $this->email_personal, true);
        $criteria->compare('email_company', $this->email_company, true);
        $criteria->compare('npwp', $this->npwp, true);
        $criteria->compare('tenor', $this->tenor);
        $criteria->compare('company_attribute', $this->company_attribute, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.coa_outstanding_order', $this->coa_outstanding_order);
        $criteria->compare('t.description', $this->description);
        $criteria->compare('person_in_charge', $this->person_in_charge);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('mobile_phone', $this->mobile_phone);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
            ),
        ));
    }

    public function searchByPayableSupplierReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND main_branch_id = :branch_id';
            $criteria->params[':branch_id'] = $branchId;
        }
        
        $criteria->addCondition("EXISTS (
            SELECT supplier_id
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = t.id AND substring(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date " . $branchConditionSql . " 
        )");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByPayable($startDate) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addCondition("EXISTS (
            SELECT COALESCE(SUM(payment_left), 0) AS beginning_balance 
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE t.id = supplier_id AND substring(purchase_order_date, 1, 10) < :start_date
            GROUP BY supplier_id
            HAVING SUM(payment_left) > 0
        )");
        
        $criteria->params = array(
            ':start_date' => $startDate
        );

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.company', $this->company, true);
        $criteria->compare('t.position', $this->position, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('t.zipcode', $this->zipcode, true);
        $criteria->compare('t.email_personal', $this->email_personal, true);
        $criteria->compare('email_company', $this->email_company, true);
        $criteria->compare('npwp', $this->npwp, true);
        $criteria->compare('tenor', $this->tenor);
        $criteria->compare('company_attribute', $this->company_attribute, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.coa_outstanding_order', $this->coa_outstanding_order);
        $criteria->compare('t.description', $this->description);
        $criteria->compare('person_in_charge', $this->person_in_charge);
        $criteria->compare('phone', $this->phone);
        $criteria->compare('mobile_phone', $this->mobile_phone);
        $criteria->compare('t.is_approved', 1);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Supplier the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPayableLedgerReport($startDate, $endDate) {
        
        $sql = "SELECT transaction_number, transaction_date, transaction_type, remark, amount, purchase_amount, payment_amount, supplier
                FROM (
                    SELECT purchase_order_no AS transaction_number, purchase_order_date AS transaction_date, 'Faktur Pembelian' AS transaction_type, status_document AS remark, total_price AS amount, total_price AS purchase_amount, 0 AS payment_amount, supplier_id AS supplier
                    FROM " . TransactionPurchaseOrder::model()->tableName() . "
                    WHERE substring(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND supplier_id = :supplier_id
                    UNION
                    SELECT payment_number AS transaction_number, payment_date AS transaction_date, 'Pembayaran Pembelian' AS transaction_type, notes AS remark, (payment_amount * -1) AS amount, 0 AS purchase_amount, (payment_amount * -1) AS payment_amount, supplier_id AS supplier
                    FROM " . PaymentOut::model()->tableName() . "
                    WHERE substring(payment_date, 1, 10) BETWEEN :start_date AND :end_date AND supplier_id = :supplier_id
                ) transaction
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':supplier_id' => $this->id,
        ));
        
        return $resultSet;
    }
    
    public function getBeginningBalancePayable($startDate) {
        $sql = "
            SELECT COALESCE(SUM(payment_left), 0) AS beginning_balance 
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = :supplier_id AND purchase_order_date < :start_date
            GROUP BY supplier_id
            HAVING SUM(payment_left) > 0
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getCreatedDatetime() {
        return $this->date . " " . $this->time_created;
    }
    
    public function getApprovedDatetime() {
        return $this->date_approval . " " . $this->time_approval;
    }
    
    public function getPayableReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND o.main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT r.receive_item_no, r.invoice_number, o.purchase_order_date, r.invoice_grand_total AS total_price, COALESCE(p.amount, 0) AS amount, 
            r.invoice_grand_total - COALESCE(p.amount, 0) AS remaining
            FROM " . TransactionPurchaseOrder::model()->tableName() . " o
            INNER JOIN " . TransactionReceiveItem::model()->tableName() . " r ON o.id = r.purchase_order_id
            LEFT OUTER JOIN (
                SELECT d.receive_item_id, SUM(d.amount) AS amount 
                FROM " . PayOutDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND h.status NOT LIKE '%CANCEL%'
                GROUP BY d.receive_item_id
            ) p ON r.id = p.receive_item_id 
            WHERE r.supplier_id = :supplier_id AND (r.invoice_grand_total - COALESCE(p.amount, 0)) > 100.00 AND 
            DATE(r.invoice_date) BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND o.status_document NOT LIKE '%CANCEL%' AND
            r.user_id_cancelled IS NULL" . $branchConditionSql . "
            ORDER BY r.invoice_date ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getPayableTransactionReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        $sql = "
            SELECT purchase_order_no, purchase_order_date, COALESCE(total_price, 0) AS total_price, COALESCE(payment_amount, 0) AS payment_amount, COALESCE(payment_left, 0) AS payment_left 
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = :supplier_id AND substring(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND status_document = 'Approved'" . $branchConditionSql;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getTotalPurchase($startDate, $endDate) {
        $sql = "
            SELECT COALESCE(SUM(total_price), 0) AS total 
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = :supplier_id AND purchase_order_date BETWEEN :start_date AND :end_date
            GROUP BY supplier_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getPurchasePerSupplierReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT id, purchase_order_no, purchase_order_date, payment_type, payment_status, total_price
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = :supplier_id AND substr(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND status_document NOT LIKE '%CANCEL%'" . $branchConditionSql . "
            ORDER BY purchase_order_date, purchase_order_no
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getPurchasePriceReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(total_price), 0) AS total_purchase 
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = :supplier_id AND substr(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND status_document NOT LIKE '%CANCEL%'" . $branchConditionSql . "
            GROUP BY supplier_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getWorkOrderExpensePerSupplierReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT w.id, w.transaction_number, w.transaction_date, r.transaction_number AS registration_number, w.status, w.grand_total
            FROM " . WorkOrderExpenseHeader::model()->tableName() . " w
            INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = w.registration_transaction_id
            WHERE w.supplier_id = :supplier_id AND substr(w.transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND w.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
            ORDER BY w.transaction_date, w.transaction_number
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getWorkOrderExpensePriceReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(grand_total), 0) AS total_purchase 
            FROM " . WorkOrderExpenseHeader::model()->tableName() . "
            WHERE supplier_id = :supplier_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getPayableSupplierReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':supplier_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT p.supplier_id, COALESCE(SUM(p.total_price), 0) AS total_price, COALESCE(SUM(p.payment_amount), 0) AS payment_amount, COALESCE(SUM(p.payment_left), 0) AS payment_left
            FROM " . TransactionPurchaseOrder::model()->tableName() . " p 
            WHERE p.supplier_id = :supplier_id AND substr(p.purchase_order_date, 1, 10) BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date" . $branchConditionSql . "
            GROUP BY p.supplier_id 
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
