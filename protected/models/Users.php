<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $activkey
 * @property integer $superuser
 * @property integer $status
 * @property string $create_at
 * @property string $lastvisit_at
 * @property integer $employee_id
 * @property integer $branch_id
 * @property integer $is_main_access
 * @property integer $is_front_access
 *
 * The followings are the available model relations:
 * @property Profiles $profiles
 * @property CashTransaction[] $cashTransactions
 * @property CashTransactionApproval[] $cashTransactionApprovals
 * @property ConsignmentOutHeader[] $consignmentOutHeaders
 * @property EmployeeAttendance[] $employeeAttendances
 * @property EmployeeDayoffApproval[] $employeeDayoffApprovals
 * @property JurnalPenyesuaian[] $jurnalPenyesuaians
 * @property JurnalPenyesuaianApproval[] $jurnalPenyesuaianApprovals
 * @property MovementOutHeader[] $movementOutHeaders
 * @property PaymentIn[] $paymentIns
 * @property PaymentInApproval[] $paymentInApprovals
 * @property PaymentOut[] $paymentOuts
 * @property PaymentOutApproval[] $paymentOutApprovals
 * @property TransactionDeliveryOrder[] $transactionDeliveryOrders
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property TransactionReturnItemApproval[] $transactionReturnItemApprovals
 * @property TransactionReturnOrder[] $transactionReturnOrders
 * @property TransactionReturnOrderApproval[] $transactionReturnOrderApprovals
 * @property TransactionTransferRequest[] $transactionTransferRequests
 * @property TransactionTransferRequest[] $transactionTransferRequests1
 */
