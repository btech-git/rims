<?php

/**
 * This is the model class for table "{{payment_type}}".
 *
 * The followings are the available columns in table '{{payment_type}}':
 * @property integer $id
 * @property string $name
 * @property string $memo
 * @property integer $coa_id
 * @property string $bank_fee_amount
 * @property integer $bank_fee_type
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
 * @property PaymentIn[] $paymentIns
 * @property PaymentOut[] $paymentOuts
 * @property Coa $coa
 * @property UserIdCreated $userIdCreated
 * @property UserIdUpdated $userIdUpdated
 * @property UserIdApproved $userIdApproved
 * @property UserIdRejected $userIdRejected
 * @property UserIdDeleted $userIdDeleted
 */
class PaymentType extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentType the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{payment_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('bank_fee_amount', 'length', 'max' => 10),
            array('name', 'length', 'max' => 60),
            array('memo', 'length', 'max' => 100),
            array('coa_id, bank_fee_type, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved', 'numerical', 'integerOnly' => true),
            array('approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, memo, coa_id, bank_fee_amount, bank_fee_type, user_id_approved, user_id_rejected, user_id_updated, user_id_deleted, user_id_created, is_deleted, is_approved, approved_datetime, rejected_datetime, updated_datetime, deleted_datetime, created_datetime', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentIns' => array(self::HAS_MANY, 'PaymentIn', 'payment_type_id'),
            'paymentOuts' => array(self::HAS_MANY, 'PaymentOut', 'payment_type_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
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
            'memo' => 'Memo',
            'coa_id' => 'COA',
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
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('coa_id', $this->coa_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getTotalAmountPaymentInRetail($transactionDate) {
        $params = array(
            ':payment_date' => $transactionDate,
            'payment_type_id' => $this->id,
        );
        
        $sql = "SELECT COALESCE(SUM(pi.payment_amount), 0) as total_amount
                FROM " . PaymentIn::model()->tableName() . " pi
                INNER JOIN " . PaymentType::model()->tableName() . " pt ON pt.id = pi.payment_type_id
                INNER JOIN " . Customer::model()->tableName() . " c ON c.id = pi.customer_id
                WHERE pi.payment_date = :payment_date AND pi.payment_type_id = :payment_type_id AND c.customer_type = 'Individual'
                GROUP BY pi.payment_type_id
                ORDER BY pi.payment_type_id";
        
        $value = Yii::app()->db->createCommand($sql)->queryScalar($params);

        return ($value === false) ? 0 : $value;
    }

    public function getBankFeeTypeConstant() {
        $constant = ''; 
        
        if ($this->bank_fee_type == 1) {
            $constant = '%';
        } elseif ($this->bank_fee_type == 2) {
            $constant = 'Rp';
        }
        
        return $constant;
    }
}
