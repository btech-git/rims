<?php

/**
 * This is the model class for table "{{coa_category}}".
 *
 * The followings are the available columns in table '{{coa_category}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $coa_category_id
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
 * @property CoaSubCategory[] $coaSubCategories
 * @property Coa[] $coas
 * @property UserIdCreated $userIdCreated
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class CoaCategory extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{coa_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, code', 'required'),
            array('coa_category_id, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 50),
            array('code', 'length', 'max' => 10),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, coa_category_id, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'coaSubCategories' => array(self::HAS_MANY, 'CoaSubCategory', 'coa_category_id'),
            'coas' => array(self::HAS_MANY, 'Coa', 'coa_category_id'),
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
            'code' => 'Code',
            'coa_category_id' => 'Coa Category',
        );
    }

    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('coa_category_id', $this->coa_category_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CoaCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function getBalanceTotal($endDate, $branchId) {
        $balanceTotal = 0.00;

        foreach ($this->coas as $accountCategory) {
            $balanceTotal += $accountCategory->getBalanceTotal($endDate, $branchId);
        }

        return $balanceTotal;
    }
    
    public function getProfitLossBalance($startDate, $endDate, $branchId) {
        $balanceTotal = 0.00;
        $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $this->id, 'status' => 'Approved'));

        foreach ($coas as $account) {
            if ($account->status === 'Approved') {
                $balanceTotal +=  $account->getProfitLossBalance($startDate, $endDate, $branchId);
            }
        }

        return $balanceTotal;
    }
    
    public function getProfitLossAmount($endDate, $branchId) {
        
        $earningAmount = $this->code === 400 ? $this->getProfitLossBalance($startDate, $endDate, $branchId) : 0;
        $expenseAmount = $this->code === 500 ? $this->getProfitLossBalance($startDate, $endDate, $branchId) : 0;
        
        return $earningAmount - $expenseAmount;
    }

}
