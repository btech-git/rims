<?php

/**
 * This is the model class for table "{{payment_in_images}}".
 *
 * The followings are the available columns in table '{{payment_in_images}}':
 * @property integer $id
 * @property integer $payment_in_id
 * @property string $extension
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property PaymentIn $paymentIn
 */
class PaymentInImages extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{payment_in_images}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_in_id, extension', 'required'),
            array('payment_in_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('extension', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, payment_in_id, extension, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentIn' => array(self::BELONGS_TO, 'PaymentIn', 'payment_in_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'payment_in_id' => 'Payment In',
            'extension' => 'Extension',
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
        $criteria->compare('payment_in_id', $this->payment_in_id);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PaymentInImages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getFilename() {
        return $this->id . '.' . $this->extension;
    }

    public function getThumbname() {
        return $this->payment_in_id . '-' . $this->payment_in_id . '-realization-thumb.' . $this->extension;
    }

    public function getSquarename() {
        return $this->payment_in_id . '-' . $this->payment_in_id . '-realization-square.' . $this->extension;
    }

}
