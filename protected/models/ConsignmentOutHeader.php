<?php

/**
 * This is the model class for table "{{consignment_out_header}}".
 *
 * The followings are the available columns in table '{{consignment_out_header}}':
 * @property integer $id
 * @property string $consignment_out_no
 * @property string $date_posting
 * @property string $status
 * @property integer $customer_id
 * @property string $delivery_date
 * @property integer $sender_id
 * @property integer $branch_id
 * @property integer $periodic
 * @property integer $total_quantity
 * @property string $total_price
 * @property integer $approved_by
 * @property string $status_document
 *
 * The followings are the available model relations:
 * @property ConsignmentOutApproval[] $consignmentOutApprovals
 * @property ConsignmentOutDetail[] $consignmentOutDetails
 * @property Customer $customer
 * @property Users $sender
 * @property Branch $branch
 */
class ConsignmentOutHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'CSO';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ConsignmentOutHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public $customer_name;
    public $branch_name;

    public function tableName() {
        return '{{consignment_out_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('consignment_out_no, date_posting, status, customer_id, sender_id, periodic, total_quantity, total_price', 'required'),
            array('customer_id, sender_id, branch_id, periodic, total_quantity, approved_by', 'numerical', 'integerOnly' => true),
            array('consignment_out_no, status_document', 'length', 'max' => 30),
            array('status', 'length', 'max' => 10),
            array('total_price', 'length', 'max' => 18),
            array('delivery_date', 'safe'),
            array('consignment_out_no', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, consignment_out_no, date_posting, status, customer_id, delivery_date, sender_id, branch_id, periodic, total_quantity, total_price, approved_by, status_document, customer_name,branch_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'consignmentOutApprovals' => array(self::HAS_MANY, 'ConsignmentOutApproval', 'consignment_out_id'),
            'consignmentOutDetails' => array(self::HAS_MANY, 'ConsignmentOutDetail', 'consignment_out_id'),
            'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
            'user' => array(self::BELONGS_TO, 'User', 'sender_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'transactionDeliveryOrders' => array(self::HAS_MANY, 'TransactionDeliveryOrder', 'consignment_out_id'),
            'transactionReturnItems' => array(self::HAS_MANY, 'TransactionReturnItem', 'consignment_out_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'consignment_out_no' => 'Consignment Out No',
            'date_posting' => 'Date Posting',
            'status' => 'Status',
            'customer_id' => 'Customer',
            'delivery_date' => 'Delivery Date',
            'sender_id' => 'Sender',
            'branch_id' => 'Branch',
            'periodic' => 'Periodic',
            'total_quantity' => 'Total Quantity',
            'total_price' => 'Total Price',
            'approved_by' => 'Approved By',
            'status_document' => 'Status Document',
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
        $criteria->compare('consignment_out_no', $this->consignment_out_no, true);
        $criteria->compare('date_posting', $this->date_posting, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('delivery_date', $this->delivery_date, true);
        $criteria->compare('sender_id', $this->sender_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('periodic', $this->periodic);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('status_document', $this->status_document, true);

        $criteria->together = 'true';
        $criteria->with = array('customer', 'branch');
        $criteria->addSearchCondition('customer.name', $this->customer_name, true);
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
                    'customer_name' => array(
                        'asc' => 'customer.name ASC',
                        'desc' => 'customer.name DESC',
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
			SELECT COALESCE(SUM(d.quantity - d.qty_sent), 0) AS quantity_remaining
			FROM " . ConsignmentOutDetail::model()->tableName() . " d
			WHERE t.id = d.consignment_out_id AND status_document = 'Approved'
			GROUP BY d.consignment_out_id
			HAVING quantity_remaining > 0
		)";

        $criteria->compare('id', $this->id);
        $criteria->compare('consignment_out_no', $this->consignment_out_no, true);
        $criteria->compare('date_posting', $this->date_posting, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('delivery_date', $this->delivery_date, true);
        $criteria->compare('sender_id', $this->sender_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('periodic', $this->periodic);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('status_document', $this->status_document, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date_posting DESC',
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
			SELECT COALESCE(SUM(d.qty_request_left), 0) AS quantity_remaining
			FROM " . ConsignmentOutDetail::model()->tableName() . " d
			WHERE t.id = d.consignment_out_id
			GROUP BY d.consignment_out_id
			HAVING quantity_remaining > 0
		)";

        $criteria->compare('id', $this->id);
        $criteria->compare('consignment_out_no', $this->consignment_out_no, true);
        $criteria->compare('date_posting', $this->date_posting, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('delivery_date', $this->delivery_date, true);
        $criteria->compare('sender_id', $this->sender_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('periodic', $this->periodic);
        $criteria->compare('total_quantity', $this->total_quantity);
        $criteria->compare('total_price', $this->total_price, true);
        $criteria->compare('approved_by', $this->approved_by);
        $criteria->compare('status_document', $this->status_document, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date_posting DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getTotalRemainingQuantityDelivered() {
        $totalRemaining = 0;

        foreach ($this->consignmentOutDetails as $detail)
            $totalRemaining += $detail->qty_request_left;

        return ($totalRemaining = 0) ? 'Completed' : 'Partial';
    }

}
