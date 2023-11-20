<?php

/**
 * This is the model class for table "{{employee_attendance}}".
 *
 * The followings are the available columns in table '{{employee_attendance}}':
 * @property integer $id
 * @property integer $employee_id
 * @property integer $user_id
 * @property string $date
 * @property string $login_time
 * @property string $logout_time
 * @property double $total_hour
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Employee $employee
 * @property Users $user
 */
class EmployeeAttendance extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_attendance}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employee_id, user_id, date, login_time, logout_time, total_hour, notes', 'required'),
            array('employee_id, user_id', 'numerical', 'integerOnly' => true),
            array('total_hour', 'numerical'),
            array('notes', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, employee_id, user_id, date, login_time, logout_time, total_hour, notes', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'employee' => array(self::BELONGS_TO, 'Employee', 'employee_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'employee_id' => 'Employee',
            'user_id' => 'User',
            'date' => 'Date',
            'login_time' => 'Login Time',
            'logout_time' => 'Logout Time',
            'total_hour' => 'Total Hour',
            'notes' => 'Notes',
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
        $criteria->compare('employee_id', $this->employee_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('login_time', $this->login_time, true);
        $criteria->compare('logout_time', $this->logout_time, true);
        $criteria->compare('total_hour', $this->total_hour);
        $criteria->compare('notes', $this->notes, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmployeeAttendance the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
