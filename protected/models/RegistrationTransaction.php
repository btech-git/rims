<?php

/**
 * This is the model class for table "{{registration_transaction}}".
 *
 * The followings are the available columns in table '{{registration_transaction}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $repair_type
 * @property string $problem
 * @property integer $customer_id
 * @property integer $pic_id
 * @property integer $vehicle_id
 * @property integer $branch_id
 * @property integer $user_id
 * @property integer $total_quickservice
 * @property string $total_quickservice_price
 * @property integer $total_service
 * @property string $subtotal_service
 * @property string $discount_service
 * @property string $total_service_price
 * @property string $total_product
 * @property string $subtotal_product
 * @property string $discount_product
 * @property string $total_product_price
 * @property integer $is_quick_service
 * @property integer $is_insurance
 * @property integer $insurance_company_id
 * @property string $grand_total
 * @property string $work_order_number
 * @property string $work_order_date
 * @property string $work_order_time
 * @property string $status
 * @property string $payment_status
 * @property string $payment_type
 * @property integer $laststatusupdate_by
 * @property string $sales_order_number
 * @property string $sales_order_date
 * @property integer $ppn
 * @property integer $pph
 * @property string $subtotal
 * @property string $ppn_price
 * @property string $pph_price
 * @property string $vehicle_mileage
 * @property string $note
 * @property integer $is_passed
 * @property integer $total_time
 * @property string $service_status
 * @property integer $priority_level
 * @property string $customer_work_order_number
 * @property string $vehicle_status
 * @property string $transaction_date_out
 * @property string $transaction_time_out
 * @property integer $employee_id_assign_mechanic
 * @property integer $employee_id_sales_person
 * @property integer $tax_percentage
 * @property string $created_datetime
 * @property string $cancelled_datetime
 * @property integer $user_id_cancelled
 * @property string $feedback
 * @property string $edited_datetime
 * @property integer $user_id_edited
 * @property integer $sale_estimation_header_id
 * @property string $product_status
 * @property string $vehicle_entry_datetime
 * @property string $vehicle_exit_datetime
 * @property string $vehicle_start_service_datetime
 * @property string $vehicle_finish_service_datetime
 * @property string $initial_condition_memo
 * @property string $initial_recommendation
 * @property string $final_condition_memo
 * @property string $final_recommendation
 * @property integer $is_new_customer
 * @property integer $total_quantity_package
 * @property string $total_price_package
 * @property string $downpayment_transaction_number
 * @property string $downpayment_transaction_date
 * @property string $downpayment_amount
 * @property string $downpayment_status
 * @property string $downpayment_note
 * @property string $downpayment_created_datetime
 * @property integer $user_id_created_downpayment
 * @property integer $is_downpayment_paid
 * @property integer $employee_id_mechanic_helper_1
 * @property integer $employee_id_mechanic_helper_2
 * @property integer $employee_id_mechanic_helper_3
 *
 * The followings are the available model relations:
 * @property InvoiceHeader[] $invoiceHeaders
 * @property MaterialRequestHeader[] $materialRequestHeaders
 * @property MovementOutHeader[] $movementOutHeaders
 * @property MovementOutHeader[] $movementOutHeaders1
 * @property PaymentInDetail[] $paymentInDetails
 * @property RegistrationApproval[] $registrationApprovals
 * @property RegistrationBodyRepairDetail[] $registrationBodyRepairDetails
 * @property RegistrationDamage[] $registrationDamages
 * @property RegistrationInsuranceData[] $registrationInsuranceDatas
 * @property RegistrationMemo[] $registrationMemos
 * @property RegistrationPackage[] $registrationPackages
 * @property RegistrationPayment[] $registrationPayments
 * @property RegistrationProduct[] $registrationProducts
 * @property RegistrationQuickService[] $registrationQuickServices
 * @property RegistrationRealizationProcess[] $registrationRealizationProcesses
 * @property RegistrationService[] $registrationServices
 * @property RegistrationServiceManagement[] $registrationServiceManagements
 * @property Users $userIdCreatedDownpayment
 * @property Employee $employeeIdMechanicHelper1
 * @property Employee $employeeIdMechanicHelper2
 * @property Employee $employeeIdMechanicHelper3
 * @property Employee $employeeIdAssignMechanic
 * @property Employee $employeeIdSalesPerson
 * @property Users $userIdCancelled
 * @property Users $userIdEdited
 * @property SaleEstimationHeader $saleEstimationHeader
 * @property CustomerPic $pic
 * @property Branch $branch
 * @property InsuranceCompany $insuranceCompany
 * @property Users $user
 * @property Customer $customer
 * @property Vehicle $vehicle
 * @property TransactionPurchaseOrder[] $transactionPurchaseOrders
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property VehicleInspection[] $vehicleInspections
 * @property WorkOrderExpenseHeader[] $workOrderExpenseHeaders
 */
