<?php

/**
 * This is the model class for table "{{branch}}".
 *
 * The followings are the available columns in table '{{branch}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $zipcode
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property string $status
 * @property integer $coa_prefix
 * @property integer $is_deleted
 * @property integer $user_id_deleted
 * @property integer $user_id_created
 * @property integer $user_id_updated
 * @property integer $is_approved
 * @property integer $user_id_approved
 * @property integer $user_id_rejected
 * @property string $deleted_datetime
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property string $approved_datetime
 * @property string $rejected_datetime
 *
 * The followings are the available model relations:
 * @property Province $province
 * @property City $city
 * @property Company[] $companies
 * @property ConsignmentInHeader[] $consignmentInHeaders
 * @property BranchFax[] $branchFaxes
 * @property BranchPhone[] $branchPhones
 * @property BranchWarehouse[] $branchWarehouses
 * @property CompanyBranch[] $companyBranches
 * @property DivisionBranch[] $divisionBranches
 * @property EmployeeBranchDivisionPositionLevel[] $employeeBranchDivisionPositionLevels
 * @property EquipmentBranch[] $equipmentBranches
 * @property Equipments[] $equipments
 * @property RegistrationTransaction[] $registrationTransactions
 * @property TransactionDeliveryOrder[] $transactionDeliveryOrders
 * @property TransactionDeliveryOrder[] $transactionDeliveryOrders1
 * @property TransactionPurchaseOrderDetailRequest[] $transactionPurchaseOrderDetailRequests
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionReceiveItem[] $transactionReceiveItems1
 * @property TransactionRequestOrder[] $transactionRequestOrders
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property TransactionReturnItem[] $transactionReturnItems1
 * @property TransactionReturnOrder[] $transactionReturnOrders
 * @property TransactionReturnOrder[] $transactionReturnOrders1
 * @property TransactionSalesOrder[] $transactionSalesOrders
 * @property TransactionSalesOrder[] $transactionSalesOrders1
 * @property Warehouse[] $warehouses
 * @property BranchCoaInterbranches[] $branchCoaInterbranches
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdDeleted $userIdDeleted
 * @property UserIdCreated $userIdCreated
 */
class Branch extends CActiveRecord {

    public $city_name;
    public $province_name;
    public $sort_code;
    public $coa_interbranch_inventory_name;
    public $coa_interbranch_inventory_code;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{branch}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that,
        // will receive user inputs.
        return array(
            array('name, address,province_id, city_id, zipcode, email, coa_prefix,code', 'required'),
            array('coa_prefix', 'unique'),
            array('province_id ,city_id, company_id, coa_interbranch_inventory, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('code, phone, fax', 'length', 'max' => 20),
            array('name', 'length', 'max' => 30),
            array('coa_prefix', 'length', 'max' => 3),
            array('zipcode,status', 'length', 'max' => 10),
            array('email', 'length', 'max' => 60),
            array('code', 'unique'),
            array('email', 'email'),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, name, address, province_id, city_id, zipcode, phone, fax, email, status,city_name, province_name, sort_code, coa_prefix, company_id, coa_interbranch_inventory, coa_interbranch_inventory_name, coa_interbranch_inventory_code, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'branchFaxes' => array(self::HAS_MANY, 'BranchFax', 'branch_id'),
            'branchPhones' => array(self::HAS_MANY, 'BranchPhone', 'branch_id'),
            'branchWarehouses' => array(self::HAS_MANY, 'BranchWarehouse', 'branch_id'),
            'divisionBranches' => array(self::HAS_MANY, 'DivisionBranch', 'branch_id'),
            'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
            'companies' => array(self::HAS_MANY, 'Company', 'branch_id'),
            'companyBranches' => array(self::HAS_MANY, 'CompanyBranch', 'branch_id'),
            'consignmentInHeaders' => array(self::HAS_MANY, 'ConsignmentInHeader', 'receive_branch'),
            'employeeBranchDivisionPositionLevels' => array(self::HAS_MANY, 'EmployeeBranchDivisionPositionLevel', 'branch_id'),
            'equipmentBranches' => array(self::HAS_MANY, 'EquipmentBranch', 'branch_id'),
            'equipments' => array(self::HAS_MANY, 'Equipments', 'branch_id'),
            'registrationTransactions' => array(self::HAS_MANY, 'RegistrationTransaction', 'branch_id'),
            'transactionDeliveryOrders' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'sender_branch_id'),
            'transactionDeliveryOrders1' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'destination_branch'),
            'transactionPurchaseOrderDetailRequests' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetailRequest', 'purchase_request_branch_id'),
            'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'recipient_branch_id'),
            'transactionReceiveItems1' => array(self::HAS_MANY, 'TransactionReceiveItem', 'destination_branch'),
            'transactionRequestOrders' => array(self::HAS_MANY, 'TransactionRequestOrder', 'requester_branch_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'recipient_branch_id'),
            'transactionReturnItems1' => array(self::HAS_MANY, 'TransactionReturnItem', 'destination_branch'),
            'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'recipient_branch_id'),
            'transactionReturnOrders1' => array(self::HAS_MANY, 'TransactionReturnOrder', 'branch_destination_id'),
            'transactionSalesOrders' => array(self::HAS_MANY, 'TransactionSalesOrder', 'requester_branch_id'),
            'transactionSalesOrders1' => array(self::HAS_MANY, 'TransactionSalesOrder', 'approved_branch_id'),
            'warehouses' => array(self::HAS_MANY, 'Warehouse', 'branch_id'),
            'paymentIns' => array(self::HAS_MANY, 'PaymentIn', 'branch_id'),
            'coaInterbranchInventory' => array(self::BELONGS_TO, 'Coa', 'coa_interbranch_inventory'),
            'branchCoaInterbranches' => array(self::HAS_MANY, 'BranchCoaInterbranch', 'branch_id_from'),
            'userIdApproved' => array(self::BELONGS_TO, 'Users', 'user_id_approved'),
            'userIdRejected' => array(self::BELONGS_TO, 'Users', 'user_id_rejected'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdDeleted' => array(self::BELONGS_TO, 'Users', 'user_id_deleted'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'address' => 'Address',
            'province_id' => 'Province',
            'city_id' => 'City',
            'zipcode' => 'Zipcode',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'email' => 'Email',
            'status' => 'Status',
            'province_name' => 'Province',
            'city_name' => 'City',
            'coa_prefix' => 'Coa Prefix',
            'company_id' => 'Company',
            'coa_interbranch_inventory' => 'Coa Interbranch Inventory',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('SUBSTRING(t.code, 4)', $this->sort_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('zipcode', $this->zipcode, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('coa_prefix', $this->coa_prefix);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('LOWER(status)', strtolower($this->status), true);
        $criteria->compare('coa_interbranch_inventory', $this->coa_interbranch_inventory);

        $criteria->together = 'true';
        $criteria->with = array('province', 'city', 'coaInterbranchInventory');
        $criteria->compare('province.name', $this->province_name, true);
        $criteria->compare('city.name', $this->city_name, true);
        $criteria->compare('coaInterbranchInventory.name', $this->coa_interbranch_inventory_name, true);
        $criteria->compare('coaInterbranchInventory.code', $this->coa_interbranch_inventory_code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.name',
                'attributes' => array(
                    'code' => array(
                        'asc' => 'cast(SUBSTRING(t.code, 3) as unsigned) ASC',
                        'desc' => 'cast(SUBSTRING(t.code, 3) as unsigned) DESC',
                    ),
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
                'pageSize' => 10,
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
