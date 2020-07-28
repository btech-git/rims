<?php

/**
 * This is the model class for table "{{product_master_category}}".
 *
 * The followings are the available columns in table '{{product_master_category}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $status
 * @property integer $coa_persediaan_barang_dagang
 * @property integer $coa_hpp
 * @property integer $coa_penjualan_barang_dagang
 * @property integer $coa_retur_penjualan
 * @property integer $coa_diskon_penjualan
 * @property integer $coa_retur_pembelian
 * @property integer $coa_diskon_pembelian
 * @property integer $coa_inventory_in_transit
 * @property integer $coa_consignment_inventory
 *
 * The followings are the available model relations:
 * @property Product[] $products
 * @property Coa $coaPersediaanBarangDagang
 * @property Coa $coaHpp
 * @property Coa $coaPenjualanBarangDagang
 * @property Coa $coaReturPenjualan
 * @property Coa $coaDiskonPenjualan
 * @property Coa $coaReturPembelian
 * @property Coa $coaDiskonPembelian
 * @property Coa $coaInventoryInTransit
 * @property Coa $coaConsignmentInventory
 * @property ProductSubCategory[] $productSubCategories
 * @property ProductSubMasterCategory[] $productSubMasterCategories
 */
class ProductMasterCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $coa_persediaan_barang_dagang_name;
	public $coa_persediaan_barang_dagang_code;
	public $coa_hpp_name;
	public $coa_hpp_code;
	public $coa_penjualan_barang_dagang_name;
	public $coa_penjualan_barang_dagang_code;
	public $coa_retur_penjualan_name;
	public $coa_retur_penjualan_code;
	public $coa_diskon_penjualan_name;
	public $coa_diskon_penjualan_code;
	public $coa_retur_pembelian_name;
	public $coa_retur_pembelian_code;
	public $coa_diskon_pembelian_name;
	public $coa_diskon_pembelian_code;
	public $coa_inventory_in_transit_code;
	public $coa_inventory_in_transit_name;
	public $coa_consignment_inventory_name;
	public $coa_consignment_inventory_code;
	public function tableName()
	{
		return '{{product_master_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, status', 'required'),
			array('coa_persediaan_barang_dagang, coa_hpp, coa_penjualan_barang_dagang, coa_retur_penjualan, coa_diskon_penjualan, coa_retur_pembelian, coa_diskon_pembelian, coa_inventory_in_transit, coa_consignment_inventory', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>20),
			array('name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>10),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, description, status, coa_persediaan_barang_dagang, coa_hpp, coa_penjualan_barang_dagang, coa_retur_penjualan, coa_diskon_penjualan, coa_retur_pembelian, coa_diskon_pembelian, coa_inventory_in_transit, coa_consignment_inventory,coa_persediaan_barang_dagang_name, coa_hpp_name, coa_penjualan_barang_dagang_name, coa_retur_penjualan_name, coa_diskon_penjualan_name, coa_retur_pembelian_name, coa_diskon_pembelian_name,coa_persediaan_barang_dagang_code, coa_hpp_code, coa_penjualan_barang_dagang_code, coa_retur_penjualan_code, coa_diskon_penjualan_code, coa_retur_pembelian_code, coa_diskon_pembelian_code, coa_inventory_in_transit, coa_inventory_in_transit_name, coa_inventory_in_transit_code, coa_consignment_inventory,coa_consignment_inventory_name, coa_consignment_inventory_code', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'products' => array(self::HAS_MANY, 'Product', 'product_master_category_id'),
			'coaPersediaanBarangDagang' => array(self::BELONGS_TO, 'Coa', 'coa_persediaan_barang_dagang'),
			'coaHpp' => array(self::BELONGS_TO, 'Coa', 'coa_hpp'),
			'coaPenjualanBarangDagang' => array(self::BELONGS_TO, 'Coa', 'coa_penjualan_barang_dagang'),
			'coaReturPenjualan' => array(self::BELONGS_TO, 'Coa', 'coa_retur_penjualan'),
			'coaDiskonPenjualan' => array(self::BELONGS_TO, 'Coa', 'coa_diskon_penjualan'),
			'coaReturPembelian' => array(self::BELONGS_TO, 'Coa', 'coa_retur_pembelian'),
			'coaDiskonPembelian' => array(self::BELONGS_TO, 'Coa', 'coa_diskon_pembelian'),
			'coaInventoryInTransit' => array(self::BELONGS_TO, 'Coa', 'coa_inventory_in_transit'),
			'coaConsignmentInventory' => array(self::BELONGS_TO, 'Coa', 'coa_consignment_inventory'),
			'productSubCategories' => array(self::HAS_MANY, 'ProductSubCategory', 'product_master_category_id'),
			'productSubMasterCategories' => array(self::HAS_MANY, 'ProductSubMasterCategory', 'product_master_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'name' => 'Name',
			'description' => 'Description',
			'status' => 'Status',
			'coa_persediaan_barang_dagang' => 'Coa Persediaan Barang Dagang',
			'coa_hpp' => 'Coa Hpp',
			'coa_penjualan_barang_dagang' => 'Coa Penjualan Barang Dagang',
			'coa_retur_penjualan' => 'Coa Retur Penjualan',
			'coa_diskon_penjualan' => 'Coa Diskon Penjualan',
			'coa_retur_pembelian' => 'Coa Retur Pembelian',
			'coa_diskon_pembelian' => 'Coa Diskon Pembelian',
			'coa_inventory_in_transit' => 'Coa Inventory In Transit',
			'coa_consignment_inventory' => 'Coa Consignment Inventory',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);
		$criteria->compare('coa_persediaan_barang_dagang',$this->coa_persediaan_barang_dagang);
		$criteria->compare('coa_hpp',$this->coa_hpp);
		$criteria->compare('coa_penjualan_barang_dagang',$this->coa_penjualan_barang_dagang);
		$criteria->compare('coa_retur_penjualan',$this->coa_retur_penjualan);
		$criteria->compare('coa_diskon_penjualan',$this->coa_diskon_penjualan);
		$criteria->compare('coa_retur_pembelian',$this->coa_retur_pembelian);
		$criteria->compare('coa_diskon_pembelian',$this->coa_diskon_pembelian);
		$criteria->compare('coa_inventory_in_transit',$this->coa_inventory_in_transit);
		$criteria->compare('coa_consignment_inventory',$this->coa_consignment_inventory);

		$criteria->together=true;
		$criteria->with = array('coaPersediaanBarangDagang','coaHpp','coaPenjualanBarangDagang','coaReturPenjualan','coaDiskonPenjualan','coaReturPembelian','coaDiskonPembelian','coaInventoryInTransit','coaConsignmentInventory');
		$criteria->compare('coaPersediaanBarangDagang.code',$this->coa_persediaan_barang_dagang_code);
		$criteria->compare('coaPersediaanBarangDagang.name',$this->coa_persediaan_barang_dagang_name,true);
		$criteria->compare('coaHpp.code',$this->coa_hpp_code,true);
		$criteria->compare('coaHpp.name',$this->coa_hpp_name,true);
		$criteria->compare('coaPenjualanBarangDagang.code',$this->coa_penjualan_barang_dagang_code,true);
		$criteria->compare('coaPenjualanBarangDagang.name',$this->coa_penjualan_barang_dagang_name,true);
		$criteria->compare('coaReturPenjualan.code',$this->coa_retur_penjualan_code,true);
		$criteria->compare('coaReturPenjualan.name',$this->coa_retur_penjualan_name,true);
		$criteria->compare('coaDiskonPenjualan.code',$this->coa_diskon_penjualan_code,true);
		$criteria->compare('coaDiskonPenjualan.name',$this->coa_diskon_penjualan_name,true);
		$criteria->compare('coaReturPembelian.code',$this->coa_retur_pembelian_code,true);
		$criteria->compare('coaReturPembelian.name',$this->coa_retur_pembelian_name,true);
		$criteria->compare('coaDiskonPembelian.code',$this->coa_diskon_pembelian_code,true);
		$criteria->compare('coaDiskonPembelian.name',$this->coa_diskon_pembelian_name,true);
		$criteria->compare('coaInventoryInTransit.code',$this->coa_inventory_in_transit_code,true);
		$criteria->compare('coaInventoryInTransit.name',$this->coa_inventory_in_transit_name,true);
		$criteria->compare('coaConsignmentInventory.code',$this->coa_consignment_inventory_code,true);
		$criteria->compare('coaConsignmentInventory.name',$this->coa_consignment_inventory_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
                'defaultOrder' => 't.status ASC, t.name ASC',
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductMasterCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getNameAndCode() {
        return $this->name . ' - ' . $this->code;
    }
}
