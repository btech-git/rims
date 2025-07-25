<?php

/**
 * This is the model class for table "rims_customer".
 *
 * The followings are the available columns in table 'rims_customer':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $fax
 * @property string $email
 * @property string $note
 * @property integer $default_payment_type
 * @property string $customer_type
 * @property integer $tenor
 * @property string $status
 * @property string $birthdate
 * @property string $flat_rate
 * @property string $mobile_phone
 * @property string $phone
 * @property integer $coa_id
 * @property integer $is_approved
 * @property string $date_approval
 * @property integer $user_id_approval
 * @property integer $user_id
 * @property string $time_approval
 * @property integer $is_rejected
 * @property string $date_reject
 * @property string $time_reject
 * @property integer $user_id_reject
 * @property string $tax_registration_number
 *
 * The followings are the available model relations:
 * @property ConsignmentOutHeader[] $consignmentOutHeaders
 * @property Province $province
 * @property City $city
 * @property Coa $coa
 * @property CustomerMobile[] $customerMobiles
 * @property CustomerPhone[] $customerPhones
 * @property CustomerPic[] $customerPics
 * @property CustomerServiceRate[] $customerServiceRates
 * @property Vehicle[] $vehicles 
 * @property RegistrationTransaction[] $registrationTransactions
 * @property InvoiceHeader[] $invoiceHeaders
 * @property PaymentIn[] $paymentIns
 * @property TransactionDeliveryOrder[] $transactionDeliveryOrders
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property TransactionSalesOrder[] $transactionSalesOrders
 * @property User $user
 * @property UserIdApproval $userIdApproval
 * @property UserIdReject $userIdReject
 */
