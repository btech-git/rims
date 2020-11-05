<?php

/**
 * This is the model class for table "{{material_request_header}}".
 *
 * The followings are the available columns in table '{{material_request_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_time
 * @property integer $total_quantity
 * @property integer $total_quantity_movement_out
 * @property integer $total_quantity_remaining
 * @property string $status
 * @property string $note
 * @property integer $branch_id
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property MaterialRequestDetail[] $materialRequestDetails
 * @property Branch $branch
 * @property Users $user
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
            array('transaction_number, transaction_date, transaction_time, branch_id, user_id', 'required'),
            array('branch_id, user_id, total_quantity, total_quantity_movement_out, total_quantity_remaining', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 50),
            array('status', 'length', 'max' => 20),
            array('note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_time, status, note, branch_id, user_id, total_quantity, total_quantity_movement_out, total_quantity_remaining', 'safe', 'on' => 'search'),
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
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'movementOutHeaders' => array(self::HAS_MANY, 'MovementOutHeader', 'material_request_header_id'),
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
            'status' => 'Status',
            'note' => 'Note',
            'branch_id' => 'Branch',
            'user_id' => 'User',
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
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_quantity_movement_out', $this->total_quantity_movement_out);
        $criteria->compare('total_quantity_remaining', $this->total_quantity_remaining);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchByMovementOut() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_time', $this->transaction_time, true);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_quantity_movement_out', $this->total_quantity_movement_out);
        $criteria->compare('total_quantity_remaining', $this->total_quantity_remaining);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('user_id', $this->user_id);

        $criteria->addCondition("t.total_quantity_remaining > 0");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
}
