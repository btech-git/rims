<?php

/**
 * This is the model class for table "{{movement_out_header}}".
 *
 * The followings are the available columns in table '{{movement_out_header}}':
 * @property integer $id
 * @property string $movement_out_no
 * @property string $date_posting
 * @property integer $delivery_order_id
 * @property integer $return_order_id
 * @property integer $registration_transaction_id
 * @property integer $registration_service_id
 * @property integer $branch_id
 * @property integer $movement_type
 * @property integer $user_id
 * @property integer $supervisor_id
 * @property integer $material_request_header_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property MovementOutApproval[] $movementOutApprovals
 * @property MovementOutDetail[] $movementOutDetails
 * @property TransactionDeliveryOrder $deliveryOrder
 * @property Branch $branch
 * @property Users $user
 * @property TransactionReturnOrder $returnOrder
 * @property RegistrationTransaction $registrationTransaction
 * @property RegistrationService $registrationService
 * @property MaterialRequestHeader $materialRequestHeader
 */
class MovementOutHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'MO';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MovementOutHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $branch_name;
    public $delivery_order_number;
    public $return_order_number;
    public $registration_transaction_number;
    public $material_request_number;

    public function tableName() {
        return '{{movement_out_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('movement_out_no, date_posting, branch_id, movement_type, user_id, status', 'required'),
            array('delivery_order_id, return_order_id, registration_transaction_id, registration_service_id, branch_id, movement_type, user_id, supervisor_id, material_request_header_id', 'numerical', 'integerOnly' => true),
            array('movement_out_no', 'length', 'max' => 30),
            array('status', 'length', 'max' => 20),
            array('movement_out_no', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, movement_out_no, date_posting, delivery_order_id, branch_id, movement_type, user_id, supervisor_id, status, return_order_id,delivery_order_number, return_order_number, registration_transaction_id, branch_name, registration_service_id, material_request_header_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementOutApprovals' => array(self::HAS_MANY, 'MovementOutApproval', 'movement_out_id'),
            'movementOutDetails' => array(self::HAS_MANY, 'MovementOutDetail', 'movement_out_header_id'),
            'deliveryOrder' => array(self::BELONGS_TO, 'TransactionDeliveryOrder', 'delivery_order_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'returnOrder' => array(self::BELONGS_TO, 'TransactionReturnOrder', 'return_order_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'registrationService' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_service_id'),
            'movementOutShippings' => array(self::HAS_MANY, 'MovementOutShipping', 'movement_out_id'),
            'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'movement_out_id'),
            'materialRequestHeader' => array(self::BELONGS_TO, 'MaterialRequestHeader', 'material_request_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'movement_out_no' => 'Movement Out No',
            'date_posting' => 'Date Posting',
            'delivery_order_id' => 'Delivery Order',
            'return_order_id' => 'Return Order',
            'registration_transaction_id' => 'Registration Transaction',
            'registration_service_id' => 'Registration Service',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'supervisor_id' => 'Supervisor',
            'status' => 'Status',
            'material_request_header_id' => 'Material Request #'
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
        $criteria->compare('movement_out_no', $this->movement_out_no, true);
        $criteria->compare('date_posting', $this->date_posting, true);
        $criteria->compare('delivery_order_id', $this->delivery_order_id);
        $criteria->compare('return_order_id', $this->return_order_id);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('registration_service_id', $this->registration_service_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('material_request_header_id', $this->material_request_header_id);

        $criteria->together = 'true';
        $criteria->with = array('deliveryOrder', 'branch', 'returnOrder');
        $criteria->addSearchCondition('deliveryOrder.delivery_order_no', $this->delivery_order_number, true);
        $criteria->addSearchCondition('returnOrder.return_order_no', $this->return_order_number, true);
        $criteria->addSearchCondition('branch.name', $this->branch_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date_posting DESC',
                'attributes' => array(
                    'branch_name' => array(
                        'asc' => 'branch.name ASC',
                        'desc' => 'branch.name DESC',
                    ),
                    'delivery_order_number' => array(
                        'asc' => 'deliveryOrder.delivery_order_no ASC',
                        'desc' => 'deliveryOrder.delivery_order_no DESC',
                    ),
                    'return_order_number' => array(
                        'asc' => 'returnOrder.return_order_no ASC',
                        'desc' => 'returnOrder.return_order_no DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getMovementType($type) {
        switch($type) {
            case 1: return 'Delivery Order';
            case 2: return 'Return Order';
            case 3: return 'Retail Sales';
            case 4: return 'Material Request';
            default: return '';
        }
    }
}