<?php

/**
 * This is the model class for table "{{registration_package}}".
 *
 * The followings are the available columns in table '{{registration_package}}':
 * @property integer $id
 * @property integer $quantity
 * @property string $price
 * @property integer $sale_package_header_id
 * @property integer $registration_transaction_id
 * @property integer $is_inactive
 * @property string $total_price
 *
 * The followings are the available model relations:
 * @property RegistrationTransaction $registrationTransaction
 * @property SalePackageHeader $salePackageHeader
 */
class RegistrationPackage extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{registration_package}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sale_package_header_id, registration_transaction_id', 'required'),
            array('quantity, sale_package_header_id, registration_transaction_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('price, total_price', 'length', 'max' => 18),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, quantity, price, sale_package_header_id, registration_transaction_id, is_inactive, total_price', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'salePackageHeader' => array(self::BELONGS_TO, 'SalePackageHeader', 'sale_package_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'sale_package_header_id' => 'Sale Package Header',
            'registration_transaction_id' => 'Registration Transaction',
            'is_inactive' => 'Is Inactive',
            'total_price' => 'Total Price',
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
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('sale_package_header_id', $this->sale_package_header_id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RegistrationPackage the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTotalPrice() {
        
        return $this->quantity * $this->price;
    }
}
