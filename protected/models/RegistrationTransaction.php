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
 * @property string $down_payment_amount
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
 * @property string $is_passed
 * @property string $service_status
 * @property string $vehicle_status
 * @property integer $total_time
 * @property integer $priority_level
 * @property string $customer_work_order_number
 * @property string $transaction_date_out
 * @property string $transaction_time_out
 * @property integer $user_id_assign_mechanic
 * @property integer $tax_percentage
 *
 * The followings are the available model relations:
 * @property InvoiceHeader[] $invoiceHeaders
 * @property MovementOutHeader[] $movementOutHeaders
 * @property RegistrationDamage[] $registrationDamages
 * @property RegistrationInsuranceData[] $registrationInsuranceDatas
 * @property RegistrationPayment[] $registrationPayments
 * @property RegistrationProduct[] $registrationProducts
 * @property RegistrationQuickService[] $registrationQuickServices
 * @property RegistrationMemo[] $registrationMemos
 * @property RegistrationRealizationProcess[] $registrationRealizationProcesses
 * @property RegistrationService[] $registrationServices
 * @property CustomerPic $pic
 * @property Branch $branch
 * @property InsuranceCompany $insuranceCompany
 * @property User $user
 * @property Customer $customer
 * @property Vehicle $vehicle
 * @property RegistrationServiceManagement[] $registrationServiceManagements
 */
class RegistrationTransaction extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'RG';
    const CONSTANT_WORK_ORDER = 'WO';
    const CONSTANT_SALE_ORDER = 'SL';
    const PRIORITY_HIGH = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_LOW = 3;
    const PRIORITY_HIGH_LITERAL = 'HIGH';
    const PRIORITY_MEDIUM_LITERAL = 'Medium';
    const PRIORITY_LOW_LITERAL = 'low';

    /**
     * @return string the associated database table name
     */
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
    public $search_service;
    public $transaction_date_from;
    public $transaction_date_to;

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
            array('customer_id, vehicle_id, service_status, vehicle_status, tax_percentage', 'required'),
            array('customer_id, pic_id, vehicle_id, branch_id, user_id, total_quickservice, total_service, is_quick_service, is_insurance, insurance_company_id, laststatusupdate_by, ppn, pph, vehicle_mileage, total_time, priority_level, is_passed, user_id_assign_mechanic, tax_percentage', 'numerical', 'integerOnly' => true),
            array('transaction_number, repair_type, work_order_number, payment_status, payment_type, sales_order_number, customer_work_order_number, vehicle_status', 'length', 'max' => 30),
            array('total_quickservice_price, subtotal_service, discount_service, total_service_price, subtotal_product, discount_product, total_product_price, grand_total, down_payment_amount', 'length', 'max' => 18),
            array('total_product, subtotal, ppn_price, pph_price', 'length', 'max' => 10),
            array('status', 'length', 'max' => 50),
            array('transaction_number', 'unique'),
            array('transaction_date, problem, work_order_date, work_order_time, sales_order_date, note, customer_type, transaction_date_out, transaction_time_out', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, repair_type, work_order_number, problem, work_order_date, work_order_time, customer_id, pic_id, vehicle_id, branch_id, user_id, total_quickservice, total_quickservice_price, total_service, subtotal_service, discount_service, total_service_price, total_product, subtotal_product, discount_product, total_product_price, is_quick_service, is_insurance, insurance_company_id, status, grand_total, work_order_number, work_order_date, status, payment_status, payment_type, down_payment_amount,customer_name, pic_name, plate_number, branch_name, sales_order_number, sales_order_date, car_make_code, car_model_code, search_service, car_color, transaction_date_from, transaction_date_to, subtotal, ppn, pph, ppn_price, pph_price, vehicle_mileage, note, customer_type, is_passed, total_time, service_status, priority_level, customer_work_order_number, vehicle_status, transaction_date_out, transaction_time_out, user_id_assign_mechanic, tax_percentage', 'safe', 'on' => 'search'),
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
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'registration_transaction_id'),
            'registrationDamages' => array(self::HAS_MANY, 'RegistrationDamage', 'registration_transaction_id'),
            'registrationInsuranceDatas' => array(self::HAS_MANY, 'RegistrationInsuranceData', 'registration_transaction_id'),
            'registrationPayments' => array(self::HAS_MANY, 'RegistrationPayment', 'registration_transaction_id'),
            'registrationProducts' => array(self::HAS_MANY, 'RegistrationProduct', 'registration_transaction_id'),
            'registrationQuickServices' => array(self::HAS_MANY, 'RegistrationQuickService', 'registration_transaction_id'),
            'registrationMemos' => array(self::HAS_MANY, 'RegistrationMemo', 'registration_transaction_id'),
            'registrationRealizationProcesses' => array(self::HAS_MANY, 'RegistrationRealizationProcess', 'registration_transaction_id'),
            'registrationServices' => array(self::HAS_MANY, 'RegistrationService', 'registration_transaction_id'),
            'registrationBodyRepairDetails' => array(self::HAS_MANY, 'RegistrationBodyRepairDetail', 'registration_transaction_id'),
            'pic' => array(self::BELONGS_TO, 'CustomerPic', 'pic_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'userIdAssignMechanic' => array(self::BELONGS_TO, 'User', 'user_id_assign_mechanic'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'registrationServiceManagements' => array(self::HAS_MANY, 'RegistrationServiceManagement', 'registration_transaction_id'),
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
            'down_payment_amount' => 'Down Payment Amount',
            'laststatusupdate_by' => 'Laststatusupdate By',
            'sales_order_number' => 'Sales Order Number',
            'sales_order_date' => 'Sales Order Date',
            'ppn' => 'Ppn',
            'pph' => 'Pph',
            'subtotal' => 'Subtotal',
            'ppn_price' => 'Ppn Price',
            'pph_price' => 'Pph Price',
            'vehicle_mileage' => 'KM',
            'note' => 'Catatan',
            'is_passed' => 'Quality Control',
            'total_time' => 'Total Time',
            'service_status' => 'Service Status',
            'vehicle_status' => 'Vehicle Status',
            'priority_level' => 'Priority Level',
            'customer_work_order_number' => 'SPK #',
            'transaction_date_out' => 'Check Out Date',
            'transaction_time_out' => 'Check Out Time',
            'user_id_assign_mechanic' => 'Assign Mechanic',
            'tax_percentage' => 'PPn %',
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
        $criteria->compare('t.work_order_time', $this->work_order_time, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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
        $criteria->compare('user_id_assign_mechanic', $this->user_id_assign_mechanic);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

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
                'pageSize' => 100,
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
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegistrationTransaction the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function getInvoice($data, $row) {
        $invoiceNumber = '';
        $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $data->id));
        foreach ($invoices as $key => $invoice) {
            if ($invoice->status != 'CANCELLED' && $invoice->status != 'PAID') {
                $invoiceNumber = $invoice->invoice_number;
            }
        }
        return $invoiceNumber;
    }

    public function getServices() {
        $services = array();

        if ($this->repair_type == 'GR') {
            foreach ($this->registrationServices as $registrationService) {

                $services[] = $registrationService->service->name . '<br>';
            }
        } else {
            foreach ($this->registrationServices as $registrationService) {
                if ($registrationService->is_body_repair == 1)
                    $services[] = $registrationService->service->name . '<br>';
            }
        }

        return $this->search_service = implode('', $services);
    }

    public function getPpnLiteral() {
        return ($this->ppn == 0) ? '0%' : '11%';
    }

    public function getPphLiteral() {
        return ($this->ppn == 0) ? '0%' : '2.5%';
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
        ) AND t.total_product > 0";

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
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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

        $criteria->condition = "NOT EXISTS (
            SELECT registration_transaction_id
            FROM " . WorkOrderExpenseHeader::model()->tableName() . "
            WHERE t.id = registration_transaction_id
        )";

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
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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
        $criteria->compare('user_id_assign_mechanic', $this->user_id_assign_mechanic);
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

