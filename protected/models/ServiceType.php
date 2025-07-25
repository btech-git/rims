<?php

/**
 * This is the model class for table "{{service_type}}".
 *
 * The followings are the available columns in table '{{service_type}}':
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $code
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property integer $coa_id
 * @property integer $coa_diskon_service
 * @property integer $is_approved
 * @property integer $user_id_approval
 * @property string $date_time_approval
 * @property integer $is_rejected
 * @property integer $user_id_reject
 * @property string $date_time_reject
 *
 * The followings are the available model relations:
 * @property CustomerServiceRate[] $customerServiceRates
 * @property Service[] $services
 * @property ServiceCategory[] $serviceCategories
 * @property Coa $coa
 * @property Coa $coaDiskonService
 * @property UserIdApproval $userIdApproval
 * @property UserIdReject $userIdReject
 */
class ServiceType extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{service_type}}';
    }

    public $coa_name;
    public $coa_code;
    public $coa_diskon_service_name;
    public $coa_diskon_service_code;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, code, is_approved', 'required'),
            array('is_deleted, deleted_by, coa_id, coa_diskon_service, is_approved, user_id_approval, is_rejected, user_id_reject', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 100),
            array('status', 'length', 'max' => 10),
            array('code', 'length', 'max' => 20),
            array('deleted_at, date_time_approval, date_time_reject', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, status, code, is_deleted, deleted_at, deleted_by, coa_id, coa_diskon_service, deleted_by, coa_name, coa_code, coa_diskon_service,coa_diskon_service_name,coa_diskon_service_code, is_approved, user_id_approval, date_time_approval, user_id_reject, date_time_reject, is_rejected', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors() {
        return array(
            'SoftDelete' => array('class' => 'application.components.behaviors.SoftDeleteBehavior'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'customerServiceRates' => array(self::HAS_MANY, 'CustomerServiceRate', 'service_type_id'),
            'services' => array(self::HAS_MANY, 'Service', 'service_type_id'),
            'serviceCategories' => array(self::HAS_MANY, 'ServiceCategory', 'service_type_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'coaDiskonService' => array(self::BELONGS_TO, 'Coa', 'coa_diskon_service'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
            'userIdReject' => array(self::BELONGS_TO, 'Users', 'user_id_reject'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'code' => 'Code',
            'is_deleted' => 'Is Deleted',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'coa_id' => 'Coa',
            'coa_diskon_service' => 'Coa Diskon Service',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('LOWER(status)', strtolower($this->status), FALSE);
        $tampilkan = ($this->is_deleted == 1) ? array(0, 1) : array(0);
        $criteria->addInCondition('t.is_deleted', $tampilkan);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('coa_diskon_service', $this->coa_diskon_service);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.user_id_reject', $this->user_id_reject);

        $criteria->together = 'true';
        $criteria->with = array('coa', 'coaDiskonService');
        $criteria->compare('coa.name', $this->coa_name, true);
        $criteria->compare('coa.code', $this->coa_code, true);
        $criteria->compare('coaDiskonService.name', $this->coa_diskon_service_name, true);
        $criteria->compare('coaDiskonService.code', $this->coa_diskon_service_code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ServiceType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
