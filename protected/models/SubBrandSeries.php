<?php

/**
 * This is the model class for table "{{sub_brand_series}}".
 *
 * The followings are the available columns in table '{{sub_brand_series}}':
 * @property integer $id
 * @property integer $sub_brand_id
 * @property string $name
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
 * @property ProductSpecificationBattery[] $productSpecificationBatteries
 * @property ProductSpecificationOil[] $productSpecificationOils
 * @property ProductSpecificationTire[] $productSpecificationTires
 * @property SubBrand $subBrand
 * @property UserIdCreated $userIdCreated
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class SubBrandSeries extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{sub_brand_series}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('sub_brand_id, name', 'required'),
            array('sub_brand_id, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, sub_brand_id, name, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productSpecificationBatteries' => array(self::HAS_MANY, 'ProductSpecificationBattery', 'sub_brand_series_id'),
            'productSpecificationOils' => array(self::HAS_MANY, 'ProductSpecificationOil', 'sub_brand_series_id'),
            'productSpecificationTires' => array(self::HAS_MANY, 'ProductSpecificationTire', 'sub_brand_series_id'),
            'subBrand' => array(self::BELONGS_TO, 'SubBrand', 'sub_brand_id'),
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
            'sub_brand_id' => 'Sub Brand',
            'name' => 'Name',
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
        $criteria->compare('sub_brand_id', $this->sub_brand_id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.name ASC',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SubBrandSeries the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