class RegistrationTransaction extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'RG';
    const CONSTANT_WORK_ORDER = 'WO';
    const CONSTANT_SALE_ORDER = 'SL';
    const CONSTANT_DOWNPAYMENT = 'DP';
    const PRIORITY_HIGH = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 3;
    const PRIORITY_HIGH_LITERAL = 'HIGH';
    const PRIORITY_MEDIUM_LITERAL = 'Medium';
    const PRIORITY_LOW_LITERAL = 'low';

    public $customer_name;
    public $customer_type;
    public $pic_name;
    public $choice;
    public $plate_number;
    public $branch_name;
    public $car_make_code;
    public $car_model_code;
    public $car_color;
    public $invoice_number;
    public $search_product;
    public $search_service;
    public $search_movement;
    public $transaction_date_from;
    public $transaction_date_to;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{registration_transaction}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('customer_id, vehicle_id', 'required'),
            array('customer_id, pic_id, vehicle_id, branch_id, user_id, total_quickservice, total_service, is_quick_service, is_insurance, insurance_company_id, laststatusupdate_by, ppn, pph, is_passed, total_time, priority_level, employee_id_assign_mechanic, employee_id_sales_person, tax_percentage, user_id_cancelled, user_id_edited, sale_estimation_header_id, is_new_customer, total_quantity_package, user_id_created_downpayment, is_downpayment_paid, employee_id_mechanic_helper_1, employee_id_mechanic_helper_2, employee_id_mechanic_helper_3', 'numerical', 'integerOnly' => true),
            array('transaction_number, repair_type, work_order_number, payment_status, payment_type, sales_order_number, customer_work_order_number, downpayment_transaction_number, downpayment_status', 'length', 'max' => 30),
            array('total_quickservice_price, subtotal_service, discount_service, total_service_price, subtotal_product, discount_product, total_product_price, grand_total, total_price_package, downpayment_amount', 'length', 'max' => 18),
            array('total_product, subtotal, ppn_price, pph_price', 'length', 'max' => 10),
            array('status', 'length', 'max' => 50),
            array('service_status, product_status', 'length', 'max' => 100),
            array('vehicle_status', 'length', 'max' => 20),
            array('transaction_date, problem, work_order_date, work_order_time, sales_order_date, vehicle_mileage, note, transaction_date_out, transaction_time_out, created_datetime, cancelled_datetime, feedback, edited_datetime, vehicle_entry_datetime, vehicle_exit_datetime, vehicle_start_service_datetime, vehicle_finish_service_datetime, initial_condition_memo, initial_recommendation, final_condition_memo, final_recommendation, downpayment_transaction_date, downpayment_note, downpayment_created_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, repair_type, problem, customer_id, pic_id, vehicle_id, branch_id, user_id, total_quickservice, total_quickservice_price, total_service, subtotal_service, discount_service, total_service_price, total_product, subtotal_product, discount_product, total_product_price, is_quick_service, is_insurance, insurance_company_id, grand_total, work_order_number, work_order_date, work_order_time, status, payment_status, payment_type, laststatusupdate_by, sales_order_number, sales_order_date, ppn, pph, subtotal, ppn_price, pph_price, vehicle_mileage, note, is_passed, total_time, service_status, priority_level, customer_work_order_number, vehicle_status, transaction_date_out, transaction_time_out, employee_id_assign_mechanic, employee_id_sales_person, tax_percentage, created_datetime, cancelled_datetime, user_id_cancelled, feedback, edited_datetime, user_id_edited, sale_estimation_header_id, product_status, vehicle_entry_datetime, vehicle_exit_datetime, vehicle_start_service_datetime, vehicle_finish_service_datetime, initial_condition_memo, initial_recommendation, final_condition_memo, final_recommendation, is_new_customer, total_quantity_package, total_price_package, downpayment_transaction_number, downpayment_transaction_date, downpayment_amount, downpayment_status, downpayment_note, downpayment_created_datetime, user_id_created_downpayment, is_downpayment_paid, employee_id_mechanic_helper_1, employee_id_mechanic_helper_2, employee_id_mechanic_helper_3', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoiceHeaders' => array(self::HAS_MANY, 'InvoiceHeader', 'registration_transaction_id'),
            'materialRequestHeaders' => array(self::HAS_MANY, 'MaterialRequestHeader', 'registration_transaction_id'),
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'registration_transaction_id'),
            'movementOutHeaders1' => array(self::HAS_MANY, 'MovementOutHeader', 'registration_service_id'),
            'paymentInDetails' => array(self::HAS_MANY, 'PaymentInDetail', 'registration_transaction_id'),
            'registrationApprovals' => array(self::HAS_MANY, 'RegistrationApproval', 'registration_transaction_id'),
            'registrationBodyRepairDetails' => array(self::HAS_MANY, 'RegistrationBodyRepairDetail', 'registration_transaction_id'),
            'registrationDamages' => array(self::HAS_MANY, 'RegistrationDamage', 'registration_transaction_id'),
            'registrationInsuranceDatas' => array(self::HAS_MANY, 'RegistrationInsuranceData', 'registration_transaction_id'),
            'registrationMemos' => array(self::HAS_MANY, 'RegistrationMemo', 'registration_transaction_id'),
            'registrationPackages' => array(self::HAS_MANY, 'RegistrationPackage', 'registration_transaction_id'),
            'registrationPayments' => array(self::HAS_MANY, 'RegistrationPayment', 'registration_transaction_id'),
            'registrationProducts' => array(self::HAS_MANY, 'RegistrationProduct', 'registration_transaction_id'),
            'registrationQuickServices' => array(self::HAS_MANY, 'RegistrationQuickService', 'registration_transaction_id'),
            'registrationRealizationProcesses' => array(self::HAS_MANY, 'RegistrationRealizationProcess', 'registration_transaction_id'),
            'registrationServices' => array(self::HAS_MANY, 'RegistrationService', 'registration_transaction_id'),
            'registrationServiceManagements' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'registration_transaction_id'),
            'userIdCreatedDownpayment' => array(self::BELONGS_TO, 'Users', 'user_id_created_downpayment'),
            'employeeIdMechanicHelper1' => array(self::BELONGS_TO, 'Employee', 'employee_id_mechanic_helper_1'),
            'employeeIdMechanicHelper2' => array(self::BELONGS_TO, 'Employee', 'employee_id_mechanic_helper_2'),
            'employeeIdMechanicHelper3' => array(self::BELONGS_TO, 'Employee', 'employee_id_mechanic_helper_3'),
            'employeeIdAssignMechanic' => array(self::BELONGS_TO, 'Employee', 'employee_id_assign_mechanic'),
            'employeeIdSalesPerson' => array(self::BELONGS_TO, 'Employee', 'employee_id_sales_person'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'userIdEdited' => array(self::BELONGS_TO, 'Users', 'user_id_edited'),
            'saleEstimationHeader' => array(self::BELONGS_TO, 'SaleEstimationHeader', 'sale_estimation_header_id'),
            'pic' => array(self::BELONGS_TO, 'CustomerPic', 'pic_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'transactionPurchaseOrders' => array(self::HAS_MANY, 'TransactionPurchaseOrder', 'registration_transaction_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'registration_transaction_id'),
            'vehicleInspections' => array(self::HAS_MANY, 'VehicleInspection', 'registration_transaction_id'),
            'workOrderExpenseHeaders' => array(self::HAS_MANY, 'WorkOrderExpenseHeader', 'registration_transaction_id'),
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'repair_type' => 'Repair Type',
            'problem' => 'Problem',
            'customer_id' => 'Customer',
            'pic_id' => 'Pic',
            'vehicle_id' => 'Vehicle',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'total_quickservice' => 'Total Quickservice',
            'total_quickservice_price' => 'Total Quickservice Price',
            'total_service' => 'Total Service',
            'subtotal_service' => 'Subtotal Service',
            'discount_service' => 'Discount Service',
            'total_service_price' => 'Total Service Price',
            'total_product' => 'Total Product',
            'subtotal_product' => 'Subtotal Product',
            'discount_product' => 'Discount Product',
            'total_product_price' => 'Total Product Price',
            'is_quick_service' => 'Is Quick Service',
            'is_insurance' => 'Is Insurance',
            'insurance_company_id' => 'Insurance Company',
            'grand_total' => 'Grand Total',
            'work_order_number' => 'Work Order Number',
            'work_order_date' => 'Work Order Date',
            'work_order_time' => 'Work Order Time',
            'status' => 'Status',
            'payment_status' => 'Payment Status',
            'payment_type' => 'Payment Type',
            'laststatusupdate_by' => 'Laststatusupdate By',
            'sales_order_number' => 'Sales Order Number',
            'sales_order_date' => 'Sales Order Date',
            'ppn' => 'Ppn',
            'pph' => 'Pph',
            'subtotal' => 'Subtotal',
            'ppn_price' => 'Ppn Price',
            'pph_price' => 'Pph Price',
            'vehicle_mileage' => 'Vehicle Mileage',
            'note' => 'Note',
            'is_passed' => 'Is Passed',
            'total_time' => 'Total Time',
            'service_status' => 'Service Status',
            'priority_level' => 'Priority Level',
            'customer_work_order_number' => 'Customer WO #',
            'vehicle_status' => 'Vehicle Status',
            'transaction_date_out' => 'Transaction Date Out',
            'transaction_time_out' => 'Transaction Time Out',
            'employee_id_assign_mechanic' => 'Lead Mechanic',
            'employee_id_sales_person' => 'Sales Person',
            'tax_percentage' => 'Tax Percentage',
            'created_datetime' => 'Created Datetime',
            'cancelled_datetime' => 'Cancelled Datetime',
            'user_id_cancelled' => 'User Id Cancelled',
            'feedback' => 'Feedback',
            'edited_datetime' => 'Edited Datetime',
            'user_id_edited' => 'User Id Edited',
            'sale_estimation_header_id' => 'Sales Estimation',
            'product_status' => 'Product Status',
            'vehicle_entry_datetime' => 'Vehicle Entry Datetime',
            'vehicle_exit_datetime' => 'Vehicle Exit Datetime',
            'vehicle_start_service_datetime' => 'Vehicle Start Service Datetime',
            'vehicle_finish_service_datetime' => 'Vehicle Finish Service Datetime',
            'initial_condition_memo' => 'Initial Condition Memo',
            'initial_recommendation' => 'Initial Recommendation',
            'final_condition_memo' => 'Final Condition Memo',
            'final_recommendation' => 'Final Recommendation',
            'is_new_customer' => 'Is New Customer',
            'total_quantity_package' => 'Total Quantity Package',
            'total_price_package' => 'Total Price Package',
            'downpayment_transaction_number' => 'Downpayment Transaction Number',
            'downpayment_transaction_date' => 'Downpayment Transaction Date',
            'downpayment_amount' => 'Downpayment Amount',
            'downpayment_status' => 'Downpayment Status',
            'downpayment_note' => 'Downpayment Note',
            'downpayment_created_datetime' => 'Downpayment Created Datetime',
            'user_id_created_downpayment' => 'User Id Created Downpayment',
            'is_downpayment_paid' => 'Is Downpayment Paid',
            'employee_id_mechanic_helper_1' => 'Mechanic Helper 1',
            'employee_id_mechanic_helper_2' => 'Mechanic Helper 2',
            'employee_id_mechanic_helper_3' => 'Mechanic Helper 3',
        );
    }

    public function search() {

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.work_order_time', $this->work_order_time, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('vehicle_status', $this->vehicle_status);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);
        $criteria->compare('transaction_date_out', $this->transaction_date_out, true);
        $criteria->compare('transaction_time_out', $this->transaction_time_out, true);
        $criteria->compare('employee_id_assign_mechanic', $this->employee_id_assign_mechanic);
        $criteria->compare('employee_id_sales_person', $this->employee_id_sales_person);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.sale_estimation_header_id', $this->sale_estimation_header_id);
        $criteria->compare('t.is_new_customer', $this->is_new_customer);

        $arrayTransactionDate = array($this->transaction_date_from, $this->transaction_date_to);
        $criteria->mergeWith($this->dateRangeSearchCriteria('transaction_date', $arrayTransactionDate));

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake', 'carModel', 'color'
                ),
            ), 
            'customer', 
            'pic',
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);
        $criteria->addSearchCondition('pic.name', $this->pic_name, true);
        $criteria->compare('carMake.name', $this->car_make_code, true);
        $criteria->compare('carModel.name', $this->car_model_code, true);
        $criteria->compare('vehicle.color_id', $this->car_color, true);

        if ($this->search_service != NULL) {
            $criteria->with = array('registrationServices' => array('together' => true, 'with' => array('service')));
            $criteria->compare('service.name', $this->search_service, true);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
                'attributes' => array(
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchAdmin() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);
        $criteria->compare('t.branch_id', $this->branch_id);

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake', 'carModel', 'color'
                ),
            ), 
            'customer', 
            'pic',
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);
        $criteria->addSearchCondition('pic.name', $this->pic_name, true);
        $criteria->compare('carMake.name', $this->car_make_code, true);
        $criteria->compare('carModel.name', $this->car_model_code, true);
        $criteria->compare('vehicle.color_id', $this->car_color, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
    
    public function searchReport() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);
        $criteria->compare('t.branch_id', $this->branch_id);

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake', 'carModel', 'color'
                ),
            ), 
            'customer', 
            'pic',
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);
        $criteria->addSearchCondition('pic.name', $this->pic_name, true);
        $criteria->compare('carMake.name', $this->car_make_code, true);
        $criteria->compare('carModel.name', $this->car_model_code, true);
        $criteria->compare('vehicle.color_id', $this->car_color, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 500,
            ),
        ));
    }
    
    public function searchByProcessingWorkOrder() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake',
                    'carModel',
                ),
            ),
            'branch',
            'customer',
            'invoiceHeaders',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.service_status', $this->service_status);
        $criteria->compare('note', $this->note, true);

