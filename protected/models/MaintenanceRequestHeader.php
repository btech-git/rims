<?php

/**
 * This is the model class for table "{{maintenance_request_header}}".
 *
 * The followings are the available columns in table '{{maintenance_request_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $description
 * @property string $note
 * @property string $maintenance_type
 * @property integer $priority_level
 * @property integer $branch_id
 * @property integer $user_id
 * @property integer $user_id_supervisor
 * @property integer $user_id_requestor
 * @property string $status
 * @property integer $is_inactive
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property MaintenanceRequestApproval[] $maintenanceRequestApprovals
 * @property MaintenanceRequestDetail[] $maintenanceRequestDetails
 * @property Branch $branch
 * @property Users $user
 * @property Users $userIdSupervisor
 * @property Users $userIdRequestor
 * @property MaintenanceRequestImage[] $maintenanceRequestImages
 */
class MaintenanceRequestHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'MNTR';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{maintenance_request_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, branch_id, user_id, user_id_requestor, status', 'required'),
            array('priority_level, branch_id, user_id, user_id_supervisor, user_id_requestor, is_inactive', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 60),
            array('maintenance_type', 'length', 'max' => 20),
            array('status', 'length', 'max' => 100),
            array('description, note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, created_datetime, description, note, maintenance_type, priority_level, branch_id, user_id, user_id_supervisor, user_id_requestor, status, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'maintenanceRequestApprovals' => array(self::HAS_MANY, 'MaintenanceRequestApproval', 'maintenance_request_header_id'),
            'maintenanceRequestDetails' => array(self::HAS_MANY, 'MaintenanceRequestDetail', 'maintenance_request_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'userIdSupervisor' => array(self::BELONGS_TO, 'Users', 'user_id_supervisor'),
            'userIdRequestor' => array(self::BELONGS_TO, 'Users', 'user_id_requestor'),
            'maintenanceRequestImages' => array(self::HAS_MANY, 'MaintenanceRequestImage', 'maintenance_request_header_id'),
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
            'description' => 'Description',
            'note' => 'Note',
            'maintenance_type' => 'Maintenance Type',
            'priority_level' => 'Priority Level',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'user_id_supervisor' => 'User Id Supervisor',
            'user_id_requestor' => 'User Id Requestor',
            'status' => 'Status',
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('maintenance_type', $this->maintenance_type, true);
        $criteria->compare('priority_level', $this->priority_level);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('user_id_supervisor', $this->user_id_supervisor);
        $criteria->compare('user_id_requestor', $this->user_id_requestor);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MaintenanceRequestHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
