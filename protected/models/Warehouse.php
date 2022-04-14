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
 * @property string $date_approval
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property BranchWarehouse[] $branchWarehouses
 * @property Inventory[] $inventories
 * @property TransactionReturnItemDetail[] $transactionReturnItemDetails
 * @property WarehouseDivision[] $warehouseDivisions
 * @property WarehouseSection[] $warehouseSections
 * @property Branch $branch
 * @property User $user
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
            array('row, column, branch_id, is_approved, user_id', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 20),
            array('name', 'length', 'max' => 50),
            array('description', 'length', 'max' => 100),
            array('status', 'length', 'max' => 10),
            array('date_approval', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, name, description, row, column, status, warehouses, branch_id, user_id', 'safe', 'on' => 'search'),
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
            'transactionReturnItemDetails' => array(self::HAS_MANY, 'TransactionReturnItemDetail', 'warehouse_id'),
            'warehouseDivisions' => array(self::HAS_MANY, 'WarehouseDivision', 'warehouse_id'),
            'warehouseSections' => array(self::HAS_MANY, 'WarehouseSection', 'warehouse_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('row', $this->row);
        $criteria->compare('column', $this->column);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);
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

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Warehouse the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