class Users extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    public $branch_name;
    public $employee_name;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('create_at', 'required'),
            array('superuser, status, employee_id, branch_id, is_main_access, is_front_access', 'numerical', 'integerOnly' => true),
            array('username', 'length', 'max' => 20),
            array('password, email, activkey', 'length', 'max' => 128),
            array('lastvisit_at', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, username, password, email, activkey, superuser, status, create_at, lastvisit_at, employee_id, branch_id,employee_name, branch_name, is_main_access, is_front_access', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'profiles' => array(self::HAS_ONE, 'Profiles', 'user_id'),
            'cashTransactions' => array(self::HAS_MANY, 'CashTransaction', 'user_id'),
            'cashTransactionApprovals' => array(self::HAS_MANY, 'CashTransactionApproval', 'supervisor_id'),
            'consignmentOutHeaders' => array(self::HAS_MANY, 'ConsignmentOutHeader', 'sender_id'),
            'employeeAttendances' => array(self::HAS_MANY, 'EmployeeAttendance', 'user_id'),
            'employeeDayoffApprovals' => array(self::HAS_MANY, 'EmployeeDayoffApproval', 'supervisor_id'),
            'jurnalPenyesuaians' => array(self::HAS_MANY, 'JurnalPenyesuaian', 'user_id'),
            'jurnalPenyesuaianApprovals' => array(self::HAS_MANY, 'JurnalPenyesuaianApproval', 'supervisor_id'),
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'user_id'),
            'paymentIns' => array(self::HAS_MANY, 'PaymentIn', 'user_id'),
            'paymentInApprovals' => array(self::HAS_MANY, 'PaymentInApproval', 'supervisor_id'),
            'paymentOuts' => array(self::HAS_MANY, 'PaymentOut', 'user_id'),
            'paymentOutApprovals' => array(self::HAS_MANY, 'PaymentOutApproval', 'supervisor_id'),
            'transactionDeliveryOrders' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'sender_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'recipient_id'),
            'transactionReturnItemApprovals' => array(self::HAS_MANY, 'TransactionReturnItemApproval', 'supervisor_id'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'recipient_id'),
            'transactionReturnOrderApprovals' => array(self::HAS_MANY, 'TransactionReturnOrderApproval', 'supervisor_id'),
            'transactionTransferRequests' => array(self::HAS_MANY, 'TransactionTransferRequest', 'approved_by'),
            'transactionTransferRequests1' => array(self::HAS_MANY, 'TransactionTransferRequest', 'requester_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'activkey' => 'Activkey',
            'superuser' => 'Superuser',
            'status' => 'Status',
            'create_at' => 'Create At',
            'lastvisit_at' => 'Lastvisit At',
            'employee_id' => 'Employee',
            'branch_id' => 'Branch',
            'is_main_access' => 'Is Main Access',
            'is_front_access' => 'Is Front Access',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('activkey', $this->activkey, true);
        $criteria->compare('superuser', $this->superuser);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_at', $this->create_at, true);
        $criteria->compare('lastvisit_at', $this->lastvisit_at, true);
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('is_main_access', $this->is_main_access);
        $criteria->compare('is_front_access', $this->is_front_access);

        $criteria->together = true;
        $criteria->with = array('branch', 'employee');
        $criteria->compare('branch.name', $this->branch_name, true);
        $criteria->compare('employee.name', $this->employee_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getUserCreatedRegistrationCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE user_id = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedWorkOrderCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE user_id = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND work_order_number is not null";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedMovementOutCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . MovementOutHeader::model()->tableName() . "
                WHERE user_id = :user_id AND substr(date_posting, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedInvoiceCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . InvoiceHeader::model()->tableName() . "
                WHERE user_id = :user_id AND substr(invoice_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedPaymentInCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . PaymentIn::model()->tableName() . "
                WHERE user_id = :user_id AND substr(payment_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedPurchaseCount($startDate, $endDate) {
        $sql = "SELECT COUNT(requester_id)
                FROM " . TransactionPurchaseOrder::model()->tableName() . "
                WHERE requester_id = :user_id AND substr(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedReceiveCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_receive)
                FROM " . TransactionReceiveItem::model()->tableName() . "
                WHERE user_id_receive = :user_id AND substr(receive_item_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedMovementInCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . MovementInHeader::model()->tableName() . "
                WHERE user_id = :user_id AND substr(date_posting, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedDeliveryCount($startDate, $endDate) {
        $sql = "SELECT COUNT(sender_id)
                FROM " . TransactionDeliveryOrder::model()->tableName() . "
                WHERE sender_id = :user_id AND substr(delivery_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedTransferRequestCount($startDate, $endDate) {
        $sql = "SELECT COUNT(requester_id)
                FROM " . TransactionTransferRequest::model()->tableName() . "
                WHERE requester_id = :user_id AND substr(transfer_request_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedSentRequestCount($startDate, $endDate) {
        $sql = "SELECT COUNT(requester_id)
                FROM " . TransactionSentRequest::model()->tableName() . "
                WHERE requester_id = :user_id AND substr(sent_request_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCreatedCashTransactionCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id)
                FROM " . CashTransaction::model()->tableName() . "
                WHERE user_id = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedRegistrationCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_edited)
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE user_id_edited = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedWorkOrderCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_edited)
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE user_id_edited = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND work_order_number is not null";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedMovementOutCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . MovementOutHeader::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(date_posting, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedInvoiceCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_edited)
                FROM " . InvoiceHeader::model()->tableName() . "
                WHERE user_id_edited = :user_id AND substr(invoice_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedPaymentInCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_edited)
                FROM " . PaymentIn::model()->tableName() . "
                WHERE user_id_edited = :user_id AND substr(payment_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedPurchaseCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . TransactionPurchaseOrder::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedReceiveCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . TransactionReceiveItem::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(receive_item_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedMovementInCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . MovementInHeader::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(date_posting, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedDeliveryCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . TransactionDeliveryOrder::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(delivery_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedTransferRequestCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . TransactionTransferRequest::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(transfer_request_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedSentRequestCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . TransactionSentRequest::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(sent_request_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserUpdatedCashTransactionCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_updated)
                FROM " . CashTransaction::model()->tableName() . "
                WHERE user_id_updated = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledRegistrationCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledWorkOrderCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND work_order_number is not null";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledMovementOutCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . MovementOutHeader::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(date_posting, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledInvoiceCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . InvoiceHeader::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(invoice_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledPaymentInCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . PaymentIn::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(payment_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledPurchaseCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . TransactionPurchaseOrder::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledReceiveCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . TransactionReceiveItem::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(receive_item_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledMovementInCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . MovementInHeader::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(date_posting, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledDeliveryCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . TransactionDeliveryOrder::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(delivery_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledTransferRequestCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . TransactionTransferRequest::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(transfer_request_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledSentRequestCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . TransactionSentRequest::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(sent_request_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getUserCancelledCashTransactionCount($startDate, $endDate) {
        $sql = "SELECT COUNT(user_id_cancelled)
                FROM " . CashTransaction::model()->tableName() . "
                WHERE user_id_cancelled = :user_id AND substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':user_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
}
