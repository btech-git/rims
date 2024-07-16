<?php

/**
 * This is the model class for table "{{transaction_sent_request}}".
 *
 * The followings are the available columns in table '{{transaction_sent_request}}':
 * @property integer $id
 * @property string $sent_request_no
 * @property string $sent_request_date
 * @property string $sent_request_time
 * @property string $status_document
 * @property string $estimate_arrival_date
 * @property integer $requester_id
 * @property integer $requester_branch_id
 * @property integer $approved_by
 * @property integer $destination_id
 * @property integer $destination_branch_id
 * @property string $total_quantity
 * @property string $total_price
 * @property integer $destination_approval_status
 * @property string $created_datetime
 * @property integer $destination_approved_by
 *
 * The followings are the available model relations:
 * @property TransactionDeliveryOrder[] $transactionDeliveryOrders
 * @property TransactionReturnItem[] $transactionReturnItems
 * @property Branch $requesterBranch
 * @property Branch $destinationBranch
 * @property TransactionSentRequestDetail[] $transactionSentRequestDetails
 */
class TransactionSentRequest extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'SR';
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_PENDING_LITERAL = 'PENDING';
    const STATUS_APPROVED_LITERAL = 'APPROVED';
    const STATUS_REJECTED_LITERAL = 'REJECTED';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TransactionSentRequest the static model class
     */
    public $branch_name;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_sent_request}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sent_request_no, sent_request_date, status_document, estimate_arrival_date, requester_id, requester_branch_id, destination_branch_id, total_price', 'required'),
            array('requester_id, requester_branch_id, approved_by, destination_id, destination_branch_id, destination_approval_status', 'numerical', 'integerOnly' => true),
            array('sent_request_no, status_document', 'length', 'max' => 30),
            array('total_quantity', 'length', 'max' => 10),
            array('total_price', 'length', 'max' => 18),
            array('sent_request_no', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, sent_request_no, sent_request_date, status_document, estimate_arrival_date, requester_id, requester_branch_id, approved_by, destination_id, destination_branch_id, total_quantity,branch_name, total_price, destination_approval_status, created_datetime, destination_approved_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'transactionDeliveryOrders' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'sent_request_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'sent_request_id'),
            'requesterBranch' => array(self::BELONGS_TO, 'Branch', 'requester_branch_id'),
            'destinationBranch' => array(self::BELONGS_TO, 'Branch', 'destination_branch_id'),
            'transactionSentRequestDetails' => array(self::HAS_MANY, 'TransactionSentRequestDetail', 'sent_request_id'),
            'user' => array(self::BELONGS_TO, 'User', 'requester_id'),
            'approval' => array(self::BELONGS_TO, 'User', 'approved_by'),
            'destinationApprovedBy' => array(self::BELONGS_TO, 'Users', 'destination_approved_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'sent_request_no' => 'Sent Request No',
            'sent_request_date' => 'Date',
            'sent_request_time' => 'Date',
            'status_document' => 'Status Document',
            'estimate_arrival_date' => 'Estimate Arrival Date',
            'requester_id' => 'Requester',
            'requester_branch_id' => 'Requester Branch',
            'approved_by' => 'Approved By',
            'destination_id' => 'Destination',
            'destination_branch_id' => 'Destination Branch',
            'total_quantity' => 'Total Quantity',
            'total_price' => 'Total Price',
            'destination_approval_status' => 'Destination Approval Status',
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
        $criteria->compare('sent_request_no', $this->sent_request_no, true);
        $criteria->compare('sent_request_date', $this->sent_request_date, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('destination_id', $this->destination_id);
        $criteria->compare('destination_branch_id', $this->destination_branch_id);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('destination_approval_status', $this->destination_approval_status);

        $criteria->together = 'true';
        $criteria->with = array('requesterBranch');
        $criteria->compare('requesterBranch.name', $this->branch_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sent_request_date DESC',
                'attributes' => array(
                    'branch_name' => array(
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

    public function searchByPendingDelivery() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
            SELECT COALESCE(SUM(d.quantity - d.delivery_quantity), 0) AS quantity_remaining
            FROM " . TransactionSentRequestDetail::model()->tableName() . " d
            WHERE t.id = d.sent_request_id
            GROUP BY d.sent_request_id
            HAVING quantity_remaining > 0
        ) AND t.status_document NOT IN ('Draft', 'Rejected') AND t.destination_approval_status = 1 AND t.sent_request_date > '2022-12-31'";

        $criteria->compare('id', $this->id);
        $criteria->compare('sent_request_no', $this->sent_request_no, true);
        $criteria->compare('sent_request_date', $this->sent_request_date, true);
        $criteria->compare('status_document', $this->status_document, true);
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('destination_id', $this->destination_id);
        $criteria->compare('destination_branch_id', $this->destination_branch_id);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sent_request_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByDelivery() {
        //search purchase header which purchased quantity is not fully received yet
        $criteria = new CDbCriteria;

        $criteria->condition = "EXISTS (
			SELECT COALESCE(SUM(d.sent_request_quantity_left), 0) AS quantity_remaining
			FROM " . TransactionSentRequestDetail::model()->tableName() . " d
			WHERE t.id = d.sent_request_id
			GROUP BY d.sent_request_id
			HAVING quantity_remaining > 0
		)";

        $criteria->compare('id', $this->id);
        $criteria->compare('sent_request_no', $this->sent_request_no, true);
        $criteria->compare('sent_request_date', $this->sent_request_date, true);
        $criteria->compare('status_document', 'Approved');
        $criteria->compare('estimate_arrival_date', $this->estimate_arrival_date, true);
        $criteria->compare('requester_id', $this->requester_id);
        $criteria->compare('requester_branch_id', $this->requester_branch_id);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('destination_id', $this->destination_id);
        $criteria->compare('destination_branch_id', $this->destination_branch_id);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'sent_request_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getApprovalStatus() {
        $status = '';

        if ($this->destination_approval_status == self::STATUS_PENDING)
            $status = self::STATUS_PENDING_LITERAL;
        else if ($this->destination_approval_status == self::STATUS_APPROVED)
            $status = self::STATUS_APPROVED_LITERAL;
        else if ($this->destination_approval_status == self::STATUS_REJECTED)
            $status = self::STATUS_REJECTED_LITERAL;

        return $status;
    }

    public function getTotalRemainingQuantityDelivered() {
        $totalRemaining = 0;

        foreach ($this->transactionSentRequestDetails as $detail) {
            $totalRemaining += $detail->sent_request_quantity_left;
        }

        return ($totalRemaining == 0) ? 'Completed' : 'Partial';
    }

    public function getTransactionDateTime() {
        return $this->sent_request_date . ' ' . $this->sent_request_time;
    }
}
