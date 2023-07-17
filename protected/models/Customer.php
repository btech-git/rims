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
 * @property integer $user_id
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
 */
class Customer extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public $city_name;
    public $province_name;
    public $plate_number;
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
            array('province_id, city_id, default_payment_type, tenor, coa_id, is_approved, user_id', 'numerical', 'integerOnly' => true),
            array('name, email, phone, mobile_phone', 'length', 'max' => 100),
            array('email', 'email'),
            array('email, mobile_phone', 'unique'),
            array('note, date_approval', 'safe'),
            array('email', 'filter', 'filter' => 'strtolower'),
            array('zipcode, customer_type, status, flat_rate', 'length', 'max' => 10),
            array('fax', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, address, province_id, city_id, zipcode, fax, email, note, customer_type, tenor, status, birthdate, flat_rate, default_payment_type, city_name, province_name, plate_number, coa_id, coa_name, coa_code, phone, mobile_phone, is_approved, date_approval, user_id', 'safe', 'on' => 'search'),
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
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
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

    public function searchByReceivableReport($endDate, $branchId, $insuranceCompanyId, $customerType) {
        $branchConditionSql = '';
        $insuranceConditionSql = '';
        $typeConditionSql = '';
        
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
            $insuranceConditionSql = ' AND r.insurance_company_id = :insurance_company_id';
            $criteria->params[':insurance_company_id'] = $insuranceCompanyId;
        }

        if (!empty($customerType)) {
            $typeConditionSql = ' AND t.customer_type = :customer_type';
            $criteria->params[':customer_type'] = $customerType;
        }

        $criteria->addCondition("EXISTS (
            SELECT p.customer_id
            FROM " . InvoiceHeader::model()->tableName() . " p 
            INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = p.registration_transaction_id
            LEFT OUTER JOIN " . InsuranceCompany::model()->tableName() . " i ON i.id = r.insurance_company_id
            WHERE p.customer_id = t.id AND p.payment_left > 100.00 AND p.invoice_date <= :end_date " . $branchConditionSql . $insuranceConditionSql . " 
        )" . $typeConditionSql);

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
    
    public function getTotalSales($startDate, $endDate) {
        $sql = "
            SELECT COALESCE(SUM(grand_total), 0) AS total 
            FROM " . RegistrationTransaction::model()->tableName() . "
            WHERE customer_id = :customer_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date
            GROUP BY customer_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':customer_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getReceivableReport($endDate, $branchId, $insuranceCompanyId) {
        $branchConditionSql = '';
        $insuranceConditionSql = '';
        
        $params = array(
            ':customer_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($insuranceCompanyId)) {
            $insuranceConditionSql = ' AND r.insurance_company_id = :insurance_company_id';
            $params[':insurance_company_id'] = $insuranceCompanyId;
        }
        
        $sql = "
            SELECT invoice_number, invoice_date, due_date, v.plate_number AS vehicle, COALESCE(p.total_price, 0) AS total_price, COALESCE(p.payment_amount, 0) AS payment_amount, COALESCE(p.payment_left, 0) AS payment_left, i.name as insurance_name 
            FROM " . InvoiceHeader::model()->tableName() . " p 
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = p.vehicle_id
            INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = p.registration_transaction_id
            LEFT OUTER JOIN " . InsuranceCompany::model()->tableName() . " i ON i.id = r.insurance_company_id
            WHERE p.customer_id = :customer_id AND p.payment_left > 100.00 AND p.invoice_date <= :end_date " . $branchConditionSql . $insuranceConditionSql . "
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
