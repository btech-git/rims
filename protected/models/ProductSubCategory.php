<?php

/**
 * This is the model class for table "{{product_sub_category}}".
 *
 * The followings are the available columns in table '{{product_sub_category}}':
 * @property integer $id
 * @property integer $product_master_category_id
 * @property integer $product_sub_master_category_id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $user_id
 * @property string $date_posting
 * @property integer $is_approved
 * @property integer $user_id_approval
 * @property string $date_time_approval
 * @property integer $is_rejected
 * @property integer $user_id_reject
 * @property string $date_time_reject
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property ProductSubMasterCategory $productSubMasterCategory
 * @property ProductMasterCategory $productMasterCategory
 * @property User $user
 * @property UserIdApproval $userIdApproval
 * @property UserIdReject $userIdReject
 */
class ProductSubCategory extends CActiveRecord {

    public $product_master_category_code;
    public $product_master_category_name;
    public $product_sub_master_category_code;
    public $product_sub_master_category_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product_sub_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_master_category_id, product_sub_master_category_id, code, name, status, user_id', 'required'),
            array('product_master_category_id, product_sub_master_category_id, user_id, is_approved, user_id_approval, is_rejected, user_id_reject', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 20),
            array('name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 10),
            array('description, date_time_approval, date_time_reject', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_master_category_id, product_sub_master_category_id, code, name, description, status, product_master_category_code, product_master_category_name, product_sub_master_category_code, product_sub_master_category_name, date_posting, user_id, is_approved, user_id_approval, date_time_approval, user_id_reject, date_time_reject, is_rejected', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'product_sub_category_id'),
            'productSubMasterCategory' => array(self::BELONGS_TO, 'ProductSubMasterCategory', 'product_sub_master_category_id'),
            'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
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
            'product_master_category_id' => 'Product Master Category',
            'product_sub_master_category_id' => 'Product Sub Master Category',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'status' => 'Status',
            'user_id' => 'User Input',
            'date_posting' => 'Tanggal Input',
            'is_approved' => 'Approval',
            'user_id_approval' => 'User Approval',
            'date_approval' => 'Tanggal Approval',
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
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.date_posting', $this->date_posting);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id_approval', $this->user_id_approval);
        $criteria->compare('t.user_id_reject', $this->user_id_reject);

        $criteria->together = true;
        $criteria->with = array('productSubMasterCategory', 'productMasterCategory');
        $criteria->compare('productMasterCategory.code', $this->product_master_category_code, true);
        $criteria->compare('productMasterCategory.name', $this->product_master_category_name, true);
        $criteria->compare('productSubMasterCategory.code', $this->product_sub_master_category_code, true);
        $criteria->compare('productSubMasterCategory.name', $this->product_sub_master_category_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.code ASC',
                'attributes' => array(
                    'product_master_category_code' => array(
                        'asc' => 'productMasterCategory.code',
                        'desc' => 'productMasterCategory.code DESC'
                    ),
                    'product_master_category_name' => array(
                        'asc' => 'productMasterCategory.name',
                        'desc' => 'productMasterCategory.name DESC'
                    ),
                    'product_sub_master_category_code' => array(
                        'asc' => 'productSubMasterCategory.code',
                        'desc' => 'productSubMasterCategory.code DESC'
                    ),
                    'product_sub_master_category_name' => array(
                        'asc' => 'productSubMasterCategory.name',
                        'desc' => 'productSubMasterCategory.name DESC'
                    ),
                    '*'
                )
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductSubCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNameAndCode() {
        return $this->name . ' - ' . $this->code;
    }

    public function searchByStockCheck() {

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
//                'currentPage' => $pageNumber - 1,
            ),
        ));
    }

    public function searchByInventoryValueReport() {

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
//                'currentPage' => $pageNumber - 1,
            ),
        ));
    }

    public function getInventoryTotalQuantityData($productMasterCategoryId, $productSubMasterCategoryId) {
        $productMasterCategoryConditionSql = '';
        $productSubMasterCategoryConditionSql = '';

        $params = array();
        
        if (!empty($productMasterCategoryConditionSql)) {
            $productMasterCategoryConditionSql = ' AND mc.id = :product_master_category_id';
            $params[':product_master_category_id'] = $productMasterCategoryId;
        }
        
        if (!empty($productSubMasterCategoryConditionSql)) {
            $productSubMasterCategoryConditionSql = ' AND sm.id = :product_sub_master_category_id';
            $params[':product_sub_master_category_id'] = $productSubMasterCategoryId;
        }
                
        $sql = "SELECT p.product_sub_category_id, w.branch_id, COALESCE(SUM(i.total_stock), 0) AS total_stock
                FROM " . Inventory::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                INNER JOIN " . ProductSubCategory::model()->tableName() . " s ON s.id = p.product_sub_category_id
                INNER JOIN " . ProductSubMasterCategory::model()->tableName() . " sm ON sm.id = s.product_sub_master_category
                INNER JOIN " . ProductMasterCategory::model()->tableName() . " mc ON mc.id = sm.product_master_category_id
                WHERE s.status = 'Active' AND w.status = 'Active'" . $productMasterCategoryConditionSql . $productSubMasterCategoryConditionSql . "
                GROUP BY p.product_sub_category_id, w.branch_id
                ORDER BY p.product_sub_category_id ASC, w.branch_id ASC
                LIMIT 100";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }

    public function getInventoryTotalQuantities() {
        $sql = "SELECT w.branch_id, COALESCE(SUM(i.total_stock), 0) AS total_stock
                FROM " . Inventory::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                WHERE p.product_sub_category_id = :product_sub_category_id AND w.status = 'Active'
                GROUP BY w.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':product_sub_category_id' => $this->id));

        return $resultSet;
    }

    public function getInventoryTotalValues() {
        $sql = "SELECT w.branch_id, COALESCE(SUM((i.stock_in + i.stock_out) * i.purchase_price), 0) AS total_value
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                WHERE p.product_sub_category_id = :product_sub_category_id AND w.status = 'Active'
                GROUP BY w.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':product_sub_category_id' => $this->id));

        return $resultSet;
    }

    public function getInventoryCostOfGoodsSold() {
        $sql = "SELECT w.branch_id, COALESCE(SUM(d.purchase_price), 0) AS cogs
                FROM " . Inventory::model()->tableName() . " i
                INNER JOIN " . InventoryDetail::model()->tableName() . " d ON i.id = d.inventory_id
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                WHERE p.product_sub_category_id = :product_sub_category_id AND w.status = 'Active'
                GROUP BY w.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':product_sub_category_id' => $this->id));

        return $resultSet;
    }
    
    public function getBeginningStockReport($startDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':product_sub_category_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(i.stock_in + i.stock_out), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
            WHERE p.product_sub_category_id = :product_sub_category_id AND w.status = 'Active' AND i.transaction_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND transaction_date < :start_date" . $branchConditionSql . "
            GROUP BY p.product_sub_category_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getBeginningValueReport($startDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':product_sub_category_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM((i.stock_in + i.stock_out) * i.purchase_price), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
            WHERE p.product_sub_category_id = :product_sub_category_id AND w.status = 'Active' AND i.transaction_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND transaction_date < :start_date" . $branchConditionSql . "
            GROUP BY p.product_sub_category_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getInventoryStockReport($endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':end_date' => $endDate,
            ':product_sub_category_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT p.id, p.code, p.name, p.manufacturer_code, SUM(i.stock_in) AS stock_in, SUM(i.stock_out) AS stock_out
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                INNER JOIN " . Unit::model()->tableName() . " u ON u.id = p.unit_id
                WHERE i.transaction_date > '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND w.status = 'Active' AND i.transaction_date <= :end_date AND p.product_sub_category_id = :product_sub_category_id" . $branchConditionSql . "
                GROUP BY p.id, p.code, p.name, p.manufacturer_code";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
}
