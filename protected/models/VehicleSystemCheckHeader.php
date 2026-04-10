<?php

/**
 * This is the model class for table "{{vehicle_system_check_header}}".
 *
 * The followings are the available columns in table '{{vehicle_system_check_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $accu_type_before_service
 * @property string $accu_type_after_service
 * @property string $electrical_condition_after_service
 * @property string $undercarriage_condition_after_service
 * @property string $underhood_condition_after_service
 * @property string $underhood_note
 * @property string $body_repair_note
 * @property string $vehicle_condition_recommendation
 * @property string $next_service_recommendation
 * @property integer $next_service_kilometer
 * @property integer $registration_transaction_id
 * @property integer $user_id_created
 * @property string $created_datetime
 * @property integer $user_id_edited
 * @property string $edited_datetime
 * @property integer $branch_id
 * @property integer $user_id_cancelled
 * @property string $cancelled_datetime
 * @property integer $product_id_front_left_before_service
 * @property integer $product_id_front_left_after_service
 * @property integer $product_id_front_right_before_service
 * @property integer $product_id_front_right_after_service
 * @property integer $product_id_rear_left_before_service
 * @property integer $product_id_rear_left_after_service
 * @property integer $product_id_rear_right_before_service
 * @property integer $product_id_rear_right_after_service
 *
 * The followings are the available model relations:
 * @property VehicleSystemCheckComponentDetail[] $vehicleSystemCheckComponentDetails
 * @property Branch $branch
 * @property Product $productIdRearLeftBeforeService
 * @property Product $productIdRearLeftAfterService
 * @property Product $productIdRearRightBeforeService
 * @property Product $productIdRearRightAfterService
 * @property RegistrationTransaction $registrationTransaction
 * @property Users $userIdCreated
 * @property Users $userIdEdited
 * @property Users $userIdCancelled
 * @property Product $productIdFrontLeftBeforeService
 * @property Product $productIdFrontLeftAfterService
 * @property Product $productIdFrontRightBeforeService
 * @property Product $productIdFrontRightAfterService
 * @property VehicleSystemCheckTireDetail[] $vehicleSystemCheckTireDetails
 */
class VehicleSystemCheckHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'VSC';
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{vehicle_system_check_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, registration_transaction_id, user_id_created, created_datetime, branch_id', 'required'),
            array('next_service_kilometer, registration_transaction_id, user_id_created, user_id_edited, branch_id, user_id_cancelled, product_id_front_left_before_service, product_id_front_left_after_service, product_id_front_right_before_service, product_id_front_right_after_service, product_id_rear_left_before_service, product_id_rear_left_after_service, product_id_rear_right_before_service, product_id_rear_right_after_service', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('accu_type_before_service, accu_type_after_service, electrical_condition_after_service, undercarriage_condition_after_service, underhood_condition_after_service, underhood_note', 'length', 'max' => 100),
            array('body_repair_note, vehicle_condition_recommendation, next_service_recommendation, edited_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, accu_type_before_service, accu_type_after_service, electrical_condition_after_service, undercarriage_condition_after_service, underhood_condition_after_service, underhood_note, body_repair_note, vehicle_condition_recommendation, next_service_recommendation, next_service_kilometer, registration_transaction_id, user_id_created, created_datetime, user_id_edited, edited_datetime, branch_id, user_id_cancelled, cancelled_datetime, product_id_front_left_before_service, product_id_front_left_after_service, product_id_front_right_before_service, product_id_front_right_after_service, product_id_rear_left_before_service, product_id_rear_left_after_service, product_id_rear_right_before_service, product_id_rear_right_after_service', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'vehicleSystemCheckComponentDetails' => array(self::HAS_MANY, 'VehicleSystemCheckComponentDetail', 'vehicle_system_check_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'productIdRearLeftBeforeService' => array(self::BELONGS_TO, 'Product', 'product_id_rear_left_before_service'),
            'productIdRearLeftAfterService' => array(self::BELONGS_TO, 'Product', 'product_id_rear_left_after_service'),
            'productIdRearRightBeforeService' => array(self::BELONGS_TO, 'Product', 'product_id_rear_right_before_service'),
            'productIdRearRightAfterService' => array(self::BELONGS_TO, 'Product', 'product_id_rear_right_after_service'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdEdited' => array(self::BELONGS_TO, 'Users', 'user_id_edited'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'productIdFrontLeftBeforeService' => array(self::BELONGS_TO, 'Product', 'product_id_front_left_before_service'),
            'productIdFrontLeftAfterService' => array(self::BELONGS_TO, 'Product', 'product_id_front_left_after_service'),
            'productIdFrontRightBeforeService' => array(self::BELONGS_TO, 'Product', 'product_id_front_right_before_service'),
            'productIdFrontRightAfterService' => array(self::BELONGS_TO, 'Product', 'product_id_front_right_after_service'),
            'vehicleSystemCheckTireDetails' => array(self::HAS_MANY, 'VehicleSystemCheckTireDetail', 'vehicle_system_check_header_id'),
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
            'accu_type_before_service' => 'Accu Type Before Service',
            'accu_type_after_service' => 'Accu Type After Service',
            'electrical_condition_after_service' => 'Electrical Condition After Service',
            'undercarriage_condition_after_service' => 'Undercarriage Condition After Service',
            'underhood_condition_after_service' => 'Underhood Condition After Service',
            'underhood_note' => 'Underhood Note',
            'body_repair_note' => 'Body Repair Note',
            'vehicle_condition_recommendation' => 'Vehicle Condition Recommendation',
            'next_service_recommendation' => 'Next Service Recommendation',
            'next_service_kilometer' => 'Next Service Kilometer',
            'registration_transaction_id' => 'Registration Transaction',
            'user_id_created' => 'User Id Created',
            'created_datetime' => 'Created Datetime',
            'user_id_edited' => 'User Id Edited',
            'edited_datetime' => 'Edited Datetime',
            'branch_id' => 'Branch',
            'user_id_cancelled' => 'User Id Cancelled',
            'cancelled_datetime' => 'Cancelled Datetime',
            'product_id_front_left_before_service' => 'Product Id Front Left Before Service',
            'product_id_front_left_after_service' => 'Product Id Front Left After Service',
            'product_id_front_right_before_service' => 'Product Id Front Right Before Service',
            'product_id_front_right_after_service' => 'Product Id Front Right After Service',
            'product_id_rear_left_before_service' => 'Product Id Rear Left Before Service',
            'product_id_rear_left_after_service' => 'Product Id Rear Left After Service',
            'product_id_rear_right_before_service' => 'Product Id Rear Right Before Service',
            'product_id_rear_right_after_service' => 'Product Id Rear Right After Service',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('accu_type_before_service', $this->accu_type_before_service, true);
        $criteria->compare('accu_type_after_service', $this->accu_type_after_service, true);
        $criteria->compare('electrical_condition_after_service', $this->electrical_condition_after_service, true);
        $criteria->compare('undercarriage_condition_after_service', $this->undercarriage_condition_after_service, true);
        $criteria->compare('underhood_condition_after_service', $this->underhood_condition_after_service, true);
        $criteria->compare('underhood_note', $this->underhood_note, true);
        $criteria->compare('body_repair_note', $this->body_repair_note, true);
        $criteria->compare('vehicle_condition_recommendation', $this->vehicle_condition_recommendation, true);
        $criteria->compare('next_service_recommendation', $this->next_service_recommendation, true);
        $criteria->compare('next_service_kilometer', $this->next_service_kilometer);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('user_id_edited', $this->user_id_edited);
        $criteria->compare('edited_datetime', $this->edited_datetime, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);
        $criteria->compare('product_id_front_left_before_service', $this->product_id_front_left_before_service);
        $criteria->compare('product_id_front_left_after_service', $this->product_id_front_left_after_service);
        $criteria->compare('product_id_front_right_before_service', $this->product_id_front_right_before_service);
        $criteria->compare('product_id_front_right_after_service', $this->product_id_front_right_after_service);
        $criteria->compare('product_id_rear_left_before_service', $this->product_id_rear_left_before_service);
        $criteria->compare('product_id_rear_left_after_service', $this->product_id_rear_left_after_service);
        $criteria->compare('product_id_rear_right_before_service', $this->product_id_rear_right_before_service);
        $criteria->compare('product_id_rear_right_after_service', $this->product_id_rear_right_after_service);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}