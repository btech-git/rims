<?php

/**
 * This is the model class for table "{{movement_in_header}}".
 *
 * The followings are the available columns in table '{{movement_in_header}}':
 * @property integer $id
 * @property string $movement_in_number
 * @property string $date_posting
 * @property integer $branch_id
 * @property integer $movement_type
 * @property integer $return_item_id
 * @property integer $receive_item_id
 * @property integer $user_id
 * @property integer $supervisor_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property MovementInApproval[] $movementInApprovals
 * @property MovementInDetail[] $movementInDetails
 * @property Branch $branch
 * @property TransactionReceiveItem $receiveItem
 * @property TransactionReturnItem $returnItem
 */
class MovementInHeader extends MonthlyTransactionActiveRecord {

    const CONSTANT = 'MI';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MovementInHeader the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{movement_in_header}}';
    }

    public $receive_item_number;
    public $return_item_number;
    public $branch_name;
    public $user_name;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('movement_in_number, date_posting, branch_id, movement_type, user_id, status', 'required'),
            array('branch_id, movement_type, return_item_id, receive_item_id, user_id, supervisor_id', 'numerical', 'integerOnly' => true),
            array('movement_in_number, status', 'length', 'max' => 30),
            array('movement_in_number', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, movement_in_number, date_posting, branch_id, movement_type, return_item_id, receive_item_id, user_id, supervisor_id, status, receive_item_number,return_item_number', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'movementInApprovals' => array(self::HAS_MANY, 'MovementInApproval', 'movement_in_id'),
            'movementInDetails' => array(self::HAS_MANY, 'MovementInDetail', 'movement_in_header_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
            'receiveItem' => array(self::BELONGS_TO, 'TransactionReceiveItem', 'receive_item_id'),
            'returnItem' => array(self::BELONGS_TO, 'TransactionReturnItem', 'return_item_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'movement_in_number' => 'Movement In Number',
            'date_posting' => 'Date Posting',
            'branch_id' => 'Branch',
            'movement_type' => 'Movement Type',
            'return_item_id' => 'Return Item',
            'receive_item_id' => 'Receive Item',
            'user_id' => 'User',
            'supervisor_id' => 'Supervisor',
            'status' => 'Status',
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
        $criteria->compare('t.movement_in_number', $this->movement_in_number, true);
        $criteria->compare('t.date_posting', $this->date_posting, true);
        $criteria->compare('t.branch_id', $this->branch_id);
        $criteria->compare('movement_type', $this->movement_type);
        $criteria->compare('return_item_id', $this->return_item_id);
        $criteria->compare('t.receive_item_id', $this->receive_item_id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.supervisor_id', $this->supervisor_id);
        $criteria->compare('t.status', $this->status, true);


        $criteria->together = 'true';
        $criteria->with = array('receiveItem', 'branch', 'returnItem');
        $criteria->addSearchCondition('receiveItem.receive_item_no', $this->receive_item_number, true);
        $criteria->addSearchCondition('returnItem.return_item_number', $this->return_item_number, true);
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
                    'receive_item_number' => array(
                        'asc' => 'receiveItem.receive_item_no ASC',
                        'desc' => 'receiveItem.receive_item_no DESC',
                    ),
                    'return_item_number' => array(
                        'asc' => 'returnItem.return_item_no ASC',
                        'desc' => 'returnItem.return_item_no DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    public function getMovementType($type) {
        switch($type) {
            case 1: return 'Receive Item';
            case 2: return 'Return Item';
            default: return '';
        }
    }
}
