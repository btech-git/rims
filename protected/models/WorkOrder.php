<?php

/**
 * This is the model class for table "{{work_order}}".
 *
 * The followings are the available columns in table '{{work_order}}':
 * @property integer $id
 * @property string $work_order_number
 * @property string $work_order_date
 * @property integer $registration_transaction_id
 * @property integer $user_id
 * @property integer $branch_id
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Branch $branch
 * @property RegistrationTransaction $registrationTransaction
 * @property WorkOrderDetail[] $workOrderDetails
 */
class WorkOrder extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return WorkOrder the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $registration_transaction_date;
    public $customer_name;
    public $pic_name;
    public $plate;
    public $frame;
    public $machine;
    public $carMake;
    public $carModel;
    public $carSubModel;
    public $color;
    public $chasis;
    public $year;
    public $power;

    public function tableName() {
        return '{{work_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('work_order_number, work_order_date, registration_transaction_id', 'required'),
            array('registration_transaction_id, user_id, branch_id', 'numerical', 'integerOnly' => true),
            array('work_order_number', 'length', 'max' => 30),
            array('work_order_number', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, work_order_number, work_order_date, registration_transaction_id, user_id, branch_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'workOrderDetails' => array(self::HAS_MANY, 'WorkOrderDetail', 'work_order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'work_order_number' => 'Work Order Number',
            'work_order_date' => 'Work Order Date',
            'registration_transaction_id' => 'Registration Transaction',
            'user_id' => 'User',
            'branch_id' => 'Branch',
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
        $criteria->compare('work_order_number', $this->work_order_number, true);
        $criteria->compare('work_order_date', $this->work_order_date, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('branch_id', $this->branch_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
