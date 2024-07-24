<?php

/**
 * This is the model class for table "{{employee_branch_division_position_level}}".
 *
 * The followings are the available columns in table '{{employee_branch_division_position_level}}':
 * @property integer $id
 * @property integer $warehouse_id
 * @property integer $branch_id
 * @property integer $product_master_category_id
 *
 * The followings are the available model relations:
 * @property Warehouse $warehouse
 * @property ProductMasterCategory $productMasterCategory
 * @property Branch $branch
 */
class WarehouseBranchProductCategory extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return WarehouseBranchProductCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{warehouse_branch_product_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('warehouse_id, branch_id, product_master_category_id', 'required'),
            array('warehouse_id, branch_id, product_master_category_id', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, warehouse_id, branch_id, product_master_category_id', 'safe', 'on' => 'search'),
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
            'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'warehouse_id' => 'Warehouse',
            'branch_id' => 'Branch',
            'product_master_category_id' => 'Product Category',
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
        $criteria->compare('warehouse_id', $this->warehouse_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('product_master_category_id', $this->product_master_category_id);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
