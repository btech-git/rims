<?php

/**
 * This is the model class for table "{{sale_estimation_header}}".
 *
 * The followings are the available columns in table '{{sale_estimation_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $repair_type
 * @property string $problem
 * @property integer $total_quantity_service
 * @property string $sub_total_service
 * @property string $discount_price_service
 * @property string $total_price_service
 * @property integer $total_quantity_product
 * @property string $sub_total_product
 * @property string $discount_price_product
 * @property string $total_price_product
 * @property string $tax_product_percentage
 * @property string $tax_product_amount
 * @property string $tax_service_percentage
 * @property string $tax_service_amount
 * @property string $grand_total
 * @property string $status
 * @property integer $vehicle_mileage
 * @property string $note
 * @property string $created_datetime
 * @property string $edited_datetime
 * @property integer $customer_id
 * @property integer $vehicle_id
 * @property integer $branch_id
 * @property integer $user_id_created
 * @property integer $user_id_edited
 * @property integer $employee_id_sale_person
 *
 * The followings are the available model relations:
 * @property Customer $customer
 * @property Branch $branch
 * @property Vehicle $vehicle
 * @property Employee $employeeIdSalePerson
 * @property Users $userIdCreated
 * @property Users $userIdEdited
 * @property SaleEstimationProductDetail[] $saleEstimationProductDetails
 * @property SaleEstimationServiceDetail[] $saleEstimationServiceDetails
 */
class SaleEstimationHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'EST';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sale_estimation_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, repair_type, status, created_datetime, customer_id, vehicle_id, branch_id, user_id_created, employee_id_sale_person', 'required'),
            array('total_quantity_service, total_quantity_product, vehicle_mileage, customer_id, vehicle_id, branch_id, user_id_created, user_id_edited, employee_id_sale_person', 'numerical', 'integerOnly' => true),
            array('repair_type, status', 'length', 'max' => 20),
            array('transaction_number', 'length', 'max' => 30),
            array('sub_total_service, discount_price_service, total_price_service, sub_total_product, discount_price_product, total_price_product, grand_total, tax_product_amount, tax_service_amount', 'length', 'max' => 18),
            array('tax_product_percentage, tax_service_percentage', 'length', 'max' => 10),
            array('problem, note, edited_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, repair_type, problem, total_quantity_service, sub_total_service, discount_price_service, total_price_service, total_quantity_product, sub_total_product, discount_price_product, total_price_product, grand_total, status, vehicle_mileage, note, created_datetime, edited_datetime, customer_id, vehicle_id, branch_id, user_id_created, user_id_edited, employee_id_sale_person, tax_product_percentage, tax_service_percentage, tax_product_amount, tax_service_amount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
            'employeeIdSalePerson' => array(self::BELONGS_TO, 'Employee', 'employee_id_sale_person'),
            'userIdCreated' => array(self::BELONGS_TO, 'User', 'user_id_created'),
            'userIdEdited' => array(self::BELONGS_TO, 'User', 'user_id_edited'),
            'saleEstimationProductDetails' => array(self::HAS_MANY, 'SaleEstimationProductDetail', 'sale_estimation_header_id'),
            'saleEstimationServiceDetails' => array(self::HAS_MANY, 'SaleEstimationServiceDetail', 'sale_estimation_header_id'),
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
            'transaction_time' => 'Transaction Time',
            'repair_type' => 'Repair Type',
            'problem' => 'Problem',
            'total_quantity_service' => 'Total Quantity Service',
            'sub_total_service' => 'Sub Total Service',
            'discount_price_service' => 'Discount Price Service',
            'total_price_service' => 'Total Price Service',
            'total_quantity_product' => 'Total Quantity Product',
            'sub_total_product' => 'Sub Total Product',
            'discount_price_product' => 'Discount Price Product',
            'total_price_product' => 'Total Price Product',
            'grand_total' => 'Grand Total',
            'status' => 'Status',
            'vehicle_mileage' => 'Vehicle Mileage',
            'note' => 'Note',
            'created_datetime' => 'Created Datetime',
            'edited_datetime' => 'Edited Datetime',
            'customer_id' => 'Customer',
            'vehicle_id' => 'Vehicle',
            'branch_id' => 'Branch',
            'user_id_created' => 'User Id Created',
            'user_id_edited' => 'User Id Edited',
            'employee_id_sale_person' => 'Employee Id Sale Person',
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
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('repair_type', $this->repair_type, true);
        $criteria->compare('problem', $this->problem, true);
        $criteria->compare('total_quantity_service', $this->total_quantity_service);
        $criteria->compare('sub_total_service', $this->sub_total_service, true);
        $criteria->compare('discount_price_service', $this->discount_price_service, true);
        $criteria->compare('total_price_service', $this->total_price_service, true);
        $criteria->compare('total_quantity_product', $this->total_quantity_product);
        $criteria->compare('sub_total_product', $this->sub_total_product, true);
        $criteria->compare('discount_price_product', $this->discount_price_product, true);
        $criteria->compare('total_price_product', $this->total_price_product, true);
        $criteria->compare('grand_total', $this->grand_total, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('vehicle_mileage', $this->vehicle_mileage);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('edited_datetime', $this->edited_datetime, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('vehicle_id', $this->vehicle_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('user_id_edited', $this->user_id_edited);
        $criteria->compare('employee_id_sale_person', $this->employee_id_sale_person);
        $criteria->compare('tax_product_percentage', $this->tax_product_percentage);
        $criteria->compare('tax_service_percentage', $this->tax_service_percentage);
        $criteria->compare('tax_product_amount', $this->tax_product_amount);
        $criteria->compare('tax_service_amount', $this->tax_service_amount);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SaleEstimationHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSubTotalProductService() {
        return $this->sub_total_product + $this->sub_total_service;
    }
}
