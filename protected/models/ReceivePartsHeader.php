<?php

/**
 * This is the model class for table "{{receive_parts_header}}".
 *
 * The followings are the available columns in table '{{receive_parts_header}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $transaction_type
 * @property string $note
 * @property string $supplier_delivery_number
 * @property integer $registration_transaction_id
 * @property integer $insurance_company_id
 * @property integer $user_id_created
 * @property string $created_datetime
 * @property integer $user_id_updated
 * @property string $updated_datetime
 * @property integer $user_id_cancelled
 * @property string $cancelled_datetime
 * @property integer $branch_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property ReceivePartsDetail[] $receivePartsDetails
 * @property MovementInHeader[] $movementInHeaders
 * @property RegistrationTransaction $registrationTransaction
 * @property InsuranceCompany $insuranceCompany
 * @property Users $userIdCreated
 * @property Users $userIdUpdated
 * @property Users $userIdCancelled
 * @property Branch $branch
 */
class ReceivePartsHeader extends MonthlyTransactionActiveRecord {
    
    const CONSTANT = 'RPS';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{receive_parts_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, transaction_date, transaction_type, registration_transaction_id, user_id_created, created_datetime, branch_id, status', 'required'),
            array('registration_transaction_id, insurance_company_id, user_id_created, user_id_updated, user_id_cancelled, branch_id', 'numerical', 'integerOnly' => true),
            array('transaction_type, supplier_delivery_number, status', 'length', 'max' => 20),
            array('transaction_number', 'length', 'max' => 60),
            array('note, updated_datetime, cancelled_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, transaction_type, note, supplier_delivery_number, registration_transaction_id, insurance_company_id, user_id_created, created_datetime, user_id_updated, updated_datetime, user_id_cancelled, cancelled_datetime, branch_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'receivePartsDetails' => array(self::HAS_MANY, 'ReceivePartsDetail', 'receive_parts_header_id'),
            'movementInHeaders' => array(self::HAS_MANY, 'MovementInHeader', 'receive_parts_header_id'),
            'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
            'insuranceCompany' => array(self::BELONGS_TO, 'InsuranceCompany', 'insurance_company_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdCancelled' => array(self::BELONGS_TO, 'Users', 'user_id_cancelled'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
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
            'transaction_type' => 'Transaction Type',
            'note' => 'Note',
            'supplier_delivery_number' => 'Supplier Delivery Number',
            'registration_transaction_id' => 'Registration Transaction',
            'insurance_company_id' => 'Insurance Company',
            'user_id_created' => 'User Id Created',
            'created_datetime' => 'Created Datetime',
            'user_id_updated' => 'User Id Updated',
            'updated_datetime' => 'Updated Datetime',
            'user_id_cancelled' => 'User Id Cancelled',
            'cancelled_datetime' => 'Cancelled Datetime',
            'branch_id' => 'Branch',
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
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('supplier_delivery_number', $this->supplier_delivery_number, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);
        $criteria->compare('branch_id', $this->branch_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ReceivePartsHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchByMovementIn() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.quantity_movement_left), 0) AS quantity_remaining
            FROM " . ReceivePartsDetail::model()->tableName() . " d
            WHERE t.id = d.receive_parts_header_id
            GROUP BY d.receive_parts_header_id
            HAVING quantity_remaining > 0
        ) AND t.transaction_date > '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND t.user_id_cancelled is null";

        $criteria->compare('id', $this->id);
        $criteria->compare('transaction_number', $this->transaction_number, true);
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('transaction_type', $this->transaction_type, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('supplier_delivery_number', $this->supplier_delivery_number, true);
        $criteria->compare('registration_transaction_id', $this->registration_transaction_id);
        $criteria->compare('insurance_company_id', $this->insurance_company_id);
        $criteria->compare('user_id_created', $this->user_id_created);
        $criteria->compare('created_datetime', $this->created_datetime, true);
        $criteria->compare('user_id_updated', $this->user_id_updated);
        $criteria->compare('updated_datetime', $this->updated_datetime, true);
        $criteria->compare('user_id_cancelled', $this->user_id_cancelled);
        $criteria->compare('cancelled_datetime', $this->cancelled_datetime, true);
        $criteria->compare('branch_id', $this->branch_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
}