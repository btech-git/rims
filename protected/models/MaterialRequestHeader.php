<?php

/**
 * This is the model class for table "{{material_request_header}}".
 *
 * The followings are the available columns in table '{{material_request_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property string $total_quantity
 * @property string $total_quantity_movement_out
 * @property string $total_quantity_remaining
 * @property string $status_document
 * @property string $status_progress
 * @property string $note
 * @property integer $branch_id
 * @property integer $user_id
 * @property integer $registration_transaction_id
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property MaterialRequestDetail[] $materialRequestDetails
 * @property MaterialRequestApproval[] $materialRequestApprovals
 * @property Branch $branch
 * @property Users $user
 * @property RegistrationTransaction $registrationTransaction
 * @property MovementOutHeader[] $movementOutHeaders
 */
class MaterialRequestHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'MR';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MaterialRequestHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{material_request_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_time, branch_id, user_id, registration_transaction_id', 'required'),
            array('branch_id, user_id, registration_transaction_id', 'numerical', 'integerOnly' => true),
            array('total_quantity, total_quantity_movement_out, total_quantity_remaining', 'length', 'max' => 10),
            array('transaction_number, status_document, status_progress', 'length', 'max' => 50),
            array('note', 'safe'),
            array('transaction_number', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, created_datetime, status_document, status_progress, note, branch_id, user_id, total_quantity, total_quantity_movement_out, total_quantity_remaining, registration_transaction_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'materialRequestDetails' => array(self::HAS_MANY, 'MaterialRequestDetail', 'material_request_header_id'),
            'materialRequestApprovals' => array(self::HAS_MANY, 'MaterialRequestApproval', 'material_request_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'material_request_header_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
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
            'total_quantity' => 'Total Quantity',
            'total_quantity_movement_out' => 'Total Quantity Movement Out',
            'total_quantity_remaining' => 'Total Quantity Remaining',
            'status_document' => 'Status Document',
            'status_progress' => 'Status Progress',
            'note' => 'Note',
            'branch_id' => 'Branch',
            'user_id' => 'User',
            'registration_transaction_id' => 'Registration Transaction',
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date, true);
        $criteria->compare('t.transaction_time', $this->transaction_time, true);
        $criteria->compare('t.total_quantity', $this->total_quantity);
        $criteria->compare('t.total_quantity_movement_out', $this->total_quantity_movement_out);
        $criteria->compare('t.total_quantity_remaining', $this->total_quantity_remaining);
        $criteria->compare('t.status_document', $this->status_document, true);
        $criteria->compare('t.status_progress', $this->status_progress, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.transaction_date DESC',
            ),
        ));
    }

    public function searchByMovementOut() {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.transaction_number', $this->transaction_number, true);
        $criteria->compare('t.transaction_date', $this->transaction_date, true);
        $criteria->compare('t.transaction_time', $this->transaction_time, true);
        $criteria->compare('t.total_quantity', $this->total_quantity);
        $criteria->compare('t.total_quantity_movement_out', $this->total_quantity_movement_out);
        $criteria->compare('t.total_quantity_remaining', $this->total_quantity_remaining);
        $criteria->compare('t.status_document', $this->status_document, true);
        $criteria->compare('t.status_progress', $this->status_progress, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.registration_transaction_id', $this->registration_transaction_id);

        $criteria->addCondition("t.total_quantity_remaining > 0.00 AND t.status_document = 'Approved'");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
        ));
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->materialRequestDetails as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }

    public function getTotalQuantityMovementOut() {
        $total = 0.00;

        foreach ($this->materialRequestDetails as $detail) {
            $total += $detail->quantity_movement_out;
        }
        
        return $total;
    }
    
    public function getDateTime() {
        return $this->transaction_date . ' ' . $this->transaction_time;
    }
}
