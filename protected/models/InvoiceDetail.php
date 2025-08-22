<?php

/**
 * This is the model class for table "{{invoice_detail}}".
 *
 * The followings are the available columns in table '{{invoice_detail}}':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $service_id
 * @property integer $product_id
 * @property integer $sale_package_header_id
 * @property integer $quick_service_id
 * @property string $quantity
 * @property string $discount
 * @property string $unit_price
 * @property string $total_price
 *
 * The followings are the available model relations:
 * @property InvoiceHeader $invoice
 * @property Service $service
 * @property Product $product
 * @property SalePackageHeader $salePackageHeader
 * @property QuickService $quickService
 */
class InvoiceDetail extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InvoiceDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{invoice_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('invoice_id, unit_price, total_price', 'required'),
            array('invoice_id, service_id, product_id, sale_package_header_id, quick_service_id', 'numerical', 'integerOnly' => true),
            array('unit_price, total_price, discount', 'length', 'max' => 18),
            array('quantity', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, invoice_id, service_id, product_id, quick_service_id, sale_package_header_id, quantity, unit_price, total_price, discount', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'invoice' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_id'),
            'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'salePackageHeader' => array(self::BELONGS_TO, 'SalePackageHeader', 'sale_package_header_id'),
            'quickService' => array(self::BELONGS_TO, 'QuickService', 'quick_service_id'),
            'invoiceHeader' => array(self::BELONGS_TO, 'InvoiceHeader', 'invoice_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'invoice_id' => 'Invoice',
            'service_id' => 'Service',
            'product_id' => 'Product',
            'sale_package_header_id' => 'Package',
            'quick_service_id' => 'Quick Service',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total_price' => 'Total Price',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('invoice_id', $this->invoice_id);
        $criteria->compare('service_id', $this->service_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('sale_package_header_id', $this->sale_package_header_id);
        $criteria->compare('quick_service_id', $this->quick_service_id);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('discount', $this->discount, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function getPriceAfterDiscount() {
        return $this->quantity * $this->unit_price - $this->discount;
    }
    
    public function getTotalWithTax() {

        return round($this->total_price * ($this->invoiceHeader->tax_percentage / 100), 0);
    }

    public function getTotalWithCoretax() {

        return round($this->total_price * 11 / 12, 2);
    }

    public static function graphAverageQuantitySalePerBranch() {
        
        $sql = "SELECT b.code AS branch_name, SUM(d.quantity)/12 AS average_quantity
                FROM " . InvoiceHeader::model()->tableName() . " h
                INNER JOIN " . InvoiceDetail::model()->tableName() . " d ON h.id = d.invoice_id
                INNER JOIN " . Branch::model()->tableName() . " b ON b.id = h.branch_id
                WHERE d.product_id IS NOT null AND h.invoice_date > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
                GROUP BY h.branch_id";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true);
        
        return $resultSet;
    }
    
    public static function getYearlyStatisticsData($year, $branchId, $masterCategoryId, $subMasterCategoryId, $subCategoryId, $brandId, $subBrandId, $subBrandSeriesId) {
        $branchConditionSql = '';
        $brandConditionSql = ''; 
        $categoryConditionSql = '';
        $brandCategoryConditionSql = '';
        
        $params = array(
            ':year' => $year,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($subBrandSeriesId)) {
            $brandConditionSql = ' AND p.sub_brand_series_id = :sub_brand_series_id';
            $params[':sub_brand_series_id'] = $subBrandSeriesId;
        } else if (!empty($subBrandId)) {
            $brandConditionSql = ' AND p.sub_brand_id = :sub_brand_id';
            $params[':sub_brand_id'] = $subBrandId;
        } else if (!empty($brandId)) {
            $brandConditionSql = ' AND p.brand_id = :brand_id';
            $params[':brand_id'] = $brandId;
        }
        
        if (!empty($subCategoryId)) {
            $categoryConditionSql = ' AND p.product_sub_category_id = :product_sub_category_id';
            $params[':product_sub_category_id'] = $subCategoryId;
        } else if (!empty($subMasterCategoryId)) {
            $categoryConditionSql = ' AND p.product_sub_master_category_id = :product_sub_master_category_id';
            $params[':product_sub_master_category_id'] = $subMasterCategoryId;
        } else if (!empty($masterCategoryId)) {
            $categoryConditionSql = ' AND p.product_master_category_id = :product_master_category_id';
            $params[':product_master_category_id'] = $masterCategoryId;
        }
        
        if (empty($brandConditionSql) && empty($categoryConditionSql)) {
            $brandCategoryConditionSql = ' AND FALSE';
        } else {
            $brandCategoryConditionSql = $brandConditionSql . $categoryConditionSql;
        }
        
        $sql = "SELECT d.product_id, MONTH(h.invoice_date) AS invoice_month, MAX(p.name) AS product_name, GROUP_CONCAT(d.quantity) AS quantities, GROUP_CONCAT(d.total_price) AS total_prices
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE YEAR(h.invoice_date) = :year AND d.product_id IS NOT null" . $branchConditionSql . $brandCategoryConditionSql . " 
                GROUP BY d.product_id, MONTH(h.invoice_date), p.name
                ORDER BY p.name ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getDailyMultipleEmployeeSaleProductReport($startDate, $endDate, $employeeIds) {
        $employeeIdList = empty($employeeIds) ? 'NULL' :  implode(',', $employeeIds);
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT r.employee_id_sales_person, SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.quantity ELSE 0 END) AS tire_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.quantity ELSE 0 END) AS oil_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id BETWEEN 636 AND 649 THEN d.quantity ELSE 0 END) AS accessories_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE r.employee_id_sales_person IN (" . $employeeIdList . ") AND h.invoice_date BETWEEN :start_date AND :end_date AND 
                    h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_sales_person";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlyMultipleEmployeeSaleProductReport($year, $month, $employeeIds) {
        $employeeIdList = empty($employeeIds) ? 'NULL' :  implode(',', $employeeIds);
        
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT r.employee_id_sales_person, SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.quantity ELSE 0 END) AS tire_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.quantity ELSE 0 END) AS oil_quantity, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.quantity ELSE 0 END) AS accessories_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.total_price ELSE 0 END) AS tire_price, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.total_price ELSE 0 END) AS oil_price, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.total_price ELSE 0 END) AS accessories_price
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE r.employee_id_sales_person IN (" . $employeeIdList . ") AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_sales_person";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlyMultipleEmployeeSaleProductReport($year, $employeeIds) {
        $employeeIdList = empty($employeeIds) ? 'NULL' :  implode(',', $employeeIds);
        
        $params = array(
            ':year' => $year,
        );
        
        $sql = "SELECT r.employee_id_sales_person, SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.quantity ELSE 0 END) AS tire_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.quantity ELSE 0 END) AS oil_quantity, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.quantity ELSE 0 END) AS accessories_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.total_price ELSE 0 END) AS tire_price, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.total_price ELSE 0 END) AS oil_price, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.total_price ELSE 0 END) AS accessories_price
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE r.employee_id_sales_person IN (" . $employeeIdList . ") AND YEAR(h.invoice_date) = :year AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_sales_person";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlySingleEmployeeSaleProductReport($year, $month, $employeeId) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
            ':employee_id_sales_person' => $employeeId,
        );
        
        $sql = "SELECT DAY(h.invoice_date) AS day, SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.quantity ELSE 0 END) AS tire_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.quantity ELSE 0 END) AS oil_quantity, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.quantity ELSE 0 END) AS accessories_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.total_price ELSE 0 END) AS tire_price, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.total_price ELSE 0 END) AS oil_price, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.total_price ELSE 0 END) AS accessories_price
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE r.employee_id_sales_person = :employee_id_sales_person AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY DAY(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlySingleEmployeeSaleProductReport($year, $employeeId) {
        $params = array(
            ':year' => $year,
            ':employee_id_sales_person' => $employeeId,
        );
        
        $sql = "SELECT MONTH(h.invoice_date) AS month, SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.quantity ELSE 0 END) AS tire_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.quantity ELSE 0 END) AS oil_quantity, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.quantity ELSE 0 END) AS accessories_quantity, 
                    SUM(CASE WHEN p.product_sub_category_id IN (442, 444) THEN d.total_price ELSE 0 END) AS tire_price, 
                    SUM(CASE WHEN p.product_sub_category_id = 540 THEN d.total_price ELSE 0 END) AS oil_price, 
                    SUM(CASE WHEN p.product_master_category_id = 9 THEN d.total_price ELSE 0 END) AS accessories_price
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = d.product_id
                WHERE r.employee_id_sales_person = :employee_id_sales_person AND YEAR(h.invoice_date) = :year AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY MONTH(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getDailyMultipleMechanicTransactionServiceReport($startDate, $endDate, $employeeIds) {
        $employeeIdList = empty($employeeIds) ? 'NULL' :  implode(',', $employeeIds);
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "SELECT r.employee_id_assign_mechanic, COUNT(d.service_id) AS service_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                WHERE r.employee_id_assign_mechanic IN (" . $employeeIdList . ") AND h.invoice_date BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_assign_mechanic";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlyMultipleMechanicTransactionServiceReport($year, $month, $employeeIds) {
        $employeeIdList = empty($employeeIds) ? 'NULL' :  implode(',', $employeeIds);
        
        $params = array(
            ':year' => $year,
            ':month' => $month,
        );
        
        $sql = "SELECT r.employee_id_assign_mechanic, COUNT(d.service_id) AS service_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                WHERE r.employee_id_assign_mechanic IN (" . $employeeIdList . ") AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND 
                    h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_assign_mechanic";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlyMultipleMechanicTransactionServiceReport($year, $employeeIds) {
        $employeeIdList = empty($employeeIds) ? 'NULL' :  implode(',', $employeeIds);
        
        $params = array(
            ':year' => $year,
        );
        
        $sql = "SELECT r.employee_id_assign_mechanic, COUNT(d.service_id) AS service_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                WHERE r.employee_id_assign_mechanic IN (" . $employeeIdList . ") AND YEAR(h.invoice_date) = :year AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY r.employee_id_assign_mechanic";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getMonthlySingleMechanicTransactionServiceReport($year, $month, $employeeId) {
        $params = array(
            ':year' => $year,
            ':month' => $month,
            ':employee_id_assign_mechanic' => $employeeId,
        );
        
        $sql = "SELECT DAY(h.invoice_date) AS day, COUNT(d.service_id) AS service_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                WHERE r.employee_id_assign_mechanic = :employee_id_assign_mechanic AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month AND 
                    h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY DAY(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public static function getYearlySingleMechanicTransactionServiceReport($year, $employeeId) {
        $params = array(
            ':year' => $year,
            ':employee_id_assign_mechanic' => $employeeId,
        );
        
        $sql = "SELECT MONTH(h.invoice_date) AS month, COUNT(d.service_id) AS service_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = h.registration_transaction_id
                WHERE r.employee_id_assign_mechanic = :employee_id_assign_mechanic AND YEAR(h.invoice_date) = :year AND h.status NOT LIKE '%CANCEL%' AND r.status NOT LIKE '%CANCEL%'
                GROUP BY MONTH(h.invoice_date)";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }    
    
    public function searchByTransactionDetailInfo($employeeId, $startDate, $endDate, $productSubCategoryIds, $page) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array(
            'invoiceHeader' => array(
                'with' => array(
                    'registrationTransaction',
                ),
            ),
            'product',
        );

        $criteria->compare('registrationTransaction.employee_id_sales_person', $employeeId);
        $criteria->addInCondition('product.product_sub_category_id', $productSubCategoryIds);
        $criteria->addBetweenCondition('invoiceHeader.invoice_date', $startDate, $endDate);
        $criteria->addCondition("invoiceHeader.status NOT LIKE '%CANCEL%' AND registrationTransaction.status NOT LIKE '%CANCEL%'");
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'invoiceHeader.invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
                'currentPage' => $page - 1,
            ),
        ));
    }
}