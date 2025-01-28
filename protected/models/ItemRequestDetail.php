<?php

/**
 * This is the model class for table "{{item_request_detail}}".
 *
 * The followings are the available columns in table '{{item_request_detail}}':
 * @property integer $id
 * @property string $quantity
 * @property string $unit_price
 * @property string $total_price
 * @property string $item_name
 * @property string $description
 * @property integer $item_request_header_id
 * @property integer $unit_id
 *
 * The followings are the available model relations:
 * @property ItemRequestHeader $itemRequestHeader
 * @property Unit $unit
 */
class ItemRequestDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{item_request_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_name, item_request_header_id, unit_id', 'required'),
            array('item_request_header_id, unit_id', 'numerical', 'integerOnly' => true),
            array('quantity', 'length', 'max' => 10),
            array('unit_price, total_price', 'length', 'max' => 18),
            array('item_name', 'length', 'max' => 100),
            array('description', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, quantity, unit_price, total_price, item_name, description, item_request_header_id, unit_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'itemRequestHeader' => array(self::BELONGS_TO, 'ItemRequestHeader', 'item_request_header_id'),
            'unit' => array(self::BELONGS_TO, 'Unit', 'unit_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'unit_price' => 'Unit Price',
            'total_price' => 'Total Price',
            'item_name' => 'Item Name',
            'description' => 'Description',
            'item_request_header_id' => 'Item Request Header',
            'unit_id' => 'Unit',
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
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('unit_price', $this->unit_price, true);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('item_request_header_id', $this->item_request_header_id);
        $criteria->compare('unit_id', $this->unit_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemRequestDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalPrice() {
        
        return $this->quantity * $this->unit_price;
    }
}
