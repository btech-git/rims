<?php

/**
 * This is the model class for table "{{stock_adjustment_}}".
 *
 * The followings are the available columns in table '{{stock_adjustment_}}':
 * @property integer $id
 * @property string $stock_adjustment_number
 * @property string $date_posting
 * @property integer $branch_id
 * @property integer $branch_id_destination
 * @property integer $warehouse_id
 * @property integer $user_id
 * @property integer $supervisor_id
 * @property string $status
 * @property string $note
 * @property string $transaction_type
 * @property string $created_datetime
 * 
 * @property StockAdjustmentDetail[] $stockAdjustmentDetails
 * @property Warehouse $warehouse
 * @property Branch $branch
 * @property BranchIdDestination $branchIdDestination
 * @property User $user
 * @property Supervisor $supervisor
 */
class StockAdjustmentHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'SA';

    /**
     * @return string the associated database table name
     */
    public $supervisor_name;
    public $username_name;
    public $branch_name;
    public $search_product;

    // public $supervisor_name;

    public function tableName() {
        return '{{stock_adjustment_header}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stock_adjustment_number, date_posting, branch_id, warehouse_id, user_id, status', 'required'),
            array('branch_id, warehouse_id, user_id, supervisor_id, branch_id_destination', 'numerical', 'integerOnly' => true),
            array('stock_adjustment_number, status, transaction_type', 'length', 'max' => 30),
            array('stock_adjustment_number', 'unique'),
            array('note, search_product', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, stock_adjustment_number, date_posting, created_datetime, branch_id, branch_id_destination, warehouse_id, user_id, supervisor_id, username_name, supervisor_name,branch_name,status, note, transaction_type, search_product', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'stockAdjustmentDetails' => array(self::HAS_MANY, 'StockAdjustmentDetail', 'stock_adjustment_header_id'),
            'supervisor' => array(self::BELONGS_TO, 'User', 'supervisor_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'branchIdDestination' => array(self::BELONGS_TO, 'Branch', 'branch_id_destination'),
            'warehouse' => array(self::BELONGS_TO, 'Warehouse', 'warehouse_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'stock_adjustment_number' => 'Stock Adjustment Number',
            'date_posting' => 'Date Posting',
            'branch_id' => 'Branch',
            'warehouse_id' => 'Warehouse',
            'user_id' => 'User',
            'supervisor_id' => 'Supervisor',
            'status' => 'Status',
            'note' => 'Note',
            'transaction_type' => 'Transaction Type',
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.stock_adjustment_number', $this->stock_adjustment_number, true);
        $criteria->compare('t.date_posting', $this->date_posting, true);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.transaction_type', $this->transaction_type, true);

        $criteria->together = 'true';
        $criteria->with = array('branch', 'user');
        $criteria->addSearchCondition('user.username', $this->supervisor_name, true);
        $criteria->addSearchCondition('user.username', $this->username_name, true);
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
                    'supervisor_name' => array(
                        'asc' => 'user.username ASC',
                        'desc' => 'user.username DESC',
                    ),
                    'username_name' => array(
                        'asc' => 'user.username ASC',
                        'desc' => 'user.username DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function searchByPendingJournal() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.stock_adjustment_number', $this->stock_adjustment_number, true);
        $criteria->compare('t.date_posting', $this->date_posting, true);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('t.warehouse_id', $this->warehouse_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status, true);
        $criteria->compare('t.note', $this->note, true);
        $criteria->compare('t.transaction_type', $this->transaction_type, true);

        $criteria->addCondition("t.status = 'Approved' AND substring(t.stock_adjustment_number, 1, (length(t.stock_adjustment_number) - 2)) NOT IN (
            SELECT substring(kode_transaksi, 1, (length(kode_transaksi) - 2))  
            FROM " . JurnalUmum::model()->tableName() . "
        )");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'date_posting DESC',
            ),
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
    }

    protected function afterSave() {
        if ($this->isNewRecord) {
            $stockApproval = new StockAdjustmentApproval();
            $stockApproval->stock_adjustment_header_id = $this->id;
            $stockApproval->revision = 1;
            $stockApproval->approval_type = 'Draft';
            $stockApproval->date = date("Y-m-d");
            $stockApproval->supervisor_id = Yii::app()->user->getId();
            $stockApproval->note = 'First Approval Insert';
            $stockApproval->save();
        }
        return parent::afterSave();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StockAdjustmentHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(stock_adjustment_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(stock_adjustment_number, '/', 2), '/', -1), '.', -1)";
        $stockAdjustmentHeader = StockAdjustmentHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($stockAdjustmentHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $stockAdjustmentHeader->branch->code;
            $this->stock_adjustment_number = $stockAdjustmentHeader->stock_adjustment_number;
        }

        $this->setCodeNumberByNext('stock_adjustment_number', $branchCode, StockAdjustmentHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function getProducts() {
        $products = array();

        foreach ($this->stockAdjustmentDetails as $detail) {
            $products[] = $detail->product->name . ', ';
        }

        return $this->search_product = implode('', $products);
    }
}
