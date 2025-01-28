<?php

/**
 * This is the model class for table "{{product_pricing_request}}".
 *
 * The followings are the available columns in table '{{product_pricing_request}}':
 * @property integer $id
 * @property string $recommended_price
 * @property string $request_date
 * @property string $quantity
 * @property integer $user_id_request
 * @property integer $user_id_reply
 * @property string $extension
 * @property string $reply_date
 * @property string $request_time
 * @property string $reply_time
 * @property string $request_note
 * @property string $reply_note
 * @property integer $branch_id_request
 * @property integer $branch_id_reply
 * @property string $product_name
 * @property string $vehicle_name
 * @property integer $production_year
 * @property string $brand_name
 * @property string $category_name
 *
 * The followings are the available model relations:
 * @property Users $userIdRequest
 * @property Users $userIdReply
 * @property Branch $branchIdRequest
 * @property Branch $branchIdReply
 */
class ProductPricingRequest extends CActiveRecord {

    public $file;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rims_product_pricing_request';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_date, user_id_request, branch_id_request, product_name', 'required'),
            array('user_id_request, user_id_reply, branch_id_request, branch_id_reply, production_year', 'numerical', 'integerOnly' => true),
            array('recommended_price', 'length', 'max' => 18),
            array('quantity', 'length', 'max' => 10),
            array('extension', 'length', 'max' => 5),
            array('product_name, vehicle_name, brand_name, category_name', 'length', 'max' => 100),
            array('reply_date, request_time, reply_time, request_note, reply_note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, recommended_price, request_date, quantity, user_id_request, user_id_reply, extension, reply_date, request_time, reply_time, request_note, reply_note, branch_id_request, branch_id_reply, product_name, vehicle_name, production_year, brand_name, category_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userIdRequest' => array(self::BELONGS_TO, 'Users', 'user_id_request'),
            'userIdReply' => array(self::BELONGS_TO, 'Users', 'user_id_reply'),
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
            'recommended_price' => 'Recommended Price',
            'request_date' => 'Request Date',
            'quantity' => 'Quantity',
            'user_id_request' => 'User Id Request',
            'user_id_reply' => 'User Id Reply',
            'extension' => 'Extension',
            'reply_date' => 'Reply Date',
            'request_time' => 'Request Time',
            'reply_time' => 'Reply Time',
            'request_note' => 'Request Note',
            'reply_note' => 'Reply Note',
            'branch_id_request' => 'Branch Id Request',
            'branch_id_reply' => 'Branch Id Reply',
            'product_name' => 'Product Name',
            'vehicle_name' => 'Vehicle Name',
            'production_year' => 'Production Year',
            'brand_name' => 'Brand Name',
            'category_name' => 'Category Name',
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
        $criteria->compare('recommended_price', $this->recommended_price, true);
        $criteria->compare('request_date', $this->request_date, true);
        $criteria->compare('quantity', $this->quantity, true);
        $criteria->compare('user_id_request', $this->user_id_request);
        $criteria->compare('user_id_reply', $this->user_id_reply);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('reply_date', $this->reply_date, true);
        $criteria->compare('request_time', $this->request_time, true);
        $criteria->compare('reply_time', $this->reply_time, true);
        $criteria->compare('request_note', $this->request_note, true);
        $criteria->compare('reply_note', $this->reply_note, true);
        $criteria->compare('branch_id_request', $this->branch_id_request);
        $criteria->compare('branch_id_reply', $this->branch_id_reply);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('vehicle_name', $this->vehicle_name, true);
        $criteria->compare('production_year', $this->production_year);
        $criteria->compare('brand_name', $this->brand_name, true);
        $criteria->compare('category_name', $this->category_name, true);

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
