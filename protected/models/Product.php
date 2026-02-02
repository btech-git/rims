<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property string $code
 * @property string $manufacturer_code
 * @property string $barcode
 * @property string $name
 * @property string $description
 * @property integer $production_year
 * @property integer $brand_id
 * @property integer $sub_brand_id
 * @property integer $sub_brand_series_id
 * @property string $extension
 * @property integer $product_master_category_id
 * @property integer $product_sub_master_category_id
 * @property integer $product_sub_category_id
 * @property integer $vehicle_car_make_id
 * @property integer $vehicle_car_model_id
 * @property string $purchase_price
 * @property string $recommended_selling_price
 * @property string $hpp
 * @property string $retail_price
 * @property integer $stock
 * @property integer $minimum_stock
 * @property integer $margin_type
 * @property integer $margin_amount
 * @property string $minimum_selling_price
 * @property string $is_usable
 * @property string $status
 * @property integer $unit_id
 * @property integer $unit_id_conversion
 * @property string $unit_conversion_multiplier
 * @property integer $user_id
 * @property string $date_posting
 * @property integer $user_id_edit
 * @property string $date_edit
 * @property integer $is_approved
 * @property integer $user_id_approval
 * @property string $date_approval
 * @property string $time_approval
 * @property integer $is_rejected
 * @property string $date_reject
 * @property string $time_reject
 * @property integer $user_id_reject
 * @property integer $tire_size_id
 * @property integer $oil_sae_id
 *
 * The followings are the available model relations:
 * @property ConsignmentInDetail[] $consignmentInDetails
 * @property ConsignmentOutDetail[] $consignmentOutDetails
 * @property Inventory[] $inventories
 * @property InventoryDetail[] $inventoryDetails
 * @property MovementInDetail[] $movementInDetails
 * @property MovementOutDetail[] $movementOutDetails
 * @property Brand $brand
 * @property ProductMasterCategory $productMasterCategory
 * @property ProductSubMasterCategory $productSubMasterCategory
 * @property ProductSubCategory $productSubCategory
 * @property VehicleCarMake $vehicleCarMake
 * @property VehicleCarModel $vehicleCarModel
 * @property SubBrand $subBrand
 * @property SubBrandSeries $subBrandSeries
 * @property ProductComplement[] $productComplements
 * @property ProductComplement[] $productComplements1
 * @property ProductPrice[] $productPrices
 * @property ProductSpecificationBattery[] $productSpecificationBatteries
 * @property ProductSpecificationOil[] $productSpecificationOils
 * @property ProductSpecificationTire[] $productSpecificationTires
 * @property ProductSubstitute[] $productSubstitutes
 * @property ProductSubstitute[] $productSubstitutes1
 * @property ProductUnit[] $productUnits
 * @property ProductVehicle[] $productVehicles
 * @property ServiceMaterialUsage[] $serviceMaterialUsages
 * @property ServiceProduct[] $serviceProducts
 * @property RegistrationDamage[] $registrationDamages
 * @property SupplierProduct[] $supplierProducts
 * @property TransactionDeliveryOrderDetail[] $transactionDeliveryOrderDetails
 * @property TransactionPurchaseOrderDetail[] $transactionPurchaseOrderDetails
 * @property TransactionReceiveOrderDetail[] $transactionReceiveOrderDetails
 * @property TransactionRequestOrderDetail[] $transactionRequestOrderDetails
 * @property TransactionRequestTransfer[] $transactionRequestTransfers
 * @property TransactionReturnItemDetail[] $transactionReturnItemDetails
 * @property TransactionReturnOrderDetail[] $transactionReturnOrderDetails
 * @property TransactionSalesOrderDetail[] $transactionSalesOrderDetails
 * @property TransactionSentRequestDetail[] $transactionSentRequestDetails
 * @property TransactionTransferRequestDetail[] $transactionTransferRequestDetails
 * @property Unit $unit
 * @property UnitIdConversion $unitIdConversion
 * @property User $user
 * @property UserIdApproval $userIdApproval
 * @property UserIdEdit $userIdEdit
 * @property UserIdReject $userIdReject
 * @property TireSize $tireSize
 * @property OilSae $oilSae
 */
class Product extends CActiveRecord {