//        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
//        $criteria->params = array(':userId' => Yii::app()->user->id);

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

    public function searchByPendingJournal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

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
        $criteria->compare('t.work_order_time', $this->work_order_time, true);
        $criteria->compare('t.status', 'Finished');
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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
        $criteria->compare('user_id_assign_mechanic', $this->user_id_assign_mechanic);
        $criteria->compare('t.tax_percentage', $this->tax_percentage);

        $criteria->addCondition("substring(t.transaction_number, 1, (length(t.transaction_number) - 2)) NOT IN (
            SELECT substring(kode_transaksi, 1, (length(kode_transaksi) - 2))  
            FROM " . JurnalUmum::model()->tableName() . "
        )");

        $criteria->together = 'true';
        $criteria->with = array(
            'vehicle', 
            'customer',
        );

        $criteria->compare('vehicle.plate_number', $this->plate_number, true);
        $criteria->compare('customer.name', $this->customer_name, true);
        $criteria->addSearchCondition('customer.customer_type', $this->customer_type, true);

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

    public static function pendingJournal() {
        $sql = "SELECT p.id, p.transaction_number, p.transaction_date, s.name as customer_name, b.name as branch_name, p.repair_type, p.status
                FROM " . RegistrationTransaction::model()->tableName() . " p
                INNER JOIN " . Customer::model()->tableName() . " s ON s.id = p.customer_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = p.branch_id
                WHERE p.transaction_date > '2021-12-31' AND p.transaction_number NOT IN (
                    SELECT kode_transaksi 
                    FROM " . JurnalUmum::model()->tableName() . "
                )
                ORDER BY p.transaction_date DESC";

        return $sql;
    }
    
    public function searchByFollowUp() {
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
        $criteria->compare('payment_status', $this->payment_status, true);
        $criteria->compare('payment_type', $this->payment_type, true);
        $criteria->compare('down_payment_amount', $this->down_payment_amount, true);
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

}