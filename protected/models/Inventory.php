<?php

/**
 * This is the model class for table "{{inventory}}".
 *
 * The followings are the available columns in table '{{inventory}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $warehouse_id
 * @property string $total_stock
 * @property integer $minimal_stock
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Warehouse $warehouse
 * @property Product $product
 * @property InventoryDetail[] $inventoryDetails
 */
class Inventory extends CActiveRecord {

    public $warehouse1;
    public $warehouse2;
    public $warehouse3;
    public $warehouse4;
    public $warehouse5;
    public $warehouse6;
    public $warehouse7;
    public $warehouse8;
    public $warehouse9;
    public $warehouse10;
    public $warehouse11;
    public $warehouse12;
    public $warehouse13;
    public $warehouse14;
    public $warehouse15;
    public $warehouse16;
    public $warehouse17;
    public $warehouse18;
    public $warehouse19;
    public $warehouse20;
    public $warehouse21;
    public $warehouse22;
    public $warehouse23;
    public $warehouse24;
    public $warehouse25;
    public $total;
    public $product_name;
    public $manufacturer_code;
    public $minimum_stock;
    public $pmc;
    public $findkeyword;
    public $code;
    public $kategori;
    public $brand_id;
    public $sub_brand_id;
    public $sub_brand_series_id;
    public $product_master_category_id;
    public $product_sub_master_category_id;
    public $product_sub_category_id;
    public $date1;
    public $date2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{inventory}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, warehouse_id', 'required'),
            array('product_id, warehouse_id, minimal_stock', 'numerical', 'integerOnly' => true),
            array('status, total_stock', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, warehouse_id, total_stock, minimal_stock, status, product_name, manufacturer_code, minimum_stock, findkeyword, brand_id, sub_brand_id, sub_brand_series_id, product_master_category_id, product_sub_master_category_id, product_sub_category_id, date1, date2', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'inventoryDetails' => array(self::HAS_MANY, 'InventoryDetail', 'inventory_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'warehouse_id' => 'Warehouse',
            'total_stock' => 'Total Stock',
            'minimal_stock' => 'Minimal Stock',
            'status' => 'Status',
            'findkeyword' => 'Find By Keyword',
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
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('warehouse_id', $this->warehouse_id);
        $criteria->compare('total_stock', $this->total_stock);
        $criteria->compare('minimal_stock', $this->minimal_stock);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);

        $criteria->together = true;
        $criteria->with = array('product');
        $criteria->compare('product.name', $this->product_name);
        $criteria->compare('product.manufacturer_code', $this->manufacturer_code);
        $criteria->compare('product.brand_id', $this->brand_id);
        $criteria->compare('product.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('product.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('product.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('product.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('product.product_sub_category_id', $this->product_sub_category_id);

        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {
            $criteria->compare('product.code', $key, true, 'OR');
            $criteria->compare('product.production_year', $key, true, 'OR');
            $criteria->compare('product.manufacturer_code', $key, true, 'OR');
            $criteria->compare('product.barcode', $key, true, 'OR');
            $criteria->compare('product.name', $key, true, 'OR');
            $criteria->compare('product.description', $key, true, 'OR');
            $criteria->compare('product.extension', $key, true, 'OR');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'product.name',
                'attributes' => array(
                    'product_name' => array(
                        'asc' => 'product.name ASC',
                        'desc' => 'product.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getTotalStock($product_id, $warehouse_id) {
        $model = self::model()->findByAttributes(array('product_id' => $product_id, 'warehouse_id' => $warehouse_id));

        if ($model != NULL) {
            return $model->total_stock;
        } else {
            return 0;
        }
    }

    public function getAverageMovementOut($inventoryid, $date1, $date2) {
        $modelCriteria = new CDbCriteria;
        $modelCriteria->addCondition("inventory_id =" . $inventoryid);
        $modelCriteria->addCondition("transaction_type = 'Movement'");
        if (!empty($date1) OR ! empty($date2)) {
            $modelCriteria->addBetweenCondition('transaction_date', date("Y-m-d", strtotime($date1)), date("Y-m-d", strtotime($date2)));
        }
        $model = InventoryDetail::model()->findAll($modelCriteria);

        if ($model != NULL) {

            $stockout = array();
            $bagi = 1;
            foreach ($model as $key => $value) {
                $stockout [] = $value->stock_out;
            }
            return abs(array_sum($stockout) / count($stockout)); // will get average and convert to double/float/+
        } else {
            return 0;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Inventory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchByCheck($specificationCategory, $specification) {
        $criteria = new CDbCriteria;

        $criteria->with = array(
            'product' => array('with' => array(
                'productSpecificationBattery',
            )),
        );

        $criteria->compare('total_stock', $this->total_stock);
        $criteria->compare('minimal_stock', $this->minimal_stock);
        $criteria->addCondition('warehouse_id = :warehouse_id');
        $criteria->params = array(':warehouse_id' => $this->warehouse_id);

        if ((int) $specificationCategory === 1) {
            $criteria->compare('parts_serial_number', isset($specification['parts_serial_number']) ? $specification['parts_serial_number'] : '');
            $criteria->compare('sub_brand_id', isset($specification['amp']) ? $specification['amp'] : '');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}