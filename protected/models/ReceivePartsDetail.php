<?php

/**
 * This is the model class for table "{{receive_parts_detail}}".
 *
 * The followings are the available columns in table '{{receive_parts_detail}}':
 * @property integer $id
 * @property string $quantity
 * @property string $quantity_movement
 * @property string $quantity_movement_left
 * @property string $memo
 * @property integer $receive_parts_header_id
 * @property integer $registration_product_id
 * @property integer $product_id
 *
 * The followings are the available model relations:
 * @property ReceivePartsHeader $receivePartsHeader
 * @property RegistrationProduct $registrationProduct
 * @property Product $product
 * @property MovementInDetail[] $movementInDetails
 */
class ReceivePartsDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{receive_parts_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('receive_parts_header_id, registration_product_id, product_id', 'required'),
            array('receive_parts_header_id, registration_product_id, product_id', 'numerical', 'integerOnly' => true),
            array('quantity, quantity_movement, quantity_movement_left', 'length', 'max' => 10),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, quantity, quantity_movement, quantity_movement_left, memo, receive_parts_header_id, registration_product_id, product_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'receivePartsHeader' => array(self::BELONGS_TO, 'ReceivePartsHeader', 'receive_parts_header_id'),
            'registrationProduct' => array(self::BELONGS_TO, 'RegistrationProduct', 'registration_product_id'),
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
            'movementInDetails' => array(self::HAS_MANY, 'MovementInDetail', 'receive_parts_detail_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'quantity_movement' => 'Quantity Movement',
            'quantity_movement_left' => 'Quantity Movement Left',
            'memo' => 'Memo',
            'receive_parts_header_id' => 'Receive Parts Header',
            'registration_product_id' => 'Registration Product',
            'product_id' => 'Product',
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
        $criteria->compare('quantity_movement', $this->quantity_movement, true);
        $criteria->compare('quantity_movement_left', $this->quantity_movement_left, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('receive_parts_header_id', $this->receive_parts_header_id);
        $criteria->compare('registration_product_id', $this->registration_product_id);
        $criteria->compare('product_id', $this->product_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ReceivePartsDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getQuantityMovement() {
        $total = 0;
        
        foreach ($this->movementInDetails as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }
    
    public function getQuantityMovementLeft() {
        return $this->quantity - $this->quantity_movement;
    }
}