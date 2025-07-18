<?php

/**
 * This is the model class for table "{{user_log}}".
 *
 * The followings are the available columns in table '{{user_log}}':
 * @property integer $id
 * @property integer $user_id_target
 * @property string $username_target
 * @property string $log_date
 * @property string $log_time
 * @property string $table_name
 * @property integer $table_id
 * @property string $new_data
 * @property integer $user_id
 * @property string $username
 * @property string $controller_class
 * @property string $action_name
 */
class UserLog extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{user_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('log_date, log_time, table_name, table_id, new_data, user_id, username, user_id_target, username_target, controller_class, action_name', 'required'),
            array('table_id, user_id, user_id_target', 'numerical', 'integerOnly' => true),
            array('table_name', 'length', 'max' => 200),
            array('username, username_target', 'length', 'max' => 60),
            array('controller_class, action_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, log_date, log_time, table_name, table_id, new_data, user_id, username, user_id_target, username_target, controller_class, action_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'user_id_target' => 'User Target',
            'username_target' => 'Username Target',
            'log_date' => 'Log Date',
            'log_time' => 'Log Time',
            'table_name' => 'Table Name',
            'table_id' => 'Table',
            'new_data' => 'New Data',
            'user_id' => 'User',
            'username' => 'Username',
            'controller_class' => 'Controller Class',
            'action_name' => 'Action Name',
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
        $criteria->compare('user_id_target', $this->user_id_target);
        $criteria->compare('username_target', $this->username_target, true);
        $criteria->compare('log_date', $this->log_date, true);
        $criteria->compare('log_time', $this->log_time, true);
        $criteria->compare('table_name', $this->table_name, true);
        $criteria->compare('table_id', $this->table_id);
        $criteria->compare('new_data', $this->new_data, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('controller_class', $this->controller_class, true);
        $criteria->compare('action_name', $this->action_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
