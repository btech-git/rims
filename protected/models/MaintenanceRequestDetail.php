<?php

/**
 * This is the model class for table "{{maintenance_request_detail}}".
 *
 * The followings are the available columns in table '{{maintenance_request_detail}}':
 * @property integer $id
 * @property string $item_code
 * @property string $item_name
 * @property integer $quantity
 * @property string $memo
 * @property integer $maintenance_request_header_id
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property MaintenanceRequestHeader $maintenanceRequestHeader
 */
class MaintenanceRequestDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{maintenance_request_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_name, maintenance_request_header_id', 'required'),
            array('quantity, maintenance_request_header_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('item_code', 'length', 'max' => 60),
            array('item_name, memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, item_code, item_name, quantity, memo, maintenance_request_header_id, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'maintenanceRequestHeader' => array(self::BELONGS_TO, 'MaintenanceRequestHeader', 'maintenance_request_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'item_code' => 'Item Code',
            'item_name' => 'Item Name',
            'quantity' => 'Quantity',
            'memo' => 'Memo',
            'maintenance_request_header_id' => 'Maintenance Request Header',
            'is_inactive' => 'Is Inactive',
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
        $criteria->compare('item_code', $this->item_code, true);
        $criteria->compare('item_name', $this->item_name, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('maintenance_request_header_id', $this->maintenance_request_header_id);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MaintenanceRequestDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
