<?php

/**
 * This is the model class for table "{{warehouse}}".
 *
 * The followings are the available columns in table '{{warehouse}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $row
 * @property integer $column
 * @property string $status
 * @property integer $branch_id
 * @property integer $is_approved
 * @property integer $user_id
 * @property string $created_datetime
 * @property integer $is_deleted
 * @property integer $user_id_updated
 * @property integer $user_id_approved
 * @property integer $user_id_rejected
 * @property integer $user_id_deleted
 * @property string $updated_datetime
 * @property string $approved_datetime
 * @property string $rejected_datetime
 * @property string $deleted_datetime
 *
 * The followings are the available model relations:
 * @property BranchWarehouse[] $branchWarehouses
 * @property Inventory[] $inventories
 * @property InventoryDetail[] $inventoryDetails
 * @property TransactionReturnItemDetail[] $transactionReturnItemDetails
 * @property WarehouseDivision[] $warehouseDivisions
 * @property WarehouseSection[] $warehouseSections
 * @property Branch $branch
 * @property User $user
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class Warehouse extends CActiveRecord {

    public $warehouses;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{warehouse}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name, description, row, column, user_id', 'required'),
            array('row, column, branch_id, is_approved, user_id, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, is_deleted', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 20),
            array('name', 'length', 'max' => 50),
            array('description', 'length', 'max' => 100),
            array('status', 'length', 'max' => 10),
            array('created_datetime, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, name, description, row, column, status, warehouses, created_datetime, branch_id, user_id, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, is_approved, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, is_deleted', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'branchWarehouses' => array(self::HAS_MANY, 'BranchWarehouse', 'warehouse_id'),
            'inventories' => array(self::HAS_MANY, 'Inventory', 'warehouse_id'),
            'inventoryDetails' => array(self::HAS_MANY, 'InventoryDetail', 'warehouse_id'),
            'transactionReturnItemDetails' => array(self::HAS_MANY, 'TransactionReturnItemDetail', 'warehouse_id'),
            'warehouseDivisions' => array(self::HAS_MANY, 'WarehouseDivision', 'warehouse_id'),
            'warehouseSections' => array(self::HAS_MANY, 'WarehouseSection', 'warehouse_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdApproved' => array(self::BELONGS_TO, 'Users', 'user_id_approved'),
            'userIdRejected' => array(self::BELONGS_TO, 'Users', 'user_id_rejected'),
            'userIdDeleted' => array(self::BELONGS_TO, 'Users', 'user_id_deleted'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'row' => 'Row',
            'column' => 'Column',
            'status' => 'Status',
            'branch_id' => 'Branch',
            'is_approved' => 'Approval',
            'user_id' => 'User Input',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('.row', $this->row);
        $criteria->compare('t.column', $this->column);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope() {
        $alias = $this->getTableAlias(false, false);
        return array(
            'condition' => "{$alias}.status = 'Active'",
                // 'order'=>"t.name ASC",
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getBeginningStockReport($startDate) {
        $sql = "
            SELECT COALESCE(SUM(stock_in + stock_out), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . "
            WHERE warehouse_id = :warehouse_id AND transaction_date < :start_date AND transaction_date > '2022-12-31'
            GROUP BY warehouse_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':warehouse_id' => $this->id,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getBeginningBalanceStockReport($startDate) {
        $sql = "
            SELECT COALESCE(SUM((stock_in + stock_out) * purchase_price), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . "
            WHERE warehouse_id = :warehouse_id AND transaction_date < :start_date AND transaction_date > '2022-12-31'
            GROUP BY warehouse_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':warehouse_id' => $this->id,
            ':start_date' => $startDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getInventoryStockReport($startDate, $endDate) {
        
        $sql = "SELECT i.transaction_number, i.transaction_date, i.transaction_type, i.notes, i.stock_in, i.stock_out, i.purchase_price, p.name AS product_name
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                WHERE i.transaction_date BETWEEN :start_date AND :end_date AND i.warehouse_id = :warehouse_id
                ORDER BY i.transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':warehouse_id' => $this->id,
        ));
        
        return $resultSet;
    }   
}