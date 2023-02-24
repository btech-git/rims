<?php

/**
 * This is the model class for table "{{employee_branch_division_position_level}}".
 *
 * The followings are the available columns in table '{{employee_branch_division_position_level}}':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $branch_id
 * @property integer $division_id
 * @property integer $position_id
 * @property integer $level_id
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Division $division
 * @property Position $position
 * @property Level $level
 * @property Branch $branch
 */
class EmployeeBranchDivisionPositionLevel extends CActiveRecord {

    public $employee_name;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EmployeeBranchDivisionPositionLevel the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_branch_division_position_level}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employee_id, branch_id, division_id, position_id, level_id', 'required'),
            array('employee_id, branch_id, division_id, position_id, level_id', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, employee_id, branch_id, division_id, position_id, level_id, status, employee_name', 'safe', 'on' => 'search'),
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
            'division' => array(self::BELONGS_TO, 'Division', 'division_id'),
            'position' => array(self::BELONGS_TO, 'Position', 'position_id'),
            'level' => array(self::BELONGS_TO, 'Level', 'level_id'),
            'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'employee_id' => 'Employee',
            'branch_id' => 'Branch',
            'division_id' => 'Division',
            'position_id' => 'Position',
            'level_id' => 'Level',
            'branch_id' => 'Branch',
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
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('branch_id', $this->branch_id);
        $criteria->compare('division_id', $this->division_id);
        $criteria->compare('position_id', $this->position_id);
        $criteria->compare('level_id', $this->level_id);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);

        $criteria->together = 'true';
        $criteria->with = array('employee');
        $criteria->compare('employee.name', $this->employee_name, true);
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
