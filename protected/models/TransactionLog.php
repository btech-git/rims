<?php

/**
 * This is the model class for table "{{transaction_log}}".
 *
 * The followings are the available columns in table '{{transaction_log}}':
 * @property integer $id
 * @property string $transaction_number
 * @property string $transaction_date
 * @property string $log_date
 * @property string $log_time
 * @property string $table_name
 * @property integer $table_id
 * @property string $new_data
 */
class TransactionLog extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{transaction_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('transaction_number, table_name, table_id', 'required'),
            array('table_id', 'numerical', 'integerOnly' => true),
            array('transaction_number', 'length', 'max' => 100),
            array('table_name', 'length', 'max' => 200),
            array('transaction_date, log_date, log_time, new_data', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, transaction_number, transaction_date, log_date, log_time, table_name, table_id, new_data', 'safe', 'on' => 'search'),
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
            'transaction_number' => 'Transaction Number',
            'transaction_date' => 'Transaction Date',
            'log_date' => 'Log Date',
            'log_time' => 'Log Time',
            'table_name' => 'Table Name',
            'table_id' => 'Table',
            'new_data' => 'New Data',
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
        $criteria->compare('transaction_date', $this->transaction_date, true);
        $criteria->compare('log_date', $this->log_date, true);
        $criteria->compare('log_time', $this->log_time, true);
        $criteria->compare('table_name', $this->table_name, true);
        $criteria->compare('table_id', $this->table_id);
        $criteria->compare('new_data', $this->new_data, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TransactionLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getTransactionLogUserCounterData($startDate, $endDate) {
        
        $sql = "SELECT user_id, controller_class, action_type, MIN(username) AS username, COUNT(*) AS counter
                FROM " . TransactionLog::model()->tableName() . "
                WHERE transaction_date BETWEEN :start_date AND :end_date AND action_type IN ('create', 'update', 'approval', 'cancel')
                GROUP BY user_id, controller_class, action_type
                ORDER BY user_id ASC, controller_class ASC, action_type ASC";
                
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));
        
        return $resultSet;
    }
}
