<?php

/**
 * This is the model class for table "{{inventory_detail}}".
 *
 * The followings are the available columns in table '{{inventory_detail}}':
 * @property integer $id
 * @property integer $inventory_id
 * @property integer $product_id
 * @property integer $warehouse_id
 * @property string $transaction_type
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $stock_in
 * @property string $stock_out
 * @property string $notes
 * @property string $purchase_price
 *
 * The followings are the available model relations:
 * @property Inventory $inventory
 * @property Warehouse $warehouse
 * @property Product $product
 */
class InventoryDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{inventory_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(' product_id, warehouse_id, transaction_type, transaction_number, transaction_date', 'required'),
            array('inventory_id, product_id, warehouse_id', 'numerical', 'integerOnly' => true),
            array('transaction_type, stock_in, stock_out', 'length', 'max' => 10),
            array('transaction_number', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, inventory_id, product_id, warehouse_id, unit_id, transaction_type, transaction_number, transaction_date, stock_in, stock_out, notes, purchase_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'inventory' => array(self::BELONGS_TO, 'Inventory', 'inventory_id'),
            'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'inventory_id' => 'Inventory',
            'product_id' => 'Product',
            'warehouse_id' => 'Warehouse',
            'transaction_type' => 'Transaction Type',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'stock_in' => 'Stock In',
            'stock_out' => 'Stock Out',
            'notes' => 'Notes',
            'purchase_price' => 'Purchase Price',
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
        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('warehouse_id', $this->warehouse_id);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('stock_in', $this->stock_in);
        $criteria->compare('stock_out', $this->stock_out);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('purchase_price', $this->purchase_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InventoryDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByStock($branchId, $currentPage) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->together = 'true';
        $criteria->with = array('warehouse');

        $criteria->compare('id', $this->id);
        $criteria->compare('inventory_id', $this->inventory_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('warehouse_id', $this->warehouse_id);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('stock_in', $this->stock_in);
        $criteria->compare('stock_out', $this->stock_out);
        $criteria->compare('notes', $this->notes, true);
        if ($branchId !== '') {
            $criteria->compare('warehouse.branch_id', $branchId);
        }
        $criteria->order = 't.transaction_date ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
                'currentPage' => $currentPage,
            ),
        ));
    }

    public function getFastMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName) {
        $brandIdConditionSql = '';
        $subBrandIdConditionSql = '';
        $subBrandSeriesIdConditionSql = '';
        $productMasterCategoryIdConditionSql = '';
        $productSubMasterCategoryIdConditionSql = '';
        $productSubCategoryIdConditionSql = '';
        $branchIdConditionSql = '';
        $productIdConditionSql = '';
        $productCodeConditionSql = '';
        $productNameConditionSql = '';

        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );

        if (!empty($brandId)) {
            $brandIdConditionSql = " AND p.brand_id = :brand_id";
            $params[':brand_id'] = $brandId;
        }

        if (!empty($subBrandId)) {
            $subBrandIdConditionSql = " AND p.sub_brand_id = :sub_brand_id";
            $params[':sub_brand_id'] = $subBrandId;
        }

        if (!empty($subBrandSeriesId)) {
            $subBrandSeriesIdConditionSql = " AND p.sub_brand_series_id = :sub_brand_series_id";
            $params[':sub_brand_series_id'] = $subBrandSeriesId;
        }

        if (!empty($productMasterCategoryId)) {
            $productMasterCategoryIdConditionSql = " AND p.product_master_category_id = :product_master_category_id";
            $params[':product_master_category_id'] = $productMasterCategoryId;
        }

        if (!empty($productSubMasterCategoryId)) {
            $productSubMasterCategoryIdConditionSql = " AND p.product_sub_master_category_id = :product_sub_master_category_id";
            $params[':product_sub_master_category_id'] = $productSubMasterCategoryId;
        }

        if (!empty($productSubCategoryId)) {
            $productSubCategoryIdConditionSql = " AND p.product_sub_category_id = :product_sub_category_id";
            $params[':product_sub_category_id'] = $productSubCategoryId;
        }

        if (!empty($branchId)) {
            $branchIdConditionSql = " AND i.warehouse_id IN (SELECT id FROM " . Warehouse::model()->tableName() . " WHERE branch_id = :branch_id)";
            $params[':branch_id'] = $branchId;
        }

        if (!empty($productId)) {
            $productIdConditionSql = " AND i.product_id = :product_id";
            $params[':product_id'] = $productId;
        }

        if (!empty($productCode)) {
            $productCodeConditionSql = " AND p.manufacturer_code LIKE :product_code";
            $params[':product_code'] = "%$productCode%";
        }

        if (!empty($productName)) {
            $productNameConditionSql = " AND p.name LIKE :product_name";
            $params[':product_name'] = "%$productName%";
        }

        $sql = "SELECT p.id AS id, p.name AS product_name, p.manufacturer_code AS code, c.name AS category, b.name AS brand, sb.name AS sub_brand, 
                    sbs.name AS sub_brand_series, COALESCE(SUM(i.stock_out * -1), 0) AS total_sale, COALESCE(SUM(i.stock_out * -1 * i.purchase_price), 0) AS sale_price
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                INNER JOIN " . ProductMasterCategory::model()->tableName() . " c ON c.id = p.product_master_category_id
                INNER JOIN " . Brand::model()->tableName() . " b ON b.id = p.brand_id
                INNER JOIN " . SubBrand::model()->tableName() . " sb ON sb.id = p.sub_brand_id
                INNER JOIN " . SubBrandSeries::model()->tableName() . " sbs ON sbs.id = p.sub_brand_series_id
                WHERE i.transaction_date BETWEEN :start_date AND :end_date AND i.notes LIKE '%Sale Retail%'" . $brandIdConditionSql . $subBrandIdConditionSql . 
                    $subBrandSeriesIdConditionSql . $productSubMasterCategoryIdConditionSql . $productSubCategoryIdConditionSql . $productMasterCategoryIdConditionSql . 
                    $branchIdConditionSql . $productIdConditionSql . $productCodeConditionSql . $productNameConditionSql . " 
                GROUP BY i.product_id
                ORDER BY total_sale DESC
                LIMIT 50";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }

    public function getSlowMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName) {
        $brandIdConditionSql = '';
        $subBrandIdConditionSql = '';
        $subBrandSeriesIdConditionSql = '';
        $productMasterCategoryIdConditionSql = '';
        $productSubMasterCategoryIdConditionSql = '';
        $productSubCategoryIdConditionSql = '';
        $branchIdConditionSql = '';
        $productIdConditionSql = '';
        $productCodeConditionSql = '';
        $productNameConditionSql = '';

        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );

        if (!empty($brandId)) {
            $brandIdConditionSql = " AND p.brand_id = :brand_id";
            $params[':brand_id'] = $brandId;
        }

        if (!empty($subBrandId)) {
            $subBrandIdConditionSql = " AND p.sub_brand_id = :sub_brand_id";
            $params[':sub_brand_id'] = $subBrandId;
        }

        if (!empty($subBrandSeriesId)) {
            $subBrandSeriesIdConditionSql = " AND p.sub_brand_series_id = :sub_brand_series_id";
            $params[':sub_brand_series_id'] = $subBrandSeriesId;
        }

        if (!empty($productMasterCategoryId)) {
            $productMasterCategoryIdConditionSql = " AND p.product_master_category_id = :product_master_category_id";
            $params[':product_master_category_id'] = $productMasterCategoryId;
        }

        if (!empty($productSubMasterCategoryId)) {
            $productSubMasterCategoryIdConditionSql = " AND p.product_sub_master_category_id = :product_sub_master_category_id";
            $params[':product_sub_master_category_id'] = $productSubMasterCategoryId;
        }

        if (!empty($productSubCategoryId)) {
            $productSubCategoryIdConditionSql = " AND p.product_sub_category_id = :product_sub_category_id";
            $params[':product_sub_category_id'] = $productSubCategoryId;
        }

        if (!empty($branchId)) {
            $branchIdConditionSql = " AND i.warehouse_id IN (SELECT id FROM " . Warehouse::model()->tableName() . " WHERE branch_id = :branch_id)";
            $params[':branch_id'] = $branchId;
        }

        if (!empty($productId)) {
            $productIdConditionSql = " AND i.product_id = :product_id";
            $params[':product_id'] = $productId;
        }

        if (!empty($productCode)) {
            $productCodeConditionSql = " AND p.manufacturer_code LIKE :product_code";
            $params[':product_code'] = "%$productCode%";
        }

        if (!empty($productName)) {
            $productNameConditionSql = " AND p.name LIKE :product_name";
            $params[':product_name'] = "%$productName%";
        }

        $sql = "SELECT p.id AS id, p.name AS product_name, p.manufacturer_code AS code, c.name AS category, b.name AS brand, sb.name AS sub_brand, 
                    sbs.name AS sub_brand_series, COALESCE(SUM(i.stock_out * -1), 0) AS total_sale, COALESCE(SUM(i.stock_out * -1 * i.purchase_price), 0) AS sale_price
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                INNER JOIN " . ProductMasterCategory::model()->tableName() . " c ON c.id = p.product_master_category_id
                INNER JOIN " . Brand::model()->tableName() . " b ON b.id = p.brand_id
                INNER JOIN " . SubBrand::model()->tableName() . " sb ON sb.id = p.sub_brand_id
                INNER JOIN " . SubBrandSeries::model()->tableName() . " sbs ON sbs.id = p.sub_brand_series_id
                WHERE i.transaction_date BETWEEN :start_date AND :end_date AND i.notes LIKE '%Sale Retail%'" . $brandIdConditionSql . $subBrandIdConditionSql . 
                    $subBrandSeriesIdConditionSql . $productSubMasterCategoryIdConditionSql . $productSubCategoryIdConditionSql . $productMasterCategoryIdConditionSql . 
                    $branchIdConditionSql . $productIdConditionSql . $productCodeConditionSql . $productNameConditionSql . " 
                GROUP BY i.product_id
                ORDER BY total_sale ASC
                LIMIT 50";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }

    public static function getTotalStockOut($productId) {

        $sql = "SELECT SUM(stock_out * -1)
                FROM " . InventoryDetail::model()->tableName() . " 
                WHERE product_id = :product_id
                GROUP BY product_id";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':product_id' => $productId,
        ));

        return $value;
    }

    public static function getLatestInventoryData($productId, $branchId, $limit, $endDate) {
        $branchConditionSql = '';
        
        $params = array(
            ':product_id' => $productId,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }

        $sql = "SELECT i.id,  i.transaction_type, i.transaction_number, i.transaction_date, i.stock_in, i.stock_out, i.notes, 
                    COALESCE(i.purchase_price, 0) AS stock_value
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w on w.id = i.warehouse_id
                WHERE i.product_id = :product_id AND w.status = 'Active' AND i.transaction_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' And :end_date" . $branchConditionSql . "
                ORDER BY i.transaction_date DESC, i.id DESC
                LIMIT {$limit}";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }

    public static function getInventoryBeginningStock($productId, $branchId, $excludeInventoryIds) {
        $branchConditionSql = '';
        $excludeInventoryConditionSql = '';
        
        $params = array(
            ':product_id' => $productId,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($excludeInventoryIds)) {
            $idsText = implode(',', $excludeInventoryIds);
            $excludeInventoryConditionSql = " AND i.id NOT IN ({$idsText})";
        }

        $sql = "SELECT COALESCE(SUM(i.stock_in + i.stock_out), 0) AS beginning_stock
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w on w.id = i.warehouse_id
                WHERE i.product_id = :product_id AND w.status = 'Active' AND i.transaction_date = '" . AppParam::BEGINNING_TRANSACTION_DATE . "'" . $branchConditionSql . $excludeInventoryConditionSql . "";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return $value;
    }
    
    public static function getInventoryCurrentStocks($productIds, $branchId) {
        $branchConditionSql = '';
        $productIdsSql = empty($productIds) ? 'NULL' : implode(',', $productIds);
        
        $params = array();
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT i.product_id, COALESCE(SUM(i.stock_in + i.stock_out), 0) AS total_stock
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w on w.id = i.warehouse_id
                WHERE i.product_id IN ({$productIdsSql}) AND w.status = 'Active' AND i.transaction_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'" . $branchConditionSql . "
                GROUP BY i.product_id";

        $value = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $value;
    }
}