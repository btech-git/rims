<?php

/**
 * This is the model class for table "{{work_order_expense_detail}}".
 *
 * The followings are the available columns in table '{{work_order_expense_detail}}':
 * @property integer $id
 * @property string $amount
 * @property string $memo
 * @property string $description
 * @property integer $work_order_expense_header_id
 * @property integer $coa_id
 *
 * The followings are the available model relations:
 * @property WorkOrderExpenseHeader $workOrderExpenseHeader
 * @property Coa $coa
 */
class WorkOrderExpenseDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{work_order_expense_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('work_order_expense_header_id, description', 'required'),
            array('work_order_expense_header_id, coa_id', 'numerical', 'integerOnly' => true),
            array('amount', 'length', 'max' => 18),
            array('memo, description', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, amount, memo, work_order_expense_header_id, coa_id, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'workOrderExpenseHeader' => array(self::BELONGS_TO, 'WorkOrderExpenseHeader', 'work_order_expense_header_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'description' => 'Description',
            'amount' => 'Amount',
            'memo' => 'Memo',
            'work_order_expense_header_id' => 'Work Order Expense Header',
            'coa_id' => 'Coa',
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
        $criteria->compare('description', $this->description, true);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('work_order_expense_header_id', $this->work_order_expense_header_id);
        $criteria->compare('coa_id', $this->coa_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return WorkOrderExpenseDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