class Customer extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $city_name;
    public $province_name;
    public $plate_number;
    public $mobile_number;
    public $coa_name;
    public $coa_code;

    public function tableName() {
        return 'rims_customer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, address, province_id, city_id, customer_type, user_id', 'required'),
            array('province_id, city_id, default_payment_type, tenor, coa_id, is_approved, is_rejected, user_id, user_id_approval, user_id_reject', 'numerical', 'integerOnly' => true),
            array('name, email, phone, mobile_phone', 'length', 'max' => 100),
            array('email', 'email'),
            array('email, mobile_phone', 'unique'),
            array('note, date_approval', 'safe'),
            array('email', 'filter', 'filter' => 'strtolower'),
            array('zipcode, customer_type, status, flat_rate', 'length', 'max' => 10),
            array('fax', 'length', 'max' => 20),
            array('tax_registration_number', 'length', 'max' => 60),
            array('date_approval, date_edit, time_approval, date_reject, time_reject', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, address, province_id, city_id, zipcode, fax, email, note, customer_type, tenor, status, birthdate, flat_rate, default_payment_type, city_name, province_name, plate_number, coa_id, coa_name, coa_code, phone, mobile_phone, is_approved, date_approval, user_id, user_id_approval, user_id_reject, is_rejected, time_approval, date_reject, time_reject, tax_registration_number', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'consignmentOutHeaders' => array(self::HAS_MANY, 'ConsignmentOutHeader', 'customer_id'),
            'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'customerMobiles' => array(self::HAS_MANY, 'CustomerMobile', 'customer_id'),
            'customerPhones' => array(self::HAS_MANY, 'CustomerPhone', 'customer_id'),
            'customerPics' => array(self::HAS_MANY, 'CustomerPic', 'customer_id'),
            'customerServiceRates' => array(self::HAS_MANY, 'CustomerServiceRate', 'customer_id'),
            'vehicles' => array(self::HAS_MANY, 'Vehicle', 'customer_id'),
            'color' => array(self::BELONGS_TO, 'Colors', 'color_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'registrationTransactions' => array(self::HAS_MANY, 'RegistrationTransaction', 'customer_id'),
            'paymentIns' => array(self::HAS_MANY, 'PaymentIn', 'customer_id'),
            'invoiceHeaders' => array(self::HAS_MANY, 'InvoiceHeader', 'customer_id'),
            'transactionDeliveryOrders' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'customer_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'customer_id'),
            'transactionSalesOrders' => array(self::HAS_MANY, 'TransactionSalesOrder', 'customer_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
            'userIdReject' => array(self::BELONGS_TO, 'Users', 'user_id_reject'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'zipcode' => 'Zipcode',
            'province_id' => 'Province',
            'city_id' => 'City',
            'fax' => 'Fax',
            'email' => 'Email',
            'note' => 'Note',
            'default_payment_type' => 'Default Payment Type',
            'customer_type' => 'Customer Type',
            'tenor' => 'Tenor',
            'status' => 'Status',
            'birthdate' => 'Birthdate',
            'flat_rate' => 'Flat Rate',
            'phone' => 'Phone',
            'mobile_phone' => 'HP',
            'coa_id' => 'Coa',
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
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.zipcode', $this->zipcode, true);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.default_payment_type', $this->default_payment_type);
        $criteria->compare('t.customer_type', $this->customer_type, true);
        $criteria->compare('tenor', $this->tenor);
        $criteria->compare('LOWER(t.status)', strtolower($this->status), FALSE);
        $criteria->compare('birthdate', $this->birthdate, true);
        $criteria->compare('flat_rate', $this->flat_rate, true);
        $criteria->compare('mobile_phone', $this->mobile_phone, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        $criteria->together = 'true';
        $criteria->with = array('province', 'city', 'vehicles', 'coa');
        $criteria->compare('province.name', $this->province_name, true);
        $criteria->compare('city.name', $this->city_name, true);
        $criteria->compare('coa.name', $this->coa_name, true);
        $criteria->compare('coa.code', $this->coa_code, true);

        if ($this->plate_number != NULL) {
            $criteria->with = array('vehicles' => array('together' => true));
            $criteria->compare('vehicles.plate_number', $this->plate_number, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name ASC',
                'attributes' => array(
                    'province_name' => array(
                        'asc' => 'province.name ASC',
                        'desc' => 'province.name DESC',
                    ),
                    'city_name' => array(
                        'asc' => 'city.name ASC',
                        'desc' => 'city.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByDashboard() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('t.zipcode', $this->zipcode, true);
        $criteria->compare('t.province_id', $this->province_id);
        $criteria->compare('t.city_id', $this->city_id);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.default_payment_type', $this->default_payment_type);
        $criteria->compare('t.customer_type', $this->customer_type, true);
        $criteria->compare('tenor', $this->tenor);
        $criteria->compare('LOWER(t.status)', strtolower($this->status), FALSE);
        $criteria->compare('birthdate', $this->birthdate, true);
        $criteria->compare('flat_rate', $this->flat_rate, true);
        $criteria->compare('mobile_phone', $this->mobile_phone, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('t.coa_id', $this->coa_id);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        $customerNameOperator = empty($this->name) ? '=' : 'LIKE';
        $customerNameValue = empty($this->name) ? '' : "%{$this->name}%";
        $criteria->addCondition("t.name {$customerNameOperator} :name");
        $criteria->params[':name'] = $customerNameValue;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name ASC',
                'attributes' => array(
                    'province_name' => array(
                        'asc' => 'province.name ASC',
                        'desc' => 'province.name DESC',
                    ),
                    'city_name' => array(
                        'asc' => 'city.name ASC',
                        'desc' => 'city.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByReceivableReport($endDate, $branchId, $insuranceCompanyId, $customerType, $plateNumber) {
        $branchConditionSql = '';
        $insuranceConditionSql = '';
        $typeConditionSql = '';
        $plateNumberConditionSql = '';
        
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->params = array(
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.branch_id = :branch_id';
            $criteria->params[':branch_id'] = $branchId;
        }
        
        if (!empty($insuranceCompanyId)) {
            $insuranceConditionSql = ' AND p.insurance_company_id = :insurance_company_id';
            $criteria->params[':insurance_company_id'] = $insuranceCompanyId;
        }

        if (!empty($customerType)) {
            $typeConditionSql = ' AND t.customer_type = :customer_type';
            $criteria->params[':customer_type'] = $customerType;
        }

        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND v.plate_number LIKE :plate_number';
            $criteria->params[':plate_number'] = "%{$plateNumber}%";
        }

        $criteria->addCondition("EXISTS (
            SELECT p.customer_id
            FROM " . InvoiceHeader::model()->tableName() . " p 
            LEFT OUTER JOIN " . InsuranceCompany::model()->tableName() . " i ON i.id = p.insurance_company_id
            LEFT OUTER JOIN " . Vehicle::model()->tableName() . " v ON v.id = p.vehicle_id
            WHERE p.customer_id = t.id AND p.payment_left > 100.00 AND p.invoice_date <= :end_date" . $branchConditionSql . $insuranceConditionSql . $plateNumberConditionSql . $typeConditionSql . " 
        ) AND t.customer_type = 'Company'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Customer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getPlateNumber() {
        $plate = array();

        foreach ($this->vehicles as $vehicle) {
            $plate[] = $vehicle->plate_number . '<br>';
        }

        return $this->plate_number = implode('', $plate);
    }

    public function getMobilePhone() {
        $mobile = array();

        foreach ($this->customerMobiles as $customerMobile) {
            $mobile[] = $customerMobile->mobile_no . ', ';
        }

        return $this->mobile_number = implode('', $mobile);
    }

    public function getReceivableLedgerReport($startDate, $endDate) {
        
        $sql = "SELECT transaction_number, transaction_date, transaction_type, remark, amount, sale_amount, payment_amount, customer
                FROM (
                    SELECT invoice_number AS transaction_number, invoice_date AS transaction_date, 'Faktur Penjualan' AS transaction_type, note AS remark, total_price AS amount, total_price AS sale_amount, 0 AS payment_amount, customer_id AS customer
                    FROM " . InvoiceHeader::model()->tableName() . "
                    WHERE invoice_date BETWEEN :start_date AND :end_date AND customer_id = :customer_id
                    UNION
                    SELECT payment_number AS transaction_number, payment_date AS transaction_date, 'Pelunasan Penjualan' AS transaction_type, notes AS remark, (payment_amount * -1) AS amount, 0 AS sale_amount, (payment_amount * -1) AS payment_amount, customer_id AS customer
                    FROM " . PaymentIn::model()->tableName() . "
                    WHERE payment_date BETWEEN :start_date AND :end_date AND customer_id = :customer_id
                ) transaction
                ORDER BY transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':customer_id' => $this->id,
        ));
        
        return $resultSet;
    }
    
    public function getBeginningBalanceReceivable($startDate) {
        $sql = "
            SELECT COALESCE(SUM(payment_left), 0) AS beginning_balance 
            FROM " . InvoiceHeader::model()->tableName() . "
            WHERE customer_id = :customer_id AND invoice_date < :start_date
            GROUP BY customer_id
            HAVING SUM(payment_left) > 0
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getTotalSaleCompany($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(total_price), 0) AS total 
            FROM " . InvoiceHeader::model()->tableName() . "
            WHERE customer_id = :customer_id AND substr(invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND status NOT LIKE '%CANCELLED%'" . $branchConditionSql . "
            GROUP BY customer_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public static function getTotalSaleIndividual($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(r.total_price), 0) AS total 
            FROM " . InvoiceHeader::model()->tableName() . " r 
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
            WHERE c.customer_type = 'Individual' AND substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCELLED%'" . $branchConditionSql . "
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public static function getTotalReceivableIndividual($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(i.total_price), 0) AS total_receivable
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            WHERE c.customer_type = 'Individual' AND i.invoice_date <= :end_date" . $branchConditionSql . "
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public static function getTotalPaymentIndividual($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(i.payment_amount), 0) AS total_payment
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            WHERE c.customer_type = 'Individual' AND i.invoice_date <= :end_date" . $branchConditionSql . "
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public static function getTotalRemainingIndividual($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(i.payment_left), 0) AS total_remaining
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            WHERE c.customer_type = 'Individual' AND i.invoice_date <= :end_date" . $branchConditionSql . "
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getReceivableReport($startDate, $endDate, $branchId, $insuranceCompanyId, $plateNumber) {
        $branchConditionSql = '';
        $insuranceConditionSql = '';
        $plateNumberConditionSql = '';
        
        $params = array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($insuranceCompanyId)) {
            $insuranceConditionSql = ' AND i.insurance_company_id = :insurance_company_id';
            $params[':insurance_company_id'] = $insuranceCompanyId;
        }
        
        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND v.plate_number LIKE :plate_number';
            $params[':plate_number'] = "%{$plateNumber}%";
        }
        
        $sql = "
            SELECT invoice_number, invoice_date, due_date, v.plate_number AS vehicle, COALESCE(i.total_price, 0) AS total_price, p.amount, 
            i.total_price - p.amount AS remaining, ic.name as insurance_name 
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            LEFT OUTER JOIN " . InsuranceCompany::model()->tableName() . " ic ON ic.id = i.insurance_company_id
            LEFT OUTER JOIN (
                SELECT d.invoice_header_id, SUM(d.amount) AS amount 
                FROM " . PaymentInDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.invoice_header_id
            ) p ON i.id = p.invoice_header_id 
            WHERE i.customer_id = :customer_id AND i.insurance_company_id IS NULL AND (i.total_price - p.amount) > 100.00 AND 
            i.invoice_date BETWEEN :start_date AND :end_date" . $branchConditionSql . $insuranceConditionSql . $plateNumberConditionSql . "
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getReceivableCustomerReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':customer_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT p.customer_id, COALESCE(SUM(p.total_price), 0) AS total_price, COALESCE(SUM(p.payment_amount), 0) AS payment_amount, COALESCE(SUM(p.payment_left), 0) AS payment_left
            FROM " . InvoiceHeader::model()->tableName() . " p 
            WHERE p.customer_id = :customer_id AND p.invoice_date <= :end_date" . $branchConditionSql . "
            GROUP BY p.customer_id 
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
//    public function getReceivableInvoiceReport($endDate, $branchId, $plateNumber) {
//        $branchConditionSql = '';
//        $plateConditionSql = '';
//        
//        $params = array(
//            ':customer_id' => $this->id,
//            ':end_date' => $endDate,
//        );
//        
//        if (!empty($branchId)) {
//            $branchConditionSql = ' AND i.branch_id = :branch_id';
//            $params[':branch_id'] = $branchId;
//        }
//        
//        if (!empty($plateNumber)) {
//            $plateConditionSql = ' AND v.plate_number LIKE :plate_number';
//            $params[':plate_number'] = "%{$plateNumber}%";
//        }
//        
//        $sql = "
//            SELECT i.id, i.customer_id, i.invoice_date, i.due_date, i.invoice_number, v.plate_number AS vehicle, i.total_price, 
//                COALESCE(p.amount, 0) + COALESCE(p.tax_service_amount, 0) + COALESCE(p.discount_amount, 0) + COALESCE(p.bank_administration_fee, 0) + 
//                COALESCE(p.merimen_fee, 0) + COALESCE(p.downpayment_amount, 0) AS amount, i.total_price - COALESCE(p.amount, 0) - 
//                COALESCE(p.tax_service_amount, 0) - COALESCE(p.discount_amount, 0) - COALESCE(p.bank_administration_fee, 0) - COALESCE(p.merimen_fee, 0) - 
//                COALESCE(p.downpayment_amount, 0) AS remaining
//            FROM " . InvoiceHeader::model()->tableName() . " i
//            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
//            LEFT OUTER JOIN (
//                SELECT d.invoice_header_id, SUM(d.amount) AS amount, SUM(d.tax_service_amount) AS tax_service_amount, SUM(d.discount_amount) AS discount_amount,
//                    SUM(d.bank_administration_fee) AS bank_administration_fee, SUM(d.merimen_fee) AS merimen_fee, SUM(d.downpayment_amount) AS downpayment_amount
//                FROM " . PaymentInDetail::model()->tableName() . " d 
//                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
//                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
//                GROUP BY d.invoice_header_id
//            ) p ON i.id = p.invoice_header_id 
//            WHERE i.customer_id = :customer_id AND i.insurance_company_id IS NULL AND (i.total_price - COALESCE(p.amount, 0) - COALESCE(p.tax_service_amount, 0) - 
//                COALESCE(p.discount_amount, 0) - COALESCE(p.bank_administration_fee, 0) - COALESCE(p.merimen_fee, 0) - COALESCE(p.downpayment_amount, 0)) > 100 AND 
//                i.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date " . $branchConditionSql . $plateConditionSql;
//
//        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
//
//        return $resultSet;
//    }
    
    public function getSaleReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT r.id, r.invoice_number, r.invoice_date, r.product_price, r.service_price, r.total_price, v.plate_number AS plate_number, r.ppn_total, r.pph_total
            FROM " . InvoiceHeader::model()->tableName() . " r
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
            WHERE r.customer_id = :customer_id AND substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCELLED%'" . $branchConditionSql . "
            ORDER BY r.invoice_date, r.invoice_number
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getSaleByProjectReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT r.id, r.invoice_number, r.invoice_date, d.product_id, p.name AS product, d.service_id, s.name AS service, d.quantity, d.unit_price, d.total_price, v.plate_number AS plate_number, p.hpp
            FROM " . InvoiceHeader::model()->tableName() . " r
            INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON r.id = d.invoice_id
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
            LEFT OUTER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
            LEFT OUTER JOIN " . Service::model()->tableName() . " s ON s.id = d.service_id
            WHERE r.customer_id = :customer_id AND substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCELLED%'" . $branchConditionSql . "
            ORDER BY r.invoice_date, r.invoice_number
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
}
