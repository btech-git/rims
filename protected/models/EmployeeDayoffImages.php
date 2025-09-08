<?php

/**
 * This is the model class for table "{{employee_dayoff_images}}".
 *
 * The followings are the available columns in table '{{employee_dayoff_images}}':
 * @property integer $id
 * @property integer $employee_dayoff_id
 * @property string $extension
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property EmployeeDayoff $employeeDayoff
 */
class EmployeeDayoffImages extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{employee_dayoff_images}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('employee_dayoff_id, extension', 'required'),
            array('employee_dayoff_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('extension', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, employee_dayoff_id, extension, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'employeeDayoff' => array(self::BELONGS_TO, 'EmployeeDayoff', 'employee_dayoff_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'employee_dayoff_id' => 'Employee Dayoff',
            'extension' => 'Extension',
            'is_inactive' => 'Is Inactive',
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
        $criteria->compare('employee_dayoff_id', $this->employee_dayoff_id);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EmployeeDayoffImages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getFilename() {
        return $this->id . '.' . $this->extension;
    }
}
