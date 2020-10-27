<?php

/**
 * This is the model class for table "{{product_price}}".
 *
 * The followings are the available columns in table '{{product_price}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $supplier_id
 * @property string $purchase_price
 * @property string $purchase_date
 * @property integer $quantity
 * @property string $hpp
 * @property string $hpp_average
 *
 * The followings are the available model relations:
 * @property Product $product
 * @property Supplier $supplier
 */
class ProductPrice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product_price}}';
    }

    public $product_master_category_name;
    public $product_name;
    public $supplier_name;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, supplier_id, purchase_price, purchase_date, quantity, hpp, hpp_average', 'required'),
            array('product_id, supplier_id, quantity', 'numerical', 'integerOnly' => true),
            array('purchase_price, hpp, hpp_average', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, product_id, supplier_id, purchase_price, purchase_date, product_name, supplier_name, quantity, hpp, hpp_average', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'product_id' => 'Product',
            'supplier_id' => 'Supplier',
            'purchase_price' => 'Purchase Price',
            'purchase_date' => 'Purchase Date',
            'quantity' => 'Quantity',
            'hpp' => 'Hpp',
            'hpp_average' => 'Hpp Average',
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
    public function beforeSave() {
        if ($this->isNewRecord)
            $this->purchase_date = date("Y-m-d");

        return parent::beforeSave();
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('supplier_id', $this->supplier_id);
        $criteria->compare('purchase_price', $this->purchase_price, true);
        $criteria->compare('purchase_date', $this->purchase_date, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('hpp', $this->hpp, true);
        $criteria->compare('hpp_average', $this->hpp_average, true);

        $criteria->together = true;
        $criteria->with = array('product', 'supplier');
        $criteria->compare('product.name', $this->product_name, true);
//		$criteria->compare('supplier.name',$this->supplier_name,true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductPrice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}