    public $product_master_category_code;
    public $product_master_category_name;
    public $product_sub_master_category_code;
    public $product_sub_master_category_id;
    public $product_sub_master_category_name;
    public $product_sub_category_code;
    public $product_sub_category_name;
    public $product_brand_name;
    public $product_sub_brand_name;
    public $product_sub_brand_series_name;
    public $product_purchase_price;
    public $product_supplier;
    public $findkeyword;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, manufacturer_code, name, production_year, brand_id, extension, product_master_category_id, product_sub_master_category_id, product_sub_category_id, retail_price, minimum_stock, margin_type, ppn, unit_id, user_id, minimum_selling_price', 'required'),
            array('production_year, brand_id, sub_brand_id, sub_brand_series_id, product_master_category_id, product_sub_master_category_id, product_sub_category_id, vehicle_car_make_id, vehicle_car_model_id, stock, minimum_stock, margin_type, margin_amount, ppn, unit_id, unit_id_conversion, is_approved, is_rejected, user_id_approval, user_id_edit, user_id, user_id_reject, tire_size_id, oil_sae_id', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 20),
            array('manufacturer_code, barcode, extension', 'length', 'max' => 50),
            array('manufacturer_code', 'unique', 'on' => 'insert'),
            array('name', 'length', 'max' => 30),
            array('purchase_price, recommended_selling_price, hpp, retail_price, status, minimum_selling_price, unit_conversion_multiplier', 'length', 'max' => 10),
            array('is_usable', 'length', 'max' => 5),
            array('date_posting, date_approval, date_edit, time_approval, date_reject, time_reject', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, code, manufacturer_code, barcode, name, user_id_edit, date_edit, description, production_year, brand_id, sub_brand_id, sub_brand_series_id, extension, product_master_category_id, product_sub_master_category_id, product_sub_category_id, vehicle_car_make_id, vehicle_car_model_id, purchase_price, recommended_selling_price, hpp, retail_price, stock, minimum_selling_price, minimum_stock, margin_type, margin_amount, is_usable, status, product_master_category_code, product_master_category_name, product_sub_master_category_code, product_sub_master_category_name, product_sub_category_code, product_sub_category_name,product_brand_name,product_supplier,findkeyword, ppn, product_sub_brand_name, product_sub_brand_series_name, unit_id, date_posting, user_id, is_approved, user_id_approval, date_approval, user_id, unit_conversion_multiplier, unit_id_conversion, user_id_reject, is_rejected, time_approval, date_reject, time_reject, tire_size_id, oil_sae_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'inventories' => array(self::HAS_MANY, 'Inventory', 'product_id'),
            'inventoryDetails' => array(self::HAS_MANY, 'InventoryDetail', 'product_id'),
            'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
            'productSubMasterCategory' => array(self::BELONGS_TO, 'ProductSubMasterCategory', 'product_sub_master_category_id'),
            'productSubCategory' => array(self::BELONGS_TO, 'ProductSubCategory', 'product_sub_category_id'),
            'vehicleCarMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'vehicle_car_make_id'),
            'vehicleCarModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'vehicle_car_model_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
            'subBrand' => array(self::BELONGS_TO, 'SubBrand', 'sub_brand_id'),
            'subBrandSeries' => array(self::BELONGS_TO, 'SubBrandSeries', 'sub_brand_series_id'),
            'productComplements' => array(self::HAS_MANY, 'ProductComplement', 'product_id'),
            'productComplements1' => array(self::HAS_MANY, 'ProductComplement', 'product_complement_id'),
            'productPrices' => array(self::HAS_MANY, 'ProductPrice', 'product_id'),
            'productSpecificationBatteries' => array(self::HAS_MANY, 'ProductSpecificationBattery', 'product_id'),
            'productSpecificationBattery' => array(self::HAS_ONE, 'ProductSpecificationBattery', 'product_id'),
            'productSpecificationOils' => array(self::HAS_MANY, 'ProductSpecificationOil', 'product_id'),
            'productSpecificationOil' => array(self::HAS_ONE, 'ProductSpecificationOil', 'product_id'),
            'productSpecificationTires' => array(self::HAS_MANY, 'ProductSpecificationTire', 'product_id'),
            'productSpecificationTire' => array(self::HAS_ONE, 'ProductSpecificationTire', 'product_id'),
            'productSubstitutes' => array(self::HAS_MANY, 'ProductSubstitute', 'product_id'),
            'productSubstitutes1' => array(self::HAS_MANY, 'ProductSubstitute', 'product_substitute_id'),
            'productUnits' => array(self::HAS_MANY, 'ProductUnit', 'product_id'),
            'productVehicles' => array(self::HAS_MANY, 'ProductVehicle', 'product_id'),
            'serviceMaterialUsages' => array(self::HAS_MANY, 'ServiceMaterialUsage', 'product_id'),
            'serviceProducts' => array(self::HAS_MANY, 'ServiceProduct', 'product_id'),
            'supplierProducts' => array(self::HAS_MANY, 'SupplierProduct', 'product_id'),
            'transactionPurchaseOrderDetails' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetail', 'product_id'),
            'transactionReceiveOrderDetails' => array(self::HAS_MANY, 'TransactionReceiveOrderDetail', 'product_id'),
            'transactionRequestOrderDetails' => array(self::HAS_MANY, 'TransactionRequestOrderDetail', 'product_id'),
            'transactionReturnItemDetails' => array(self::HAS_MANY, 'TransactionReturnItemDetail', 'product_id'),
            'warehouseSections' => array(self::HAS_MANY, 'WarehouseSection', 'product_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
            'unitIdConversion' => array(self::BELONGS_TO, 'Unit', 'unit_id_conversion'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
            'userIdEdit' => array(self::BELONGS_TO, 'Users', 'user_id_edit'),
            'userIdReject' => array(self::BELONGS_TO, 'Users', 'user_id_reject'),
            'registrationProducts' => array(self::HAS_MANY, 'RegistrationProduct', 'product_id'),
            'tireSize' => array(self::BELONGS_TO, 'TireSize', 'tire_size_id'),
            'oilSae' => array(self::BELONGS_TO, 'OilSae', 'oil_sae_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'manufacturer_code' => 'Manufacturer Code',
            'barcode' => 'Barcode',
            'name' => 'Name',
            'description' => 'Description',
            'production_year' => 'Production Year',
            'brand_id' => 'Brand',
            'sub_brand_id' => 'Sub Brand',
            'sub_brand_series_id' => 'Sub Series Brand',
            'extension' => 'Extension',
            'product_master_category_id' => 'Product Master Category',
            'product_sub_master_category_id' => 'Product Sub Master Category',
            'product_sub_category_id' => 'Product Sub Category',
            'vehicle_car_make_id' => 'Vehicle Car Make',
            'vehicle_car_model_id' => 'Vehicle Car Model',
            'purchase_price' => 'Purchase Price',
            'recommended_selling_price' => 'Recommended Selling Price',
            'hpp' => 'Hpp',
            'retail_price' => 'Retail Price',
            'stock' => 'Stock',
            'minimum_stock' => 'Minimum Stock',
            'minimum_selling_price' => 'Min Sell Price',
            'margin_type' => 'Margin Type',
            'margin_amount' => 'Margin Amount',
            'is_usable' => 'Is Usable',
            'status' => 'Status',
            'findkeyword' => 'Find By Keyword',
            'ppn' => 'Ppn',
            'unit_id' => 'Satuan',
            'unit_id_conversion' => 'Satuan Konversi',
            'unit_conversion_multiplier' => 'Konversi Perkalian',
            'user_id' => 'User Input',
            'date_posting' => 'Tanggal Input',
            'is_approved' => 'Approval',
            'user_id_approval' => 'User Approval',
            'date_approval' => 'Tanggal Approval',
            'user_id_edit' => 'User Edit',
            'date_edit' => 'Tanggal Edit',
            'tire_size_id' => 'Tire Size',
            'oil_sae_id' => 'Oil SAE',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('barcode', $this->barcode, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('production_year', $this->production_year);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.vehicle_car_make_id', $this->vehicle_car_make_id);
        $criteria->compare('t.vehicle_car_model_id', $this->vehicle_car_model_id);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('recommended_selling_price', $this->recommended_selling_price, true);
        $criteria->compare('hpp', $this->hpp, true);
        $criteria->compare('retail_price', $this->retail_price, true);
        $criteria->compare('stock', $this->stock);
        $criteria->compare('minimum_stock', $this->minimum_stock);
        $criteria->compare('minimum_selling_price', $this->minimum_selling_price);
        $criteria->compare('margin_type', $this->margin_type);
        $criteria->compare('margin_amount', $this->margin_amount);
        $criteria->compare('is_usable', $this->is_usable, true);
        $criteria->compare('LOWER(t.status)', strtolower($this->status), FALSE);
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.date_posting', $this->date_posting);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id_approval', $this->user_id_approval);
        $criteria->compare('t.tire_size_id', $this->tire_size_id);
        $criteria->compare('t.oil_sae_id', $this->oil_sae_id);

        $criteria->together = true;
        $criteria->with = array('productSubMasterCategory', 'productMasterCategory', 'productSubCategory', 'brand', 'subBrand', 'subBrandSeries');
        $criteria->compare('productMasterCategory.code', $this->product_master_category_code, true);
        $criteria->compare('productMasterCategory.name', $this->product_master_category_name, true);
        $criteria->compare('productSubMasterCategory.code', $this->product_sub_master_category_code, true);
        $criteria->compare('productSubMasterCategory.name', $this->product_sub_master_category_name, true);
        $criteria->compare('productSubCategory.code', $this->product_sub_category_code, true);
        $criteria->compare('productSubCategory.name', $this->product_sub_category_name, true);
        $criteria->compare('brand.name', $this->product_brand_name, true);
        $criteria->compare('subBrand.name', $this->product_sub_brand_name, true);
        $criteria->compare('subBrandSeries.name', $this->product_sub_brand_series_name, true);

        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {

            $criteria->compare('t.code', $key, true, 'AND');
            $criteria->compare('production_year', $key, true, 'AND');
            $criteria->compare('manufacturer_code', $key, true, 'AND');
            $criteria->compare('barcode', $key, true, 'AND');
            $criteria->compare('t.name', $key, true, 'AND');
            $criteria->compare('t.description', $key, true, 'AND');
            $criteria->compare('extension', $key, true, 'AND');

            $criteria->compare('productMasterCategory.code', $key, true, 'AND');
            $criteria->compare('productMasterCategory.name', $key, true, 'AND');
            $criteria->compare('productSubMasterCategory.code', $key, true, 'AND');
            $criteria->compare('productSubMasterCategory.name', $key, true, 'AND');

            $criteria->compare('brand.name', $key, true, 'AND');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                "defaultOrder" => "t.status ASC, t.name ASC",
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
                    'product_sub_category_code' => array(
                        'asc' => 'productSubMasterCategory.code',
                        'desc' => 'productSubMasterCategory.code DESC'
                    ),
                    '*'
                )
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }
    
    public function searchByDashboard() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('barcode', $this->barcode, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('production_year', $this->production_year);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.vehicle_car_make_id', $this->vehicle_car_make_id);
        $criteria->compare('t.vehicle_car_model_id', $this->vehicle_car_model_id);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('recommended_selling_price', $this->recommended_selling_price, true);
        $criteria->compare('hpp', $this->hpp, true);
        $criteria->compare('retail_price', $this->retail_price, true);
        $criteria->compare('stock', $this->stock);
        $criteria->compare('minimum_stock', $this->minimum_stock);
        $criteria->compare('margin_type', $this->margin_type);
        $criteria->compare('margin_amount', $this->margin_amount);
        $criteria->compare('is_usable', $this->is_usable, true);
        $criteria->compare('t.status', 'Active');
        $criteria->compare('ppn', $this->ppn);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.date_posting', $this->date_posting);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id_approval', $this->user_id_approval);

        $criteria->together = true;
        $criteria->with = array('productSubMasterCategory', 'productMasterCategory', 'productSubCategory', 'brand', 'subBrand', 'subBrandSeries');
        $criteria->compare('productMasterCategory.code', $this->product_master_category_code, true);
        $criteria->compare('productMasterCategory.name', $this->product_master_category_name, true);
        $criteria->compare('productSubMasterCategory.code', $this->product_sub_master_category_code, true);
        $criteria->compare('productSubMasterCategory.name', $this->product_sub_master_category_name, true);
        $criteria->compare('productSubCategory.code', $this->product_sub_category_code, true);
        $criteria->compare('productSubCategory.name', $this->product_sub_category_name, true);
        $criteria->compare('brand.name', $this->product_brand_name, true);
        $criteria->compare('subBrand.name', $this->product_sub_brand_name, true);
        $criteria->compare('subBrandSeries.name', $this->product_sub_brand_series_name, true);

        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {

            $criteria->compare('t.code', $key, true, 'AND');
            $criteria->compare('production_year', $key, true, 'AND');
            $criteria->compare('manufacturer_code', $key, true, 'AND');
            $criteria->compare('barcode', $key, true, 'AND');
            $criteria->compare('t.name', $key, true, 'AND');
            $criteria->compare('t.description', $key, true, 'AND');
            $criteria->compare('extension', $key, true, 'AND');

            $criteria->compare('productMasterCategory.code', $key, true, 'AND');
            $criteria->compare('productMasterCategory.name', $key, true, 'AND');
            $criteria->compare('productSubMasterCategory.code', $key, true, 'AND');
            $criteria->compare('productSubMasterCategory.name', $key, true, 'AND');
            // $criteria->compare('productSubCategory.code',$key,true,'OR');
            // $criteria->compare('productSubCategory.name',$key,true,'OR');

            $criteria->compare('brand.name', $key, true, 'AND');
        }
        // $criteria->compare('productSubCategory.code',$this->findkeyword,true,'OR');
        // $criteria->compare('productSubCategory.name',$this->findkeyword,true,'OR');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                "defaultOrder" => "t.status ASC, t.name ASC",
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
                    'product_sub_category_code' => array(
                        'asc' => 'productSubMasterCategory.code',
                        'desc' => 'productSubMasterCategory.code DESC'
                    ),
                    '*'
                )
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSuppliers() {
        $supplierList = "";
        $supplierProducts = $this->supplierProducts;
        foreach ($supplierProducts as $key => $supplierProduct) {
            $supplierList .= $supplierProduct->supplier_id;
        }
        return $supplierList;
    }

    public function getLocalStock($warehouseId) {
        $sql = "SELECT COALESCE(total_stock, 0) 
                FROM " . Inventory::model()->tableName() . " i
                WHERE product_id = :product_id AND warehouse_id = :warehouse_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->id,
            ':warehouse_id' => $warehouseId,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function getTotalStock($warehouseId) {
        $sql = "SELECT COALESCE(SUM(stock_in + stock_out), 0) as stock 
                FROM " . InventoryDetail::model()->tableName() . "
                WHERE product_id = :product_id AND warehouse_id = :warehouse_id";

        $value = CActiveRecord::$db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->id,
            ':warehouse_id' => $warehouseId,
        ));

        return ($value === false) ? 0 : $value;
    }

    public function searchByStockCheck($pageNumber, $endDate, $stockOperator) {

        $operatorConditionSql = '';
        
        if (!empty($stockOperator)) {
            $operatorConditionSql = "HAVING SUM(stock_in + stock_out) {$stockOperator} 0";
        }
        
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.status', 'Active');

        $criteria->addCondition("EXISTS (
            SELECT SUM(stock_in + stock_out) AS total_stock
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            WHERE t.id = i.product_id AND w.status = 'Active' AND i.transaction_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date "
            . $operatorConditionSql . " 
        )");
        $criteria->params[':end_date'] = $endDate;
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
                'currentPage' => $pageNumber - 1,
            ),
        ));
    }

    public function searchByTireSaleReport($pageNumber, $year, $month) {

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('t.product_master_category_id', 4);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.status', 'Active');

        $criteria->addCondition("EXISTS (
            SELECT d.product_id
            FROM " . InvoiceDetail::model()->tableName() . " d
            INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
            WHERE t.id = d.product_id AND h.user_id_cancelled IS NULL AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month
        ) AND t.product_sub_category_id IN (442, 443, 444)");
        $criteria->params[':year'] = $year;
        $criteria->params[':month'] = $month;
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
                'currentPage' => $pageNumber - 1,
            ),
        ));
    }

    public function searchByOilSaleReport($pageNumber, $year, $month) {

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('t.product_master_category_id', 6);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.status', 'Active');

        $criteria->addCondition("EXISTS (
            SELECT d.product_id
            FROM " . InvoiceDetail::model()->tableName() . " d
            INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
            WHERE t.id = d.product_id AND h.user_id_cancelled IS NULL AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month
        ) AND t.oil_sae_id IS NOT NULL");
        $criteria->params[':year'] = $year;
        $criteria->params[':month'] = $month;
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
                'currentPage' => $pageNumber - 1,
            ),
        ));
    }

    public function searchByStockCard() {

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.status', 'Active');

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 500,
            ),
        ));
    }

    public function searchBySaleEstimation($endDate) {
        
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.manufacturer_code', $this->manufacturer_code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.brand_id', $this->brand_id);
        $criteria->compare('t.sub_brand_id', $this->sub_brand_id);
        $criteria->compare('t.sub_brand_series_id', $this->sub_brand_series_id);
        $criteria->compare('t.product_master_category_id', $this->product_master_category_id);
        $criteria->compare('t.product_sub_master_category_id', $this->product_sub_master_category_id);
        $criteria->compare('t.product_sub_category_id', $this->product_sub_category_id);
        $criteria->compare('t.unit_id', $this->unit_id);
        $criteria->compare('t.status', 'Active');

        $criteria->addCondition("EXISTS (
            SELECT SUM(stock_in + stock_out) AS total_stock
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            WHERE t.id = i.product_id AND w.status = 'Active' AND i.transaction_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
            HAVING SUM(stock_in + stock_out) > 0
        )");
        $criteria->params[':end_date'] = $endDate;
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getInventoryTotalQuantities() {
        $sql = "SELECT w.branch_id, COALESCE(SUM(i.total_stock), 0) AS total_stock
                FROM " . Inventory::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                WHERE i.product_id = :product_id AND w.status = 'Active'
                GROUP BY w.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':product_id' => $this->id));

        return $resultSet;
    }

    public function getInventoryTotalQuantitiesByPeriodic($endDate) {
        $sql = "SELECT w.branch_id, COALESCE(SUM(i.stock_in + i.stock_out), 0) AS total_stock, MIN(COALESCE(i.purchase_price, 0)) AS stock_amount
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                WHERE i.product_id = :product_id AND w.status = 'Active' AND i.transaction_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY w.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':product_id' => $this->id, 
            ':end_date' => $endDate
        ));

        return $resultSet;
    }

    public function getTireSaleTotalQuantitiesReport($year, $month) {
        $sql = "SELECT h.branch_id, COALESCE(SUM(d.quantity), 0) AS total_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                WHERE d.product_id = :product_id AND h.user_id_cancelled IS NULL AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month
                GROUP BY h.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':product_id' => $this->id, 
            ':year' => $year,
            ':month' => $month
        ));

        return $resultSet;
    }

    public function getOilSaleTotalQuantitiesReport($year, $month) {
        $sql = "SELECT h.branch_id, COALESCE(SUM(d.quantity), 0) AS total_quantity
                FROM " . InvoiceDetail::model()->tableName() . " d
                INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
                WHERE d.product_id = :product_id AND h.user_id_cancelled IS NULL AND YEAR(h.invoice_date) = :year AND MONTH(h.invoice_date) = :month
                GROUP BY h.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':product_id' => $this->id, 
            ':year' => $year,
            ':month' => $month
        ));

        return $resultSet;
    }

    public function getInventoryCostOfGoodsSold() {
        $sql = "SELECT w.branch_id, COALESCE(p.hpp, 0) AS cogs
                FROM " . Inventory::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
                WHERE i.product_id = :product_id AND w.status = 'Active'
                GROUP BY w.branch_id";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(':product_id' => $this->id));

        return $resultSet;
    }

    public function getRetailPriceTax() {
        return $this->retail_price * 11 / 100;
    }

    public function getRetailPriceAfterTax() {
        return $this->retail_price + $this->retailPriceTax;
    }

    public function getRecommendedSellingPrice() {
        $marginAmount = ($this->margin_type == 1) ? $this->retailPriceAfterTax * $this->margin_amount / 100 : $this->margin_amount;

        return $this->retailPriceAfterTax + $marginAmount;
    }

    public function getMinimumSellingPrice() {
        $marginAmount = ($this->productSubMasterCategory->margin_type == 1) ? $this->retail_price * $this->productSubMasterCategory->margin_amount / 100 : $this->productSubMasterCategory->margin_amount;

        return $this->retail_price + $marginAmount;
    }

    public function getMasterSubCategoryCode() {
        $masterCategoryCode = empty($this->productMasterCategory) ? '' : $this->productMasterCategory->code;
        $subMasterCategory = empty($this->productSubMasterCategory) ? '' : $this->productSubMasterCategory->code;
        $subCategoryCode = empty($this->productSubCategory) ? '' : $this->productSubCategory->code;

        return $masterCategoryCode . $subMasterCategory . $subCategoryCode;
    }

    public function getInventoryStockReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':product_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id AND w.status = "Active"';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "SELECT i.transaction_number, i.transaction_date, i.transaction_type, i.notes, i.stock_in, i.stock_out, w.name AS warehouse, i.purchase_price
                FROM " . InventoryDetail::model()->tableName() . " i
                INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
                WHERE i.transaction_date BETWEEN :start_date AND :end_date AND i.product_id = :product_id AND w.status = 'Active'" . $branchConditionSql . "
                ORDER BY i.transaction_date ASC, i.id ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getBeginningStockReport($startDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':product_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(i.stock_in + i.stock_out), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            WHERE i.product_id = :product_id AND w.status = 'Active' AND i.transaction_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND transaction_date < :start_date" . $branchConditionSql . "
            GROUP BY i.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getBeginningValueReport($startDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':product_id' => $this->id,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM((i.stock_in + i.stock_out) * i.purchase_price), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            WHERE i.product_id = :product_id AND w.status = 'Active' AND i.transaction_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND transaction_date < :start_date" . $branchConditionSql . "
            GROUP BY i.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getBeginningStockCardReport($startDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':product_id' => $this->id,
            'start_date' => $startDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(i.stock_in + i.stock_out), 0) AS beginning_balance 
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            WHERE i.product_id = :product_id AND w.status = 'Active' AND i.transaction_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :start_date" . $branchConditionSql . "
            GROUP BY i.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getSalesQuantityReport($startDate, $endDate) {
        $sql = "
            SELECT COALESCE(SUM(p.quantity), 0) AS sales_quantity 
            FROM " . RegistrationProduct::model()->tableName() . " p
            INNER JOIN " . RegistrationTransaction::model()->tableName() . " h ON h.id = p.registration_transaction_id
            WHERE p.product_id = :product_id AND substr(h.transaction_date, 1, 10) BETWEEN :start_date AND :end_date
            GROUP BY p.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getMovementOutQuantityReport($startDate, $endDate) {
        $sql = "
            SELECT COALESCE(SUM(quantity), 0) AS beginning_balance 
            FROM " . MovementOutDetail::model()->tableName() . " d
            INNER JOIN " . MovementOutHeader::model()->tableName() . " h
            WHERE d.product_id = :product_id AND h.date_posting BETWEEN :start_date AND :end_date
            GROUP BY d.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getAverageCogs() {
        
        $sql = "
            SELECT COALESCE(SUM(d.total_price) / SUM(d.quantity), 0) as cogs
            FROM " . TransactionPurchaseOrderDetail::model()->tableName() . " d
            INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " h ON h.id = d.purchase_order_id
            WHERE d.product_id = :product_id AND h.status_document = 'Approved' AND h.purchase_order_date >= '" . AppParam::BEGINNING_TRANSACTION_DATE . "'
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->id,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getAverageSaleSixMonths() {
        
        $sql = "
            SELECT COALESCE(SUM(d.quantity)/6, 0) AS average_sales
            FROM " . InvoiceHeader::model()->tableName() . " h 
            INNER JOIN " . InvoiceDetail::model()->tableName() . " d on h.id = d.invoice_id
            WHERE h.invoice_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) and product_id = :product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':product_id' => $this->id,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getPurchasePriceReport($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $params = array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $sql = "
            SELECT COALESCE(SUM(d.total_price), 0) AS total_purchase 
            FROM " . TransactionPurchaseOrderDetail::model()->tableName() . " d
            INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " h ON h.id = d.purchase_order_id
            WHERE d.product_id = :product_id AND substr(h.purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND h.status_document NOT LIKE '%CANCEL%'" . $branchConditionSql . "
            GROUP BY d.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
    public function getTotalSales($startDate, $endDate, $branchId, $customerType) {
        $branchConditionSql = '';
        $customerTypeConditionSql = '';
        
        $params = array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($customerType)) {
            $customerTypeConditionSql = ' AND c.customer_type = :customer_type';
            $params[':customer_type'] = $customerType;
        }
        
        $sql = "
            SELECT COALESCE(SUM(p.total_price), 0) AS total 
            FROM " . InvoiceDetail::model()->tableName() . " p 
            INNER JOIN " . InvoiceHeader::model()->tableName() . " r ON r.id = p.invoice_id
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
            WHERE p.product_id = :product_id AND substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCEL%'" . $branchConditionSql . $customerTypeConditionSql . "
            GROUP BY p.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
     
    public function getTotalQuantitySales($startDate, $endDate, $branchId, $customerType) {
        $branchConditionSql = '';
        $customerTypeConditionSql = '';
        
        $params = array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($customerType)) {
            $customerTypeConditionSql = ' AND c.customer_type = :customer_type';
            $params[':customer_type'] = $customerType;
        }
        
        $sql = "
            SELECT COALESCE(SUM(p.quantity), 0) AS total 
            FROM " . InvoiceDetail::model()->tableName() . " p 
            INNER JOIN " . InvoiceHeader::model()->tableName() . " r ON r.id = p.invoice_id
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
            WHERE p.product_id = :product_id AND substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCEL%'" . $branchConditionSql . $customerTypeConditionSql . "
            GROUP BY p.product_id
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }
    
//    public function getSaleRetailReport($startDate, $endDate) {
//        
//        $sql = "SELECT r.transaction_number, r.transaction_date, r.repair_type, c.name as customer, v.plate_number as vehicle, p.quantity, p.sale_price, p.total_price
//                FROM " . RegistrationProduct::model()->tableName() . " p 
//                INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = p.registration_transaction_id
//                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
//                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
//                WHERE substr(r.transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND product_id = :product_id
//                ORDER BY r.transaction_date ASC";
//        
//        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
//            ':start_date' => $startDate,
//            ':end_date' => $endDate,
//            ':product_id' => $this->id,
//        ));
//        
//        return $resultSet;
//    }
    
    public function getSaleRetailProductDetailReport($startDate, $endDate, $branchId, $customerType) {
        $branchConditionSql = '';
        $customerTypeConditionSql = '';
        
        $params = array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($customerType)) {
            $customerTypeConditionSql = ' AND c.customer_type = :customer_type';
            $params[':customer_type'] = $customerType;
        }
        
        $sql = "SELECT r.invoice_number, r.invoice_date, c.name as customer, v.plate_number as vehicle, p.quantity, p.unit_price, p.total_price
                FROM " . InvoiceDetail::model()->tableName() . " p 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " r ON r.id = p.invoice_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
                WHERE substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND p.product_id = :product_id AND r.status NOT LIKE '%CANCEL%'" . $branchConditionSql . $customerTypeConditionSql . "
                ORDER BY r.invoice_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getPurchasePerProductReport($startDate, $endDate, $branchId, $supplierId) {
        $branchConditionSql = '';
        $supplierConditionSql = '';
        
        $params = array(
            ':product_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.main_branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($supplierId)) {
            $supplierConditionSql = ' AND h.supplier_id = :supplier_id';
            $params[':supplier_id'] = $supplierId;
        }
        
        $sql = "
            SELECT h.id, h.purchase_order_no, h.purchase_order_date, s.company, d.quantity, d.retail_price, d.discount, d.unit_price, d.total_price
            FROM " . TransactionPurchaseOrder::model()->tableName() . " h
            INNER JOIN " . TransactionPurchaseOrderDetail::model()->tableName() . " d ON h.id = d.purchase_order_id
            INNER JOIN " . Supplier::model()->tableName() . " s ON s.id = h.supplier_id
            WHERE d.product_id = :product_id AND substr(h.purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND 
                h.status_document NOT LIKE '%CANCEL%'" . $branchConditionSql . $supplierConditionSql . "
            ORDER BY h.purchase_order_date, h.purchase_order_no
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);
        
        return $resultSet;
    }
    
    public function getNameAndSpecification() {
        $nameAndSpec = $this->name;
        
        if ($this->product_sub_master_category_id == 26) {
            $nameAndSpec .= $this->tire_size_id === null ? '' : (' - ' . $this->tireSize->tireName);
        } else if ($this->product_sub_master_category_id == 39 || $this->product_sub_master_category_id == 40) {
            $nameAndSpec .= $this->oil_sae_id === null ? '' : (' - ' . $this->oilSae->oilName);
        }
        
        return $nameAndSpec;
    }
}