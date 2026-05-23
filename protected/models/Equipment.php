<?php

/**
 * This is the model class for table "{{equipment}}".
 *
 * The followings are the available columns in table '{{equipment}}':
 * @property integer $id
 * @property string $name
 * @property string $purchase_date
 * @property string $maintenance_schedule
 * @property integer $period
 * @property string $status
 * @property integer $is_approved
 * @property integer $is_deleted
 * @property integer $user_id_created
 * @property integer $user_id_updated
 * @property integer $user_id_approved
 * @property integer $user_id_rejected
 * @property integer $user_id_deleted
 * @property string $created_datetime
 * @property string $updated_datetime
 * @property string $approved_datetime
 * @property string $rejected_datetime
 * @property string $deleted_datetime
 *
 * The followings are the available model relations:
 * @property ServiceEquipment[] $serviceEquipments
 * @property UserIdCreated $userIdCreated
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class Equipment extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Equipment the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{equipment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, purchase_date, maintenance_schedule, period, status', 'required'),
            array('period, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('status', 'length', 'max' => 10),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, purchase_date, maintenance_schedule, period, status, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'serviceEquipments' => array(self::HAS_MANY, 'ServiceEquipment', 'equipment_id'),
            'userIdCreated' => array(self::BELONGS_TO, 'Users', 'user_id_created'),
            'userIdUpdated' => array(self::BELONGS_TO, 'Users', 'user_id_updated'),
            'userIdApproved' => array(self::BELONGS_TO, 'Users', 'user_id_approved'),
            'userIdRejected' => array(self::BELONGS_TO, 'Users', 'user_id_rejected'),
            'userIdDeleted' => array(self::BELONGS_TO, 'Users', 'user_id_deleted'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'purchase_date' => 'Purchase Date',
            'maintenance_schedule' => 'Maintenance Schedule',
            'period' => 'Period',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('purchase_date', $this->purchase_date, true);
        $criteria->compare('maintenance_schedule', $this->maintenance_schedule, true);
        $criteria->compare('period', $this->period);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
