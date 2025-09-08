<?php

/**
 * This is the model class for table "{{employee_dayoff}}".
 *
 * The followings are the available columns in table '{{employee_dayoff}}':
 * @property integer $id
 * @property string $transaction_number
 * @property integer $employee_id
 * @property double $day
 * @property string $notes
 * @property string $date_from
 * @property string $date_to
 * @property string $status
 * @property string $off_type
 * @property string $date_created
 * @property string $time_created
 * @property integer $user_id
 * @property integer $employee_onleave_category_id
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Users $user
 * @property EmployeeOnleaveCategory $employeeOnleaveCategory
 * @property EmployeeDayoffApproval[] $employeeDayoffApprovals
 * @property EmployeeDayoffImages[] $employeeDayoffImages
 */
class EmployeeDayoff extends CActiveRecord {
    public $images;

    const STATUS_ACTIVE = 0;
    const STATUS_INACTIVE = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_dayoff}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, employee_id, day, notes, date_from, date_to, off_type, date_created, time_created, user_id, employee_onleave_category_id', 'required'),
            array('employee_id, user_id, employee_onleave_category_id', 'numerical', 'integerOnly' => true),
            array('day', 'numerical'),
            array('transaction_number', 'length', 'max' => 50),
            array('status, off_type', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, employee_id, day, notes, date_from, date_to, status, off_type, date_created, time_created, user_id, employee_onleave_category_id, images', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'employeeOnleaveCategory' => array(self::BELONGS_TO, 'EmployeeOnleaveCategory', 'employee_onleave_category_id'),
            'employeeDayoffApprovals' => array(self::HAS_MANY, 'EmployeeDayoffApproval', 'employee_dayoff_id'),
            'employeeDayoffImages' => array(self::HAS_MANY, 'EmployeeDayoffImages', 'employee_dayoff_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'transaction_number' => 'Transaction Number',
            'employee_id' => 'Employee',
            'day' => 'Day',
            'notes' => 'Notes',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'status' => 'Status',
            'off_type' => 'Off Type',
            'date_created' => 'Date Created',
            'time_created' => 'Time Created',
            'user_id' => 'User',
            'employee_onleave_category_id' => 'Employee Onleave Category',
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
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('day', $this->day);
        $criteria->compare('notes', $this->notes, true);
        $criteria->compare('date_from', $this->date_from, true);
        $criteria->compare('date_to', $this->date_to, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('off_type', $this->off_type, true);
        $criteria->compare('date_created', $this->date_created, true);
        $criteria->compare('time_created', $this->time_created, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('employee_onleave_category_id', $this->employee_onleave_category_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmployeeDayoff the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function generateCodeNumber($currentMonth, $currentYear) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $employeeDayoff = EmployeeDayoff::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth]),
        ));

        if ($employeeDayoff != null) {
            $this->transaction_number = $employeeDayoff->transaction_number;
        }

        $this->setCodeNumberByNext('transaction_number', $this->employee->branch_id, self::CONSTANT, $currentMonth, $currentYear);
    }
}
