<?php

/**
 * This is the model class for table "{{stock_adjustment_detail}}".
 *
 * The followings are the available columns in table '{{stock_adjustment_detail}}':
 * @property integer $id
 * @property integer $stock_adjustment_header_id
 * @property integer $product_id
 * @property integer $warehouse_id
 * @property integer $quantity_current
 * @property integer $quantity_adjustment
 * @property string $memo
 */
class StockAdjustmentDetail extends CActiveRecord {

    // public $headerStatus;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{stock_adjustment_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stock_adjustment_header_id, product_id, quantity_current, quantity_adjustment', 'required'),
            array('stock_adjustment_header_id, product_id, warehouse_id, quantity_current, quantity_adjustment', 'numerical', 'integerOnly' => true),
            array('memo', 'length', 'max'=>100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, stock_adjustment_header_id, product_id, warehouse_id, quantity_current, quantity_adjustment, memo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'stockAdjustmentHeader' => array(self::BELONGS_TO, 'StockAdjustmentHeader', 'stock_adjustment_header_id'),
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
            'stock_adjustment_header_id' => 'Stock Adjustment Header',
            'product_id' => 'Product',
            'warehouse_id' => 'Warehouse',
            'quantity_current' => 'Quantity Current',
            'quantity_adjustment' => 'Quantity Adjustment',
            'memo' => 'Memo',
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
        $criteria->compare('stock_adjustment_header_id', $this->stock_adjustment_header_id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('warehouse_id', $this->warehouse_id);
        $criteria->compare('quantity_current', $this->quantity_current);
        $criteria->compare('quantity_adjustment', $this->quantity_adjustment);
        $criteria->compare('memo', $this->memo);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    protected function afterSave() {

        if (!$this->isNewRecord AND $this->stockAdjustmentHeader->status == 'Approved') {
            $inventoryDetail = new InventoryDetail();
            $inventoryDetail->inventory_id = $this->getInventoryId($this->product_id, $this->warehouse_id);
            $inventoryDetail->product_id = $this->product_id;
            $inventoryDetail->warehouse_id = $this->warehouse_id;
            $inventoryDetail->transaction_type = 'adjustment';
            $inventoryDetail->transaction_number = 'TR-AJS' . $this->stock_adjustment_header_id; //$this->stockAdjustmentHeader->stock_adjustment_header_id;
            $inventoryDetail->transaction_date = date("Y-m-d");
            $inventoryDetail->quantity_current = $this->quantity_current;
            $inventoryDetail->quantity_adjustment = $this->quantity_adjustment;
            $inventoryDetail->notes = 'Data From Stock Adjustment';
            $inventoryDetail->save();
        }

        return parent::afterSave();
    }

    public function getInventoryId($productId, $warehouseId) {
        $InventoryID = Inventory::model()->findByAttributes(array(
            'product_id' => $productId,
            'warehouse_id' => $warehouseId,
        ));

        if ($InventoryID !== null) {
            return $InventoryID->id;
        } else {
            $insertInventory = new Inventory();
            $insertInventory->product_id = $productId;
            $insertInventory->warehouse_id = $warehouseId;
            $insertInventory->status = 'Active';
            if ($insertInventory->save()) {
                return $insertInventory->id;
            } else {
                return '';
            }
        }
    }

    public function getCurrentStock($productId, $branchId = null) {
        $sql = "
            SELECT COALESCE(i.total_stock, 0)
            FROM " . Inventory::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w
            WHERE i.product_id = :product_id AND w.branch_id = :branch_id
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':product_id' => $productId,
            ':branch_id' => empty($branchId) ? $this->stockAdjustmentHeader->branch_id : $branchId,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getWarehouseId($branchId = null) {
        $sql = "
            SELECT i.warehouse_id
            FROM " . Inventory::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            WHERE i.product_id = :product_id AND w.branch_id = :branch_id
        ";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->product_id,
            ':branch_id' => $branchId,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getQuantityDifference() {
        return $this->quantity_adjustment - $this->quantity_current;
    }

//	public function getCurrentStock($header_id, $product_id, $warehouse_id, $posisi)
//	{
//		$model = self::model()->findByAttributes(array('stock_adjustment_header_id'=>$header_id,'product_id'=>$product_id, 'warehouse_id'=>$warehouse_id)); 
//
//		// echo $model->total_stock;
//		// var_dump($model); die("S");
//		if ($model != NULL) {
//			return ($posisi == 'stockin')? $model->quantity_current : $model->quantity_adjustment; 
//			// return $model->total_stock;
//		}else{
//			return 0;
//		}
//	}

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StockAdjustmentDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
