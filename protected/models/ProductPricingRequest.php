<?php

/**
 * This is the model class for table "{{product_pricing_request}}".
 *
 * The followings are the available columns in table '{{product_pricing_request}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $request_note
 * @property string $reply_note
 * @property string $recommended_sale_price
 * @property integer $branch_id_request
 * @property integer $branch_id_reply
 *
 * The followings are the available model relations:
 * @property Branch $branchIdRequest
 * @property Branch $branchIdReply
 */
class ProductPricingRequest extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product_pricing_request}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, branch_id_request, branch_id_reply', 'required'),
            array('branch_id_request, branch_id_reply', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 20),
            array('recommended_sale_price', 'length', 'max' => 18),
            array('request_note, reply_note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, request_note, reply_note, recommended_sale_price, branch_id_request, branch_id_reply', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'branchIdRequest' => array(self::BELONGS_TO, 'Branch', 'branch_id_request'),
            'branchIdReply' => array(self::BELONGS_TO, 'Branch', 'branch_id_reply'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'transaction_time' => 'Transaction Time',
            'request_note' => 'Request Note',
            'reply_note' => 'Reply Note',
            'recommended_sale_price' => 'Recommended Sale Price',
            'branch_id_request' => 'Branch Id Request',
            'branch_id_reply' => 'Branch Id Reply',
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('request_note', $this->request_note, true);
        $criteria->compare('reply_note', $this->reply_note, true);
        $criteria->compare('recommended_sale_price', $this->recommended_sale_price, true);
        $criteria->compare('branch_id_request', $this->branch_id_request);
        $criteria->compare('branch_id_reply', $this->branch_id_reply);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductPricingRequest the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
