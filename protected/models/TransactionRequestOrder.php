<?php

/**
 * This is the model class for table "{{transaction_request_order}}".
 *
 * The followings are the available columns in table '{{transaction_request_order}}':
 * @property integer $id
 * @property string $request_order_no
 * @property string $request_order_date
 * @property integer $requester_id
 * @property integer $requester_branch_id
 * @property integer $main_branch_id
 * @property integer $main_branch_approved_by
 * @property integer $approved_by
 * @property integer $total_items
 * @property string $total_price
 * @property string $status_document
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property TransactionPurchaseOrderDetail[] $transactionPurchaseOrderDetails
 * @property Branch $requesterBranch
 * @property TransactionRequestOrderDetail[] $transactionRequestOrderDetails
 * @property TransactionRequestTransfer[] $transactionRequestTransfers
 */
class TransactionRequestOrder extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'RO';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionRequestOrder the static model class
     */
    public $supplier_name;
    public $request_name;
    public $request_branch_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_request_order}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('request_order_no, request_order_date, requester_id, requester_branch_id, main_branch_id', 'required'),
            array('requester_id, requester_branch_id, main_branch_id, main_branch_approved_by, approved_by, total_items', 'numerical', 'integerOnly' => true),
            array('request_order_no', 'length', 'max' => 30),
            array('total_price', 'length', 'max' => 18),
            array('status_document', 'length', 'max' => 20),
            array('request_order_no', 'unique'),
            array('notes', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, request_order_no, request_order_date, requester_id, requester_branch_id, main_branch_id, main_branch_approved_by, approved_by, total_items, total_price, request_branch_name, status_document, notes, has_compare', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transactionPurchaseOrderDetailRequests' => array(self::HAS_MANY, 'TransactionPurchaseOrderDetailRequest', 'purchase_request_id'),
            'requesterBranch' => array(self::BELONGS_TO, 'Branch', 'requester_branch_id'),
            'user' => array(self::BELONGS_TO, 'User', 'requester_id'),
            'mainBranch' => array(self::BELONGS_TO, 'Branch', 'main_branch_id'),
            'approval' => array(self::BELONGS_TO, 'User', 'approved_by'),
            'mainBranchApproval' => array(self::BELONGS_TO, 'User', 'main_branch_approved_by'),
            'transactionRequestOrderDetails' => array(self::HAS_MANY, 'TransactionRequestOrderDetail', 'request_order_id'),
            'transactionRequestTransfers' => array(self::HAS_MANY, 'TransactionRequestTransfer', 'request_order_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'request_order_no' => 'Request Order No',
            'request_order_date' => 'Order Date',
            'requester_id' => 'Requester',
            'requester_branch_id' => 'Requester Branch',
            'main_branch_id' => 'Main Branch',
            'main_branch_approved_by' => 'Main Branch Approved By',
            'approved_by' => 'Approved By',
            'total_items' => 'Total Items',
            'total_price' => 'Total Price',
            'status_document' => 'Status Document',
            'notes' => 'Notes',
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
        $criteria->compare('request_order_no', $this->request_order_no, true);
        $criteria->compare('request_order_date', $this->request_order_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('main_branch_id', $this->main_branch_id);
        $criteria->compare('main_branch_approved_by', $this->main_branch_approved_by);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('total_items', $this->total_items);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('has_compare', $this->has_compare, true);

        $criteria->together = 'true';
        $criteria->with = array('requesterBranch');
        $criteria->compare('requesterBranch.name', $this->request_branch_name, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'request_order_date DESC',
                'attributes' => array(
                    'request_branch_name' => array(
                        'asc' => 'requesterBranch.name ASC',
                        'desc' => 'requesterBranch.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchByAdmin() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('request_order_no', $this->request_order_no, true);
        $criteria->compare('request_order_date', $this->request_order_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('main_branch_id', $this->main_branch_id);
        $criteria->compare('main_branch_approved_by', $this->main_branch_approved_by);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('total_items', $this->total_items);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('has_compare', $this->has_compare, true);

        $criteria->addCondition("t.main_branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);

        $criteria->together = 'true';
        $criteria->with = array('requesterBranch');
        $criteria->compare('requesterBranch.name', $this->request_branch_name, true);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'request_order_date DESC',
                'attributes' => array(
                    'request_branch_name' => array(
                        'asc' => 'requesterBranch.name ASC',
                        'desc' => 'requesterBranch.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }
}
