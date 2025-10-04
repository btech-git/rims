<?php

/**
 * This is the model class for table "{{product_pricing_request_header}}".
 *
 * The followings are the available columns in table '{{product_pricing_request_header}}':
 * @property integer $id
 * @property string $request_date
 * @property integer $user_id_request
 * @property integer $user_id_reply
 * @property string $extension
 * @property string $reply_date
 * @property string $request_time
 * @property string $reply_time
 * @property string $request_note
 * @property string $reply_note
 * @property integer $production_year
 * @property integer $branch_id_request
 * @property integer $branch_id_reply
 * @property integer $vehicle_car_make_id
 * @property integer $vehicle_car_model_id
 * @property integer $vehicle_car_sub_model_id
 * @property integer $is_inactive
 * @property string $transaction_number
 *
 * The followings are the available model relations:
 * @property ProductPricingRequestDetail[] $productPricingRequestDetails
 * @property Branch $branchIdReply
 * @property VehicleCarMake $vehicleCarMake
 * @property VehicleCarModel $vehicleCarModel
 * @property VehicleCarSubModel $vehicleCarSubModel
 * @property Branch $branchIdRequest
 * @property Users $userIdReply
 * @property Users $userIdRequest
 */
class ProductPricingRequestHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'PPR';
    
    public $file;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{product_pricing_request_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_date, user_id_request, request_time, request_note, branch_id_request, transaction_number', 'required'),
            array('user_id_request, user_id_reply, production_year, branch_id_request, branch_id_reply, vehicle_car_make_id, vehicle_car_model_id, vehicle_car_sub_model_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('extension', 'length', 'max' => 5),
            array('transaction_number', 'length', 'max' => 60),
            array('reply_date, reply_time, reply_note, file', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, request_date, user_id_request, user_id_reply, extension, reply_date, request_time, reply_time, request_note, reply_note, production_year, branch_id_request, branch_id_reply, vehicle_car_make_id, vehicle_car_model_id, vehicle_car_sub_model_id, is_inactive, transaction_number, file', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productPricingRequestDetails' => array(self::HAS_MANY, 'ProductPricingRequestDetail', 'product_pricing_request_header_id'),
            'branchIdReply' => array(self::BELONGS_TO, 'Branch', 'branch_id_reply'),
            'vehicleCarMake' => array(self::BELONGS_TO, 'VehicleCarMake', 'vehicle_car_make_id'),
            'vehicleCarModel' => array(self::BELONGS_TO, 'VehicleCarModel', 'vehicle_car_model_id'),
            'vehicleCarSubModel' => array(self::BELONGS_TO, 'VehicleCarSubModel', 'vehicle_car_sub_model_id'),
            'branchIdRequest' => array(self::BELONGS_TO, 'Branch', 'branch_id_request'),
            'userIdReply' => array(self::BELONGS_TO, 'Users', 'user_id_reply'),
            'userIdRequest' => array(self::BELONGS_TO, 'Users', 'user_id_request'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'request_date' => 'Request Date',
            'user_id_request' => 'User Id Request',
            'user_id_reply' => 'User Id Reply',
            'extension' => 'Extension',
            'reply_date' => 'Reply Date',
            'request_time' => 'Request Time',
            'reply_time' => 'Reply Time',
            'request_note' => 'Request Note',
            'reply_note' => 'Reply Note',
            'production_year' => 'Production Year',
            'branch_id_request' => 'Branch Id Request',
            'branch_id_reply' => 'Branch Id Reply',
            'vehicle_car_make_id' => 'Vehicle Car Make',
            'vehicle_car_model_id' => 'Vehicle Car Model',
            'vehicle_car_sub_model_id' => 'Vehicle Car Sub Model',
            'is_inactive' => 'Is Inactive',
            'transaction_number' => 'Transaction Number',
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
        $criteria->compare('request_date', $this->request_date, true);
        $criteria->compare('user_id_request', $this->user_id_request);
        $criteria->compare('user_id_reply', $this->user_id_reply);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('reply_date', $this->reply_date, true);
        $criteria->compare('request_time', $this->request_time, true);
        $criteria->compare('reply_time', $this->reply_time, true);
        $criteria->compare('request_note', $this->request_note, true);
        $criteria->compare('reply_note', $this->reply_note, true);
        $criteria->compare('production_year', $this->production_year);
        $criteria->compare('branch_id_request', $this->branch_id_request);
        $criteria->compare('branch_id_reply', $this->branch_id_reply);
        $criteria->compare('vehicle_car_make_id', $this->vehicle_car_make_id);
        $criteria->compare('vehicle_car_model_id', $this->vehicle_car_model_id);
        $criteria->compare('vehicle_car_sub_model_id', $this->vehicle_car_sub_model_id);
        $criteria->compare('is_inactive', $this->is_inactive);
        $criteria->compare('transaction_number', $this->transaction_number, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.request_date DESC, t.id DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductPricingRequestHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
