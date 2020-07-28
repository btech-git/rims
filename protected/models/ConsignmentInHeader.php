<?php

/**
 * This is the model class for table "{{consignment_in_header}}".
 *
 * The followings are the available columns in table '{{consignment_in_header}}':
 * @property integer $id
 * @property string $consignment_in_number
 * @property string $date_posting
 * @property string $status_document
 * @property integer $supplier_id
 * @property string $date_arrival
 * @property integer $receive_id
 * @property integer $receive_branch
 * @property string $total_price
 * @property integer $total_quantity
 *
 * The followings are the available model relations:
 * @property ConsignmentInDetail[] $consignmentInDetails
 * @property Supplier $supplier
 * @property Branch $receiveBranch
 * @property ConsignmentInApproval[] $consignmentInApprovals
 * @property TransactionReceiveItem[] $transactionReceiveItems
 * @property TransactionReturnOrder[] $transactionReturnOrders
 */
class ConsignmentInHeader extends MonthlyTransactionActiveRecord
{
    const CONSTANT = 'CSI';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConsignmentInHeader the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public $supplier_name;
	public $branch_name;

	public function tableName()
	{
		return '{{consignment_in_header}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('consignment_in_number, date_posting, status_document, supplier_id, date_arrival, total_price', 'required'),
			array('supplier_id, receive_id, receive_branch, total_quantity', 'numerical', 'integerOnly'=>true),
			array('consignment_in_number, status_document', 'length', 'max'=>30),
			array('total_price', 'length', 'max'=>18),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, consignment_in_number, date_posting, status_document, supplier_id, date_arrival, receive_id, receive_branch, total_price, total_quantity,supplier_name, branch_name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'consignmentInApprovals' => array(self::HAS_MANY, 'ConsignmentInApproval', 'consignment_in_id'),
			'consignmentInDetails' => array(self::HAS_MANY, 'ConsignmentInDetail', 'consignment_in_id'),
			'supplier' => array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
			'receiveBranch' => array(self::BELONGS_TO, 'Branch', 'receive_branch'),
			'transactionReceiveItems' => array(self::HAS_MANY, 'TransactionReceiveItem', 'consignment_in_id'),
			'transactionReturnOrders' => array(self::HAS_MANY, 'TransactionReturnOrder', 'consignment_in_id'),
			'user' => array(self::BELONGS_TO, 'User', 'receive_id'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'consignment_in_number' => 'Consignment In Number',
			'date_posting' => 'Date Posting',
			'status_document' => 'Status Document',
			'supplier_id' => 'Supplier',
			'date_arrival' => 'Date Arrival',
			'receive_id' => 'Receive',
			'receive_branch' => 'Receive Branch',
			'total_price' => 'Total Price',
			'total_quantity' => 'Total Quantity',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('consignment_in_number',$this->consignment_in_number,true);
		$criteria->compare('date_posting',$this->date_posting,true);
		$criteria->compare('status_document',$this->status_document,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('date_arrival',$this->date_arrival,true);
		$criteria->compare('receive_id',$this->receive_id);
		$criteria->compare('receive_branch',$this->receive_branch);
		$criteria->compare('total_price',$this->total_price,true);
		$criteria->compare('total_quantity',$this->total_quantity);

		$criteria->together = 'true';
		$criteria->with = array('supplier','receiveBranch');
		$criteria->addSearchCondition('supplier.name', $this->supplier_name, true);
		$criteria->addSearchCondition('receiveBranch.name', $this->branch_name, true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 'date_posting DESC',
            'attributes' => array(
	                'branch_name' => array(
	                    'asc' => 'receiveBranch.name ASC',
	                    'desc' => 'receiveBranch.name DESC',
	                ),
	                'supplier_name' => array(
	                    'asc' => 'supplier.name ASC',
	                    'desc' => 'supplier.name DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),
		));
	}
    
	public function searchByReceive()
	{
		$criteria = new CDbCriteria;
		
		$criteria->condition = "EXISTS (
			SELECT COALESCE(SUM(d.quantity - d.qty_received), 0) AS quantity_remaining
			FROM " . ConsignmentInDetail::model()->tableName() . " d
			WHERE t.id = d.consignment_in_id
			GROUP BY d.consignment_in_id
			HAVING quantity_remaining > 0
		)";
		
		$criteria->compare('id',$this->id);
		$criteria->compare('date_posting',$this->date_posting,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('consignment_in_number',$this->consignment_in_number.'%',true,'AND', false);
		$criteria->addCondition("status_document = 'Approved'");
        
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
    	        'defaultOrder' => 'date_posting DESC',
    	    ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),
		));
	}		
    
    public function getTotalRemainingQuantityReceived() {
        $totalRemaining = 0;
        
        foreach ($this->consignmentInDetails as $detail)
            $totalRemaining += $detail->qty_request_left;
        
        return ($totalRemaining = 0) ? 'Completed' : 'Partial';
    }
}