//        if (!empty($this->transaction_date_from) && !empty($this->transaction_date_to)) {
//            $criteria->addBetweenCondition('t.transaction_date', $this->transaction_date_from, $this->transaction_date_to);
//        }
        
        $criteria->addCondition("NOT EXISTS (
            SELECT i.registration_transaction_id
            FROM " . InvoiceHeader::model()->tableName() . " i
            WHERE t.id = i.registration_transaction_id
        ) AND t.work_order_number IS NOT NULL AND t.status NOT LIKE '%CANCELLED%' AND t.transaction_date > '2023-12-31'");

        $criteria->compare('carMake.id', $this->car_make_code, true);
        $criteria->compare('carModel.id', $this->car_model_code, true);
        $criteria->compare('vehicle.plate_number', $this->plate_number, true);

        $criteria->order = 't.transaction_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByCustomerWaitlist() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('t.transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('t.insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.work_order_time', $this->work_order_time, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('vehicle_status', $this->vehicle_status);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);
        $criteria->compare('transaction_date_out', $this->transaction_date_out, true);
        $criteria->compare('transaction_time_out', $this->transaction_time_out, true);
        $criteria->compare('employee_id_assign_mechanic', $this->employee_id_assign_mechanic);
        $criteria->compare('employee_id_sales_person', $this->employee_id_sales_person);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);
        $criteria->compare('t.sale_estimation_header_id', $this->sale_estimation_header_id);
        $criteria->compare('t.is_new_customer', $this->is_new_customer);

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle', 
            'customer', 
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
                'attributes' => array(
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function getInvoice($data) {
        $invoiceNumber = '';
        $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $data->id));
        foreach ($invoices as $key => $invoice) {
            if ($invoice->status !== 'CANCELLED!!!') {
                $invoiceNumber = $invoice->invoice_number;
            } else {
                $invoiceNumber = 'CANCELLED!!!';
            }
        }
        return $invoiceNumber;
    }

    public function getProducts() {
        $products = array();

        foreach ($this->registrationProducts as $registrationProduct) {
            $products[] = $registrationProduct->product->name . ', ';
        }

        return $this->search_product = implode('', $products);
    }

    public function getServices() {
        $services = array();

        foreach ($this->registrationServices as $registrationService) {
            $services[] = $registrationService->service->name . ', ';
        }

        return $this->search_service = implode('', $services);
    }

    public function getMovementOuts() {
        $movementOuts = array();

        foreach ($this->movementOutHeaders as $movementOut) {
            $movementOuts[] = $movementOut->movement_out_no . ', ';
        }

        return $this->search_movement = implode('', $movementOuts);
    }

    public function getPpnLiteral() {
        return ($this->ppn == 0) ? '0%' : '11%';
    }

    public function getPphLiteral() {
        return ($this->ppn == 0) ? '0%' : '2.5%';
    }
    
    public function getTotalQuantityMovementLeft() {
        $total = 0;
        
        foreach ($this->registrationProducts as $registrationProduct) {
            $total+= $registrationProduct->quantity_movement_left;
        }
        
        return $total;
    }

    public function searchByWorkOrder() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake',
                    'carModel',
                ),
            ),
            'branch',
            'customer',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.service_status', $this->service_status);
        $criteria->compare('note', $this->note, true);

        if (!empty($this->transaction_date_from) && !empty($this->transaction_date_to)) {
            $criteria->addBetweenCondition('t.transaction_date', $this->transaction_date_from, $this->transaction_date_to);
        }
        
        $criteria->addCondition("t.work_order_number IS NOT NULL");

        $criteria->compare('carMake.id', $this->car_make_code, true);
        $criteria->compare('carModel.id', $this->car_model_code, true);
        $criteria->compare('vehicle.plate_number', $this->plate_number, true);

        $criteria->order = 't.transaction_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByInvoice() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake',
                    'carModel',
                ),
            ),
            'branch',
            'customer',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.payment_status', $this->payment_status);
        $criteria->compare('note', $this->note, true);

        if (!empty($this->transaction_date_from) || !empty($this->transaction_date_to)) {
            $criteria->addBetweenCondition('t.transaction_date', $this->transaction_date_from, $this->transaction_date_to);
        }
        
        $criteria->addCondition("t.status <> 'Finished' AND t.payment_status = 'INVOICING'");
        $criteria->compare('carMake.id', $this->car_make_code, true);
        $criteria->compare('carModel.id', $this->car_model_code, true);
        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->compare('customer.customer_type', $this->customer_type, true);

        $criteria->order = 't.transaction_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByCashier() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake',
                    'carModel',
                ),
            ),
            'branch',
            'customer',
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.payment_status', $this->payment_status);
        $criteria->compare('note', $this->note, true);

        if (!empty($this->transaction_date_from) || !empty($this->transaction_date_to)) {
            $criteria->addBetweenCondition('t.transaction_date', $this->transaction_date_from, $this->transaction_date_to);
        }
        
        $criteria->addCondition("t.status <> 'Finished' AND t.payment_status = 'INVOICING'");
        $criteria->compare('carMake.id', $this->car_make_code, true);
        $criteria->compare('carModel.id', $this->car_model_code, true);
        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->compare('customer.customer_type', $this->customer_type, true);

        $criteria->order = 't.transaction_date DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalTimeFormatted() {
        $time = $this->total_time;
        $daysCount = intval($time / (24 * 60 * 60));
        $time = $time % (24 * 60 * 60);
        $hoursCount = intval($time / (60 * 60));
        $time = $time % (60 * 60);
        $minutesCount = intval($time / 60);
        $time = $time % 60;
        $secondsCount = $time;

        $str = '';
        if ($daysCount > 0) {
            $str .= $daysCount . 'd ';
        }
        if ($hoursCount > 0) {
            $str .= $hoursCount . 'h ';
        }
        if ($minutesCount > 0) {
            $str .= $minutesCount . 'm ';
        }
        if ($secondsCount > 0) {
            $str .= $secondsCount . 's';
        }
        return $str;
    }

    public function getPriorityLiteral($type) {
        switch ($type) {
            case self::PRIORITY_HIGH: return self::PRIORITY_HIGH_LITERAL;
            case self::PRIORITY_MEDIUM: return self::PRIORITY_MEDIUM_LITERAL;
            case self::PRIORITY_LOW: return self::PRIORITY_LOW_LITERAL;
            default: return '';
        }
    }

    public function searchByMovementOut() {
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.quantity_movement_left), 0) AS quantity_remaining
            FROM " . RegistrationProduct::model()->tableName() . " d
            WHERE t.id = d.registration_transaction_id
            GROUP BY d.registration_transaction_id
            HAVING quantity_remaining > 0
        ) AND t.total_product > 0 AND t.transaction_date > '2022-12-31' AND t.user_id_cancelled IS null";

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('vehicle_status', $this->vehicle_status);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake', 'carModel', 'color'
                ),
            ), 
            'customer', 
            'pic',
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);
        $criteria->addSearchCondition('pic.name', $this->pic_name, true);
        $criteria->compare('carMake.name', $this->car_make_code, true);
        $criteria->compare('carModel.name', $this->car_model_code, true);
        $criteria->compare('vehicle.color_id', $this->car_color, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByMaterialRequest() {
        $criteria = new CDbCriteria;

        $criteria->condition = "NOT EXISTS (
            SELECT registration_transaction_id
            FROM " . MaterialRequestHeader::model()->tableName() . "
            WHERE t.id = registration_transaction_id
        ) AND t.total_service > 0";

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('vehicle_status', $this->vehicle_status);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake', 'carModel', 'color'
                ),
            ), 
            'customer', 
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);
        $criteria->compare('carMake.name', $this->car_make_code, true);
        $criteria->compare('carModel.name', $this->car_model_code, true);
        $criteria->compare('vehicle.color_id', $this->car_color, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByWorkOrderExpense() {
        $criteria = new CDbCriteria;

        $criteria->condition = "t.work_order_number IS NOT NULL AND t.work_order_number <> '' AND t.user_id_cancelled IS NULL";

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('vehicle_status', $this->vehicle_status);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    public function searchByIdleManagement() {
        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'registrationServices',
            'branch',
            'customer',
            'vehicle'
        );

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('t.vehicle_id', $this->vehicle_id);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('note', $this->note, true);

        $criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.service_status = 'Pending' AND t.status = 'Processing WO'");
        $criteria->order = 'registrationTransaction.priority_level ASC, registrationTransaction.work_order_date DESC, registrationTransaction.id ASC';
        
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('t.customer_id', $this->customer_id);
        $criteria->compare('pic_id', $this->pic_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('total_quickservice', $this->total_quickservice);
        $criteria->compare('total_quickservice_price', $this->total_quickservice_price, true);
        $criteria->compare('total_service', $this->total_service);
        $criteria->compare('subtotal_service', $this->subtotal_service, true);
        $criteria->compare('discount_service', $this->discount_service, true);
        $criteria->compare('total_service_price', $this->total_service_price, true);
        $criteria->compare('total_product', $this->total_product, true);
        $criteria->compare('subtotal_product', $this->subtotal_product, true);
        $criteria->compare('discount_product', $this->discount_product, true);
        $criteria->compare('total_product_price', $this->total_product_price, true);
        $criteria->compare('is_quick_service', $this->is_quick_service);
        $criteria->compare('is_insurance', $this->is_insurance);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('t.work_order_number', $this->work_order_number, true);
        $criteria->compare('t.work_order_date', $this->work_order_date, true);
        $criteria->compare('t.work_order_time', $this->work_order_time, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('laststatusupdate_by', $this->laststatusupdate_by);
        $criteria->compare('sales_order_number', $this->sales_order_number, true);
        $criteria->compare('sales_order_date', $this->sales_order_date, true);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('pph', $this->pph);
        $criteria->compare('subtotal', $this->subtotal, true);
        $criteria->compare('ppn_price', $this->ppn_price, true);
        $criteria->compare('pph_price', $this->pph_price, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('is_passed', $this->is_passed);
        $criteria->compare('total_time', $this->total_time);
        $criteria->compare('vehicle_status', $this->vehicle_status);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('customer_work_order_number', $this->customer_work_order_number);
        $criteria->compare('transaction_date_out', $this->transaction_date_out, true);
        $criteria->compare('transaction_time_out', $this->transaction_time_out, true);
        $criteria->compare('employee_id_assign_mechanic', $this->employee_id_assign_mechanic);
        $criteria->compare('employee_id_sales_person', $this->employee_id_sales_person);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle' => array(
                'with' => array(
                    'carMake', 'carModel'
                ),
            ), 
            'customer', 
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->compare('carMake.name', $this->car_make_code, true);
        $criteria->compare('carModel.name', $this->car_model_code, true);

        $criteria->addCondition("
            t.id IN (
                SELECT registration_transaction_id FROM " . InvoiceHeader::model()->tableName() . "
            ) AND t.branch_id IN (
                SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId
            )
        ");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    public function getFormattedDurationTime() {
        $totalTime = 0;
        
        foreach($this->registrationServices as $detail) {
            $totalTime += $detail->total_time;
        }
        
        $hours = floor($totalTime / 3600);
        $minutes = floor($totalTime / 60 % 60);
        $seconds = floor($totalTime % 60);
        
        return sprintf('%dh %dm %ds', $hours, $minutes, $seconds);
    }
    
    public static function graphSale() {
        
        $sql = "SELECT SUBSTRING(transaction_date, 1, 4) AS year, SUBSTRING(transaction_date, 6, 2) AS month, SUM(grand_total) AS grand_total
                FROM " . RegistrationTransaction::model()->tableName() . "
                WHERE (SUBSTRING(CURRENT_DATE, 1, 4) - SUBSTRING(transaction_date, 1, 4)) * 12 + (SUBSTRING(CURRENT_DATE, 6, 2) - SUBSTRING(transaction_date, 6, 2)) <= 12
                GROUP BY SUBSTRING(transaction_date, 1, 4), SUBSTRING(transaction_date, 6, 2)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
    
    public static function getTotalQuantityVehicleCarMakeData($yearMonth, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':year_month' => $yearMonth,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT c.id AS car_model_id, SUBSTRING_INDEX(SUBSTRING_INDEX(t.transaction_date, ' ', 1), '-', 3) AS transaction_date, 
                c.name AS car_model_name, m.id AS car_make_id, m.name AS car_make_name, COUNT(*) AS total_quantity_vehicle
                FROM " . RegistrationTransaction::model()->tableName() . " t
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = t.vehicle_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " c ON c.id = v.car_model_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " m ON m.id = c.car_make_id
                WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(t.transaction_date, ' ', 1), '-', 2) = :year_month" . $branchConditionSql . "
                GROUP BY c.id, SUBSTRING_INDEX(SUBSTRING_INDEX(t.transaction_date, ' ', 1), '-', 3)
                ORDER BY m.name ASC, c.name ASC, transaction_date ASC";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getTotalHpp() {
        $total = '0.00'; 
        
        foreach ($this->registrationProducts as $detail) {
            $total += $detail->product->hpp * $detail->quantity;
        }
        
        return $total;
    }
    
    public function getTotalWorkOrderExpense() {
        $total = '0.00'; 
        
        foreach ($this->workOrderExpenseHeaders as $detail) {
            $total += $detail->grand_total;
        }
        
        return $total;
    }
    
    public function getTotalMaterialRequest() {
        $total = '0.00';
        
        foreach ($this->materialRequestHeaders as $detail) {
            $total += $detail->totalPrice;
        }
        
        return $total;
    }
    
    public static function getMonthlyCustomerReceivableData($year, $month, $customerIds) {
        $customerIdsSql = empty($customerIds) ? 'NULL' : implode(',', $customerIds);
        
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT r.customer_id, r.id, r.transaction_number, r.transaction_date, r.grand_total, b.name AS branch_name, i.invoice_number, i.invoice_date, 
                    i.product_price, i.service_price, i.ppn_total, i.total_price, i.transaction_tax_number, i.due_date, i.payment_left, i.payment_amount, 
                    h.payment_number, h.payment_date, v.plate_number, c.name AS car_make, m.name AS car_model, s.name AS car_sub_model, ic.name AS insurance
                FROM " . RegistrationTransaction::model()->tableName() . " r
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = r.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " c ON c.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " m ON m.id = v.car_model_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s ON s.id = v.car_sub_model_id
                LEFT OUTER JOIN " . InsuranceCompany::model()->tableName() . " ic ON ic.id = r.insurance_company_id
                LEFT OUTER JOIN " . InvoiceHeader::model()->tableName() . " i ON r.id = i.registration_transaction_id
                LEFT OUTER JOIN " . PaymentInDetail::model()->tableName() . " p ON i.id = p.invoice_header_id
                LEFT OUTER JOIN " . PaymentIn::model()->tableName() . " h on h.id = p.payment_in_id
                WHERE YEAR(r.transaction_date) = :year AND MONTH(r.transaction_date) = :month AND r.user_id_cancelled IS NULL AND r.customer_id IN ({$customerIdsSql})
                ORDER BY r.customer_id, r.id ASC, i.id ASC, p.id ASC ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public static function getMonthlyInsuranceReceivableData($year, $month, $insuranceIds) {
        $insuranceIdsSql = empty($insuranceIds) ? 'NULL' : implode(',', $insuranceIds);
        
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT r.insurance_company_id, r.id, r.transaction_number, r.transaction_date, r.grand_total, b.name AS branch_name, i.invoice_number, i.invoice_date, 
                    i.product_price, i.service_price, i.ppn_total, i.total_price, i.transaction_tax_number, i.due_date, i.payment_left, i.payment_amount, 
                    h.payment_number, h.payment_date, v.plate_number, c.name AS car_make, m.name AS car_model, s.name AS car_sub_model
                FROM " . RegistrationTransaction::model()->tableName() . " r
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = r.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " c ON c.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " m ON m.id = v.car_model_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s ON s.id = v.car_sub_model_id
                LEFT OUTER JOIN " . InvoiceHeader::model()->tableName() . " i ON r.id = i.registration_transaction_id
                LEFT OUTER JOIN " . PaymentInDetail::model()->tableName() . " p ON i.id = p.invoice_header_id
                LEFT OUTER JOIN " . PaymentIn::model()->tableName() . " h on h.id = p.payment_in_id
                WHERE YEAR(r.transaction_date) = :year AND MONTH(r.transaction_date) = :month AND r.user_id_cancelled IS NULL AND 
                    r.insurance_company_id IN ({$insuranceIdsSql})
                ORDER BY r.insurance_company_id, r.id ASC, i.id ASC, p.id ASC ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
    
    public function getTotalProductService() {
        return $this->total_product_price + $this->total_service_price;
    }
    
    public static function getActiveWorkOrderData($branchId, $limit, $startDate, $endDate, $plateNumber, $carMakeId, $carModelId, $workOrderNumber, $transactionStatus, $repairType) {
        $plateNumberConditionSql = '';
        $carMakeConditionSql = '';
        $carModelConditionSql = '';
        $workOrderConditionSql = '';
        $transactionStatusConditionSql = '';
        $repairTypeConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':branch_id' => $branchId,
        );
        
        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND v.plate_number LIKE :plate_number';
            $params[':plate_number'] = "%{$plateNumber}%";
        }

        if (!empty($carMakeId)) {
            $carMakeConditionSql = ' AND v.car_make_id = :car_make_id';
            $params[':car_make_id'] = $carMakeId;
        }

        if (!empty($carModelId)) {
            $carModelConditionSql = ' AND v.car_model_id = :car_model_id';
            $params[':car_model_id'] = $carModelId;
        }

        if (!empty($workOrderNumber)) {
            $workOrderConditionSql = ' AND r.work_order_number LIKE :work_order_number';
            $params[':plate_number'] = "%{$workOrderNumber}%";
        }

        if (!empty($transactionStatus)) {
            $transactionStatusConditionSql = ' AND r.status = :transaction_status';
            $params[':transaction_status'] = $transactionStatus;
        }

        if (!empty($repairType)) {
            $repairTypeConditionSql = ' AND r.repair_type = :repair_type';
            $params[':repair_type'] = $repairType;
        }

        $sql = "SELECT r.vehicle_id, v.plate_number, r.transaction_date, c.name AS car_make, m.name AS car_model, s.name AS car_sub_model, o.name AS color,
                    r.work_order_number, r.work_order_date, r.repair_type, r.problem, u.username, r.status, r.id, r.transaction_number, r.sales_order_number
                FROM " . RegistrationTransaction::model()->tableName() . " r
                INNER JOIN " . Branch::model()->tableName() . " b on b.id = r.branch_id
                INNER JOIN " . Vehicle::model()->tableName() . " v on v.id = r.vehicle_id
                INNER JOIN " . VehicleCarMake::model()->tableName() . " c on c.id = v.car_make_id
                INNER JOIN " . VehicleCarModel::model()->tableName() . " m on m.id = v.car_model_id
                INNER JOIN " . VehicleCarSubModel::model()->tableName() . " s on s.id = v.car_sub_model_id
                INNER JOIN " . Colors::model()->tableName() . " o on o.id = v.color_id
                INNER JOIN " . Users::model()->tableName() . " u on u.id = r.user_id
                WHERE r.work_order_number IS NOT NULL AND r.status NOT LIKE '%Finished%' AND r.user_id_cancelled IS NULL AND
                    SUBSTRING(r.transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND r.branch_id = :branch_id" . $plateNumberConditionSql . 
                    $carMakeConditionSql . $carModelConditionSql . $workOrderConditionSql . $transactionStatusConditionSql . $repairTypeConditionSql . "
                ORDER BY r.transaction_date DESC, r.id DESC
                LIMIT {$limit}";